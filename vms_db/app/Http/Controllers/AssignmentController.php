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
        ]);

        $date = $request->date;
        $objective = $request->objective;
        $menu = $request->menu;

        // Get all volunteers with their skills
        $volunteers = Volunteer::all();

        // Filter volunteers based on availability (simplified - you might want to add availability logic)
        $availableVolunteers = $volunteers->filter(function ($volunteer) {
            // Add availability check logic here
            return true; // For now, assume all are available
        });

        // Generate assignments based on skills
        $assignments = $this->generateAssignmentsFromSkills($availableVolunteers, $objective);

        return response()->json($assignments);
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

    private function generateAssignmentsFromSkills($volunteers, $objective)
    {
        // Define role requirements based on objective
        $roleRequirements = $this->calculateRoleRequirements($objective);

        // Categorize volunteers by skills
        $skillCategories = $this->categorizeVolunteersBySkills($volunteers);

        // Assign coordinators first (people with leadership skills)
        $coordinators = $this->assignCoordinators($skillCategories);

        // Assign team members based on skills and requirements
        $assignments = $this->assignTeamMembers($skillCategories, $roleRequirements, $coordinators);

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

    private function assignCoordinators($skillCategories)
    {
        $coordinators = [];

        // Mobile Kitchen Coordinator
        if (! empty($skillCategories['leader'])) {
            $coordinators['mk_coordinator'] = array_shift($skillCategories['leader'])['name'];
        } else {
            $coordinators['mk_coordinator'] = 'TBD';
        }

        // AM Distribution Coordinator
        if (! empty($skillCategories['leader'])) {
            $coordinators['am_coordinator'] = array_shift($skillCategories['leader'])['name'];
        } else {
            $coordinators['am_coordinator'] = 'TBD';
        }

        // PM Distribution Coordinator
        if (! empty($skillCategories['leader'])) {
            $coordinators['pm_coordinator'] = array_shift($skillCategories['leader'])['name'];
        } else {
            $coordinators['pm_coordinator'] = 'TBD';
        }

        return $coordinators;
    }

    private function assignTeamMembers($skillCategories, $requirements, $coordinators)
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

        // Assign Mobile Kitchen roles
        $assignments['mobile_kitchen']['kitchen_truck'] = $this->assignRoleMembers(
            array_merge($skillCategories['driver'], $skillCategories['cook']),
            $requirements['mobile_kitchen']['kitchen_truck']
        );

        $assignments['mobile_kitchen']['food_prep'] = $this->assignRoleMembers(
            $skillCategories['prep'],
            $requirements['mobile_kitchen']['food_prep']
        );

        $assignments['mobile_kitchen']['volunteer_care'] = $this->assignRoleMembers(
            $skillCategories['care'],
            $requirements['mobile_kitchen']['volunteer_care']
        );

        $assignments['mobile_kitchen']['wash_cleanup'] = $this->assignRoleMembers(
            $skillCategories['cleanup'],
            $requirements['mobile_kitchen']['wash_cleanup']
        );

        $assignments['mobile_kitchen']['inventory'] = $this->assignRoleMembers(
            $skillCategories['logistics'],
            $requirements['mobile_kitchen']['inventory']
        );

        // Assign AM Distribution roles
        $assignments['am_distribution']['team_alpha'] = $this->assignRoleMembers(
            $skillCategories['leader'],
            $requirements['am_distribution']['team_alpha']
        );

        $assignments['am_distribution']['team_bravo'] = $this->assignRoleMembers(
            array_merge($skillCategories['driver'], $skillCategories['dist']),
            $requirements['am_distribution']['team_bravo']
        );

        $assignments['am_distribution']['team_charlie1'] = $this->assignRoleMembers(
            array_merge($skillCategories['leader'], $skillCategories['dist']),
            $requirements['am_distribution']['team_charlie1']
        );

        $assignments['am_distribution']['team_charlie2'] = $this->assignRoleMembers(
            array_merge($skillCategories['driver'], $skillCategories['dist']),
            $requirements['am_distribution']['team_charlie2']
        );

        // Assign PM Distribution roles
        $assignments['pm_distribution']['team_delta1'] = $this->assignRoleMembers(
            array_merge($skillCategories['leader'], $skillCategories['dist']),
            $requirements['pm_distribution']['team_delta1']
        );

        $assignments['pm_distribution']['team_delta2'] = $this->assignRoleMembers(
            array_merge($skillCategories['driver'], $skillCategories['dist']),
            $requirements['pm_distribution']['team_delta2']
        );

        $assignments['pm_distribution']['team_echo'] = $this->assignRoleMembers(
            array_merge($skillCategories['leader'], $skillCategories['dist']),
            $requirements['pm_distribution']['team_echo']
        );

        $assignments['pm_distribution']['team_foxtrot'] = $this->assignRoleMembers(
            $skillCategories['driver'],
            $requirements['pm_distribution']['team_foxtrot']
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
}
