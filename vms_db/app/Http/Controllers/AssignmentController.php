<?php

namespace App\Http\Controllers;

use App\Models\OrgChart;
use App\Models\Volunteer;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function show()
    {
        return view('auto-assignments');
    }

    public function generate(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'objective' => 'required|integer|min:1',
            'menu' => 'required|string',
            'balance_teams' => 'boolean',
            'prioritize_experience' => 'boolean',
            'avoid_conflicts' => 'boolean',
        ]);

        $date = $request->date;
        $objective = $request->objective;
        $menu = $request->menu;
        $balanceTeams = $request->boolean('balance_teams', true);
        $prioritizeExperience = $request->boolean('prioritize_experience', true);
        $avoidConflicts = $request->boolean('avoid_conflicts', true);

        // Get all volunteers with their skills
        $volunteers = Volunteer::all();

        // Filter volunteers based on availability (simplified - you might want to add availability logic)
        $availableVolunteers = $volunteers->filter(function ($volunteer) {
            // Add availability check logic here
            return true; // For now, assume all are available
        });

        // Generate assignments based on skills with options
        $assignments = $this->generateAssignmentsFromSkills($availableVolunteers, $objective, $balanceTeams, $prioritizeExperience, $avoidConflicts);

        return response()->json([
            'success' => true,
            'assignments' => $assignments,
            'date' => $date,
            'objective' => $objective,
            'menu' => $menu,
        ]);
    }

    public function save(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'objective' => 'required|integer|min:1',
            'menu' => 'required|string',
            'assignments' => 'required|array',
        ]);

        $date = $request->date;
        $objective = $request->objective;
        $menu = $request->menu;
        $assignments = $request->assignments;

        // Find or create OrgChart record for this date
        $orgChart = OrgChart::firstOrNew(['date' => $date]);

        // Map assignments to OrgChart fields
        $orgChart->objective = $objective;
        $orgChart->menu = $menu;
        $orgChart->volunteers = $assignments['totalVolunteers'] ?? 0;
        $orgChart->mobile_kitchen = $assignments['mobile_kitchen']['coordinator'] ?? 'TBD';
        $orgChart->am_distribution = $assignments['am_distribution']['coordinator'] ?? 'TBD';
        $orgChart->pm_distribution = $assignments['pm_distribution']['coordinator'] ?? 'TBD';

        // Map teams
        $teams = [];
        $teamMappings = [
            'alpha' => 'team_alpha',
            'bravo' => 'team_bravo',
            'charlie1' => 'team_charlie1',
            'charlie2' => 'team_charlie2',
            'delta1' => 'team_delta1',
            'delta2' => 'team_delta2',
            'echo' => 'team_echo',
            'foxtrot' => 'team_foxtrot',
        ];

        $teamTypes = [
            'alpha' => 'VF/GA/ANNEX',
            'bravo' => 'MAR/WBBN',
            'charlie1' => 'MASVLLE',
            'charlie2' => 'BANNA',
            'delta1' => 'arroP',
            'delta2' => 'EUCATYN',
            'echo' => 'DELPAN',
            'foxtrot' => 'PAR/SUN',
        ];

        foreach ($teamMappings as $teamKey => $assignmentKey) {
            $members = $assignments['am_distribution'][$assignmentKey] ?? $assignments['pm_distribution'][$assignmentKey] ?? [];
            $leader = ! empty($members) ? $members[0]['name'] : '';
            $memberNames = array_slice($members, 1);
            $memberNames = array_map(function ($m) {
                return $m['name'];
            }, $memberNames);

            $teams[$teamKey] = [
                'type' => $teamTypes[$teamKey] ?? '',
                'leader' => $leader,
                'members' => $memberNames,
            ];
        }

        $orgChart->teams = json_encode($teams);

        // Map kitchen roles
        $orgChart->kitchen_truck = json_encode(array_map(function ($m) {
            return $m['name'];
        }, $assignments['mobile_kitchen']['kitchen_truck'] ?? []));
        $orgChart->food_prep = json_encode(array_map(function ($m) {
            return $m['name'];
        }, $assignments['mobile_kitchen']['food_prep'] ?? []));
        $orgChart->volunteer_care = json_encode(array_map(function ($m) {
            return $m['name'];
        }, $assignments['mobile_kitchen']['volunteer_care'] ?? []));
        $orgChart->wash_cleanup = json_encode(array_map(function ($m) {
            return $m['name'];
        }, $assignments['mobile_kitchen']['wash_cleanup'] ?? []));
        $orgChart->inventory = json_encode(array_map(function ($m) {
            return $m['name'];
        }, $assignments['mobile_kitchen']['inventory'] ?? []));

        // Set defaults for other fields if not set
        if (! $orgChart->exists) {
            $orgChart->planning = 'Heidi Giague';
            $orgChart->purchasing = 'Stephanie Tan';
            $orgChart->mwc_coordinator = 'Kevin Tabares';
            $orgChart->safety_emergency = 'Sam Obmerga';
            $orgChart->meal_breakdown = json_encode(['breakfast' => 40, 'lunch' => 50, 'snacks' => 50]);
            $orgChart->vehicles = json_encode([
                ['team' => 'Alpha', 'vehicle' => 'Flexi'],
                ['team' => 'Bravo', 'vehicle' => 'Hilux'],
                ['team' => 'Charlie 1', 'vehicle' => 'Clipper'],
                ['team' => 'Charlie 2', 'vehicle' => 'Chevy'],
                ['team' => 'Delta 1', 'vehicle' => 'Hilux'],
                ['team' => 'Delta 2', 'vehicle' => 'Black'],
                ['team' => 'Echo', 'vehicle' => 'Chevy'],
                ['team' => 'Foxtrot', 'vehicle' => 'Flexi/Clipper'],
            ]);
        }

        $orgChart->save();

        return response()->json(['message' => 'Assignments saved successfully and updated in Org Chart']);
    }

    private function generateAssignmentsFromSkills($volunteers, $objective, $balanceTeams = true, $prioritizeExperience = true, $avoidConflicts = true)
    {
        // Define role requirements based on objective
        $roleRequirements = $this->calculateRoleRequirements($objective);

        // Categorize volunteers by skills and experience
        $skillCategories = $this->categorizeVolunteersBySkills($volunteers);

        // Filter available volunteers based on availability and preferences
        $availableVolunteers = $this->filterAvailableVolunteers($volunteers);

        // Assign coordinators first (people with leadership skills and experience)
        $coordinators = $this->assignCoordinators($skillCategories, $availableVolunteers);

        // Assign team members based on skills, experience, and requirements
        $assignments = $this->assignTeamMembers($skillCategories, $roleRequirements, $coordinators, $availableVolunteers, $prioritizeExperience);

        // Balance teams and resolve conflicts if enabled
        if ($balanceTeams || $avoidConflicts) {
            $assignments = $this->balanceAndOptimizeAssignments($assignments, $availableVolunteers, $avoidConflicts);
        }

        return $assignments;
    }

    private function calculateRoleRequirements($objective)
    {
        // Calculate number of people needed for each role based on meal target
        $meals = $objective;

        return [
            'mobile_kitchen' => [
                'coordinator' => 1,
                'kitchen_truck' => max(2, ceil($meals / 800)), // 1 driver + cooks
                'food_prep' => max(3, ceil($meals / 400)),
                'volunteer_care' => max(2, ceil($meals / 1200)),
                'wash_cleanup' => max(3, ceil($meals / 600)),
                'inventory' => max(2, ceil($meals / 1000)),
            ],
            'am_distribution' => [
                'coordinator' => 1,
                'team_alpha' => 1,
                'team_bravo' => 2,
                'team_charlie1' => 2,
                'team_charlie2' => 2,
            ],
            'pm_distribution' => [
                'coordinator' => 1,
                'team_delta1' => 2,
                'team_delta2' => 2,
                'team_echo' => 2,
                'team_foxtrot' => 1,
            ],
        ];
    }

    private function categorizeVolunteersBySkills($volunteers)
    {
        $categories = [
            'leader' => [],
            'driver' => [],
            'cook' => [],
            'prep' => [],
            'care' => [],
            'cleanup' => [],
            'logistics' => [],
            'dist' => [],
        ];

        foreach ($volunteers as $volunteer) {
            $skills = json_decode($volunteer->skills, true) ?? [];
            $name = $volunteer->first_name.' '.$volunteer->last_name;

            // Map skills to categories
            foreach ($skills as $skill) {
                $skill = strtolower($skill);
                if (strpos($skill, 'leader') !== false || strpos($skill, 'coordinator') !== false) {
                    $categories['leader'][] = ['name' => $name, 'skill' => 'Leader'];
                }
                if (strpos($skill, 'driver') !== false) {
                    $categories['driver'][] = ['name' => $name, 'skill' => 'Driver'];
                }
                if (strpos($skill, 'cook') !== false) {
                    $categories['cook'][] = ['name' => $name, 'skill' => 'Cook'];
                }
                if (strpos($skill, 'prep') !== false || strpos($skill, 'preparation') !== false) {
                    $categories['prep'][] = ['name' => $name, 'skill' => 'Prep'];
                }
                if (strpos($skill, 'care') !== false || strpos($skill, 'volunteer care') !== false) {
                    $categories['care'][] = ['name' => $name, 'skill' => 'Care'];
                }
                if (strpos($skill, 'cleanup') !== false || strpos($skill, 'wash') !== false) {
                    $categories['cleanup'][] = ['name' => $name, 'skill' => 'Cleanup'];
                }
                if (strpos($skill, 'logistics') !== false || strpos($skill, 'inventory') !== false) {
                    $categories['logistics'][] = ['name' => $name, 'skill' => 'Logistics'];
                }
                if (strpos($skill, 'distribution') !== false || strpos($skill, 'dist') !== false) {
                    $categories['dist'][] = ['name' => $name, 'skill' => 'Dist'];
                }
            }
        }

        return $categories;
    }

    private function assignCoordinators($skillCategories, $availableVolunteers)
    {
        $coordinators = [];

        // Find most experienced leaders for coordinator roles
        $leaders = $skillCategories['leader'] ?? [];

        // Mobile Kitchen Coordinator - prefer those with cooking/logistics experience
        $mkCandidates = array_filter($leaders, function ($leader) use ($availableVolunteers) {
            $volunteer = $availableVolunteers->find(function ($v) use ($leader) {
                return ($v->first_name.' '.$v->last_name) === $leader['name'];
            });
            if ($volunteer) {
                $skills = json_decode($volunteer->skills, true) ?? [];

                return in_array('cook', array_map('strtolower', $skills)) ||
                       in_array('logistics', array_map('strtolower', $skills));
            }

            return false;
        });

        if (! empty($mkCandidates)) {
            $coordinators['mk_coordinator'] = array_shift($mkCandidates)['name'];
            // Remove from leaders pool
            $leaders = array_filter($leaders, function ($l) use ($coordinators) {
                return $l['name'] !== $coordinators['mk_coordinator'];
            });
        } elseif (! empty($leaders)) {
            $coordinators['mk_coordinator'] = array_shift($leaders)['name'];
        } else {
            $coordinators['mk_coordinator'] = 'TBD';
        }

        // AM Distribution Coordinator
        if (! empty($leaders)) {
            $coordinators['am_coordinator'] = array_shift($leaders)['name'];
        } else {
            $coordinators['am_coordinator'] = 'TBD';
        }

        // PM Distribution Coordinator
        if (! empty($leaders)) {
            $coordinators['pm_coordinator'] = array_shift($leaders)['name'];
        } else {
            $coordinators['pm_coordinator'] = 'TBD';
        }

        return $coordinators;
    }

    private function assignTeamMembers($skillCategories, $requirements, $coordinators, $availableVolunteers, $prioritizeExperience = true)
    {
        $assignments = [
            'totalVolunteers' => 0,
            'mobile_kitchen' => [
                'coordinator' => $coordinators['mk_coordinator'],
                'kitchen_truck' => [],
                'food_prep' => [],
                'volunteer_care' => [],
                'wash_cleanup' => [],
                'inventory' => [],
            ],
            'am_distribution' => [
                'coordinator' => $coordinators['am_coordinator'],
                'team_alpha' => [],
                'team_bravo' => [],
                'team_charlie1' => [],
                'team_charlie2' => [],
            ],
            'pm_distribution' => [
                'coordinator' => $coordinators['pm_coordinator'],
                'team_delta1' => [],
                'team_delta2' => [],
                'team_echo' => [],
                'team_foxtrot' => [],
            ],
        ];

        $assignedIds = []; // Track assigned volunteer IDs to avoid double assignments

        // Assign Mobile Kitchen roles
        $assignments['mobile_kitchen']['kitchen_truck'] = $this->assignRoleMembersWithExperience(
            array_merge($skillCategories['driver'], $skillCategories['cook']),
            $requirements['mobile_kitchen']['kitchen_truck'],
            $availableVolunteers,
            $assignedIds,
            $prioritizeExperience
        );

        $assignments['mobile_kitchen']['food_prep'] = $this->assignRoleMembersWithExperience(
            $skillCategories['prep'],
            $requirements['mobile_kitchen']['food_prep'],
            $availableVolunteers,
            $assignedIds,
            $prioritizeExperience
        );

        $assignments['mobile_kitchen']['volunteer_care'] = $this->assignRoleMembersWithExperience(
            $skillCategories['care'],
            $requirements['mobile_kitchen']['volunteer_care'],
            $availableVolunteers,
            $assignedIds,
            $prioritizeExperience
        );

        $assignments['mobile_kitchen']['wash_cleanup'] = $this->assignRoleMembersWithExperience(
            $skillCategories['cleanup'],
            $requirements['mobile_kitchen']['wash_cleanup'],
            $availableVolunteers,
            $assignedIds,
            $prioritizeExperience
        );

        $assignments['mobile_kitchen']['inventory'] = $this->assignRoleMembersWithExperience(
            $skillCategories['logistics'],
            $requirements['mobile_kitchen']['inventory'],
            $availableVolunteers,
            $assignedIds,
            $prioritizeExperience
        );

        // Assign AM Distribution roles
        $assignments['am_distribution']['team_alpha'] = $this->assignRoleMembersWithExperience(
            $skillCategories['leader'],
            $requirements['am_distribution']['team_alpha'],
            $availableVolunteers,
            $assignedIds,
            $prioritizeExperience
        );

        $assignments['am_distribution']['team_bravo'] = $this->assignRoleMembersWithExperience(
            array_merge($skillCategories['driver'], $skillCategories['dist']),
            $requirements['am_distribution']['team_bravo'],
            $availableVolunteers,
            $assignedIds,
            $prioritizeExperience
        );

        $assignments['am_distribution']['team_charlie1'] = $this->assignRoleMembersWithExperience(
            array_merge($skillCategories['leader'], $skillCategories['dist']),
            $requirements['am_distribution']['team_charlie1'],
            $availableVolunteers,
            $assignedIds,
            $prioritizeExperience
        );

        $assignments['am_distribution']['team_charlie2'] = $this->assignRoleMembersWithExperience(
            array_merge($skillCategories['driver'], $skillCategories['dist']),
            $requirements['am_distribution']['team_charlie2'],
            $availableVolunteers,
            $assignedIds,
            $prioritizeExperience
        );

        // Assign PM Distribution roles
        $assignments['pm_distribution']['team_delta1'] = $this->assignRoleMembersWithExperience(
            array_merge($skillCategories['leader'], $skillCategories['dist']),
            $requirements['pm_distribution']['team_delta1'],
            $availableVolunteers,
            $assignedIds,
            $prioritizeExperience
        );

        $assignments['pm_distribution']['team_delta2'] = $this->assignRoleMembersWithExperience(
            array_merge($skillCategories['driver'], $skillCategories['dist']),
            $requirements['pm_distribution']['team_delta2'],
            $availableVolunteers,
            $assignedIds,
            $prioritizeExperience
        );

        $assignments['pm_distribution']['team_echo'] = $this->assignRoleMembersWithExperience(
            array_merge($skillCategories['leader'], $skillCategories['dist']),
            $requirements['pm_distribution']['team_echo'],
            $availableVolunteers,
            $assignedIds,
            $prioritizeExperience
        );

        $assignments['pm_distribution']['team_foxtrot'] = $this->assignRoleMembersWithExperience(
            $skillCategories['driver'],
            $requirements['pm_distribution']['team_foxtrot'],
            $availableVolunteers,
            $assignedIds,
            $prioritizeExperience
        );

        // Calculate total volunteers
        $assignments['totalVolunteers'] = $this->countTotalVolunteers($assignments);

        return $assignments;
    }

    private function assignRoleMembers($availableMembers, $requiredCount)
    {
        $assigned = [];
        $count = 0;

        foreach ($availableMembers as $member) {
            if ($count >= $requiredCount) {
                break;
            }
            $assigned[] = $member;
            $count++;
        }

        return $assigned;
    }

    private function countTotalVolunteers($assignments)
    {
        $total = 0;

        // Count coordinators
        if ($assignments['mobile_kitchen']['coordinator'] !== 'TBD') {
            $total++;
        }
        if ($assignments['am_distribution']['coordinator'] !== 'TBD') {
            $total++;
        }
        if ($assignments['pm_distribution']['coordinator'] !== 'TBD') {
            $total++;
        }

        // Count team members
        foreach ($assignments as $section => $roles) {
            if (is_array($roles)) {
                foreach ($roles as $role => $members) {
                    if (is_array($members)) {
                        $total += count($members);
                    }
                }
            }
        }

        return $total;
    }

    /**
     * Filter volunteers based on availability and other criteria
     */
    private function filterAvailableVolunteers($volunteers)
    {
        return $volunteers->filter(function ($volunteer) {
            // Check if volunteer has skills
            $skills = json_decode($volunteer->skills, true);
            if (empty($skills)) {
                return false;
            }

            // Check if volunteer is active (you can add more availability logic here)
            // For now, assume all volunteers are available
            return true;
        });
    }

    /**
     * Assign role members with experience-based prioritization
     */
    private function assignRoleMembersWithExperience($availableMembers, $requiredCount, $allVolunteers, &$assignedIds, $prioritizeExperience = true)
    {
        $assigned = [];
        $count = 0;

        if ($prioritizeExperience) {
            // Sort members by experience score (descending)
            usort($availableMembers, function ($a, $b) use ($allVolunteers) {
                $volA = $allVolunteers->find(function ($v) use ($a) {
                    return ($v->first_name.' '.$v->last_name) === $a['name'];
                });
                $volB = $allVolunteers->find(function ($v) use ($b) {
                    return ($v->first_name.' '.$v->last_name) === $b['name'];
                });

                $scoreA = $this->calculateExperienceScore($volA ?? null);
                $scoreB = $this->calculateExperienceScore($volB ?? null);

                return $scoreB <=> $scoreA; // Descending order
            });
        }

        foreach ($availableMembers as $member) {
            if ($count >= $requiredCount) {
                break;
            }

            // Find volunteer to check if already assigned
            $volunteer = $allVolunteers->find(function ($v) use ($member) {
                return ($v->first_name.' '.$v->last_name) === $member['name'];
            });

            if ($volunteer && ! in_array($volunteer->id, $assignedIds)) {
                $assigned[] = $member;
                $assignedIds[] = $volunteer->id;
                $count++;
            }
        }

        return $assigned;
    }

    /**
     * Calculate experience score for a volunteer
     */
    private function calculateExperienceScore($volunteer)
    {
        if (! $volunteer) {
            return 0;
        }

        $score = 0;

        // Base score from account age (months)
        $accountAge = now()->diffInMonths($volunteer->created_at);
        $score += min($accountAge, 24); // Cap at 24 months

        // Bonus for multiple skills
        $skills = json_decode($volunteer->skills, true) ?? [];
        $score += count($skills) * 2;

        // Bonus for leadership skills
        if (in_array('leadership', array_map('strtolower', $skills))) {
            $score += 5;
        }

        // Bonus for specialized skills
        $specializedSkills = ['driver', 'cook', 'logistics'];
        foreach ($specializedSkills as $skill) {
            if (in_array($skill, array_map('strtolower', $skills))) {
                $score += 3;
            }
        }

        return $score;
    }

    /**
     * Balance and optimize assignments to prevent conflicts and ensure fairness
     */
    private function balanceAndOptimizeAssignments($assignments, $availableVolunteers, $avoidConflicts = true)
    {
        if ($avoidConflicts) {
            // Check for over-assigned volunteers and rebalance if necessary
            $volunteerAssignments = $this->countVolunteerAssignments($assignments, $availableVolunteers);

            // If any volunteer is assigned to more than one major role, try to rebalance
            foreach ($volunteerAssignments as $volunteerId => $count) {
                if ($count > 1) {
                    $assignments = $this->rebalanceOverassignedVolunteer($assignments, $volunteerId, $availableVolunteers);
                }
            }
        }

        // Ensure minimum team sizes are met
        $assignments = $this->ensureMinimumTeamSizes($assignments, $availableVolunteers);

        return $assignments;
    }

    /**
     * Count how many assignments each volunteer has
     */
    private function countVolunteerAssignments($assignments, $availableVolunteers)
    {
        $counts = [];

        foreach ($assignments as $section => $roles) {
            if (is_array($roles)) {
                foreach ($roles as $role => $members) {
                    if (is_array($members)) {
                        foreach ($members as $member) {
                            $volunteer = $availableVolunteers->find(function ($v) use ($member) {
                                return ($v->first_name.' '.$v->last_name) === $member['name'];
                            });
                            if ($volunteer) {
                                $counts[$volunteer->id] = ($counts[$volunteer->id] ?? 0) + 1;
                            }
                        }
                    }
                }
            }
        }

        return $counts;
    }

    /**
     * Rebalance assignments when a volunteer is over-assigned
     */
    private function rebalanceOverassignedVolunteer($assignments, $volunteerId, $availableVolunteers)
    {
        $volunteer = $availableVolunteers->find(function ($v) use ($volunteerId) {
            return $v->id === $volunteerId;
        });

        if (! $volunteer) {
            return $assignments;
        }

        $volunteerName = $volunteer->first_name.' '.$volunteer->last_name;

        // Find all roles this volunteer is assigned to
        $assignedRoles = [];
        foreach ($assignments as $section => &$roles) {
            if (is_array($roles)) {
                foreach ($roles as $role => &$members) {
                    if (is_array($members)) {
                        foreach ($members as $key => $member) {
                            if ($member['name'] === $volunteerName) {
                                $assignedRoles[] = [
                                    'section' => $section,
                                    'role' => $role,
                                    'key' => $key,
                                    'member' => $member,
                                ];
                            }
                        }
                    }
                }
            }
        }

        // Keep the most suitable role and remove from others
        if (count($assignedRoles) > 1) {
            // Sort by priority (coordinators > specialized roles > general roles)
            usort($assignedRoles, function ($a, $b) {
                $priorityA = $this->getRolePriority($a['role']);
                $priorityB = $this->getRolePriority($b['role']);

                return $priorityB <=> $priorityA;
            });

            // Keep the highest priority role, remove others
            for ($i = 1; $i < count($assignedRoles); $i++) {
                $role = $assignedRoles[$i];
                unset($assignments[$role['section']][$role['role']][$role['key']]);
                // Reindex array
                $assignments[$role['section']][$role['role']] = array_values($assignments[$role['section']][$role['role']]);
            }
        }

        return $assignments;
    }

    /**
     * Get priority score for a role (higher = more important)
     */
    private function getRolePriority($role)
    {
        $priorities = [
            'coordinator' => 10,
            'kitchen_truck' => 8,
            'team_alpha' => 7,
            'team_bravo' => 6,
            'team_charlie1' => 6,
            'team_charlie2' => 6,
            'team_delta1' => 5,
            'team_delta2' => 5,
            'team_echo' => 5,
            'team_foxtrot' => 5,
            'food_prep' => 4,
            'volunteer_care' => 3,
            'wash_cleanup' => 3,
            'inventory' => 3,
        ];

        return $priorities[$role] ?? 1;
    }

    /**
     * Ensure minimum team sizes are met by filling gaps with available volunteers
     */
    private function ensureMinimumTeamSizes($assignments, $availableVolunteers)
    {
        $minimumSizes = [
            'mobile_kitchen' => [
                'kitchen_truck' => 2,
                'food_prep' => 3,
                'volunteer_care' => 2,
                'wash_cleanup' => 3,
                'inventory' => 2,
            ],
            'am_distribution' => [
                'team_alpha' => 1,
                'team_bravo' => 2,
                'team_charlie1' => 2,
                'team_charlie2' => 2,
            ],
            'pm_distribution' => [
                'team_delta1' => 2,
                'team_delta2' => 2,
                'team_echo' => 2,
                'team_foxtrot' => 1,
            ],
        ];

        foreach ($minimumSizes as $section => $roles) {
            foreach ($roles as $role => $minSize) {
                $currentSize = count($assignments[$section][$role] ?? []);

                if ($currentSize < $minSize) {
                    // Find available volunteers not yet assigned
                    $assignedNames = [];
                    foreach ($assignments as $s => $r) {
                        if (is_array($r)) {
                            foreach ($r as $roleName => $members) {
                                if (is_array($members)) {
                                    foreach ($members as $member) {
                                        $assignedNames[] = $member['name'];
                                    }
                                }
                            }
                        }
                    }

                    $availableVolunteersList = $availableVolunteers->filter(function ($v) use ($assignedNames) {
                        return ! in_array($v->first_name.' '.$v->last_name, $assignedNames);
                    });

                    // Add volunteers to meet minimum size
                    $needed = $minSize - $currentSize;
                    $added = 0;

                    foreach ($availableVolunteersList as $volunteer) {
                        if ($added >= $needed) {
                            break;
                        }

                        $assignments[$section][$role][] = [
                            'name' => $volunteer->first_name.' '.$volunteer->last_name,
                            'skill' => 'General',
                        ];
                        $added++;
                    }
                }
            }
        }

        return $assignments;
    }
}
