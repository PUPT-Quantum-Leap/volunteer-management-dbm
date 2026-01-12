<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrgChart;
use App\Models\Volunteer;
use Illuminate\Support\Facades\Log;

class OrgChartController extends Controller
{
    public function show()
    {
        // Fetch the latest org chart data from the database
        $orgData = OrgChart::latest()->first();

        // Permanent names
        $permanentData = [
            'responsibleOfficial' => 'Paul Giague',
            'incidentCommander' => 'Catherine Tolentino',
        ];

        // If no data in DB, use defaults or empty
        if (!$orgData) {
            $orgData = (object) [
                'objective' => '2400',
                'menu' => 'Champorado',
                'date' => '2025-11-22',
                'volunteers' => 46,
                'planning' => 'Heidi Giague',
                'purchasing' => 'Stephanie Tan',
                'mwc_coordinator' => 'Kevin Tabares',
                'safety_emergency' => 'Sam Obmerga',
                'mobile_kitchen' => 'Elisa Aquino',
                'am_distribution' => 'Steph Tan',
                'pm_distribution' => 'Steph Tan',
                'teams' => [
                    'alpha' => ['type' => 'VF/GA/ANNEX', 'leader' => 'Kevin', 'members' => []],
                    'bravo' => ['type' => 'MAR/WBBN', 'leader' => 'John', 'members' => ['Blessing', 'Natasya', 'Jhoy2', 'Evenmae']],
                    'charlie1' => ['type' => 'MASVLLE', 'leader' => 'Sam', 'members' => ['Michay', 'Aly']],
                    'charlie2' => ['type' => 'BANNA', 'leader' => 'Orly', 'members' => ['Daniel', 'Rhia']],
                    'delta1' => ['type' => 'arroP', 'leader' => 'Cedie', 'members' => ['Lady']],
                    'delta2' => ['type' => 'EUCATYN', 'leader' => 'Michael S', 'members' => ['Karl', 'Aly']],
                    'echo' => ['type' => 'DELPAN', 'leader' => 'John', 'members' => ['Cath', 'Johan']],
                    'foxtrot' => ['type' => 'PAR/SUN', 'leader' => '', 'members' => []]
                ],
                'kitchen_truck' => ['Miah', 'Jones', 'Sam Rice', 'Blessing'],
                'food_prep' => ['Teresa', 'Cath', 'Natasya', 'Michay', 'Aly', 'Evenmae'],
                'volunteer_care' => ['Myrrh', 'Rhia', 'Lady'],
                'wash_cleanup' => ['Orly', 'John', 'Daniel', 'Ariel'],
                'inventory' => ['Beth', 'Nestor', 'Johan (pm)'],
                'meal_breakdown' => ['breakfast' => 40, 'lunch' => 50, 'snacks' => 50],
                'vehicles' => [
                    ['team' => 'Alpha', 'vehicle' => 'Flexi'],
                    ['team' => 'Bravo', 'vehicle' => 'Hilux'],
                    ['team' => 'Charlie 1', 'vehicle' => 'Clipper'],
                    ['team' => 'Charlie 2', 'vehicle' => 'Chevy'],
                    ['team' => 'Delta 1', 'vehicle' => 'Hilux'],
                    ['team' => 'Delta 2', 'vehicle' => 'Black'],
                    ['team' => 'Echo', 'vehicle' => 'Chevy'],
                    ['team' => 'Foxtrot', 'vehicle' => 'Flexi/Clipper']
                ]
            ];
        } else {
            // Decode JSON fields
            $orgData->teams = json_decode($orgData->teams, true);
            $orgData->kitchen_truck = json_decode($orgData->kitchen_truck, true);
            $orgData->food_prep = json_decode($orgData->food_prep, true);
            $orgData->volunteer_care = json_decode($orgData->volunteer_care, true);
            $orgData->wash_cleanup = json_decode($orgData->wash_cleanup, true);
            $orgData->inventory = json_decode($orgData->inventory, true);
            $orgData->meal_breakdown = json_decode($orgData->meal_breakdown, true);
            $orgData->vehicles = json_decode($orgData->vehicles, true);
        }

        // Merge permanent data
        $data = array_merge((array) $orgData, $permanentData);

        return view('org-chart', compact('data'));
    }

    /**
     * Generate automated assignments based on volunteer data
     */
    public function generateAssignments(Request $request)
    {
        try {
            $volunteers = Volunteer::all();
            $assignments = $this->generateAutomatedAssignments($volunteers);

            return response()->json([
                'success' => true,
                'assignments' => $assignments,
                'message' => 'Assignments generated successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Assignment generation failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate assignments'
            ], 500);
        }
    }

    /**
     * Save assignments to database
     */
    public function saveAssignments(Request $request)
    {
        try {
            $validated = $request->validate([
                'objective' => 'required|string',
                'menu' => 'required|string',
                'date' => 'required|date',
                'planning' => 'nullable|string',
                'purchasing' => 'nullable|string',
                'mwc_coordinator' => 'nullable|string',
                'safety_emergency' => 'nullable|string',
                'mobile_kitchen' => 'nullable|string',
                'am_distribution' => 'nullable|string',
                'pm_distribution' => 'nullable|string',
                'teams' => 'required|array',
                'kitchen_truck' => 'nullable|array',
                'food_prep' => 'nullable|array',
                'volunteer_care' => 'nullable|array',
                'wash_cleanup' => 'nullable|array',
                'inventory' => 'nullable|array',
                'meal_breakdown' => 'nullable|array',
                'vehicles' => 'nullable|array'
            ]);

            // Create new org chart entry
            $orgChart = OrgChart::create([
                'objective' => $validated['objective'],
                'menu' => $validated['menu'],
                'date' => $validated['date'],
                'volunteers_count' => count($validated['teams']),
                'planning' => $validated['planning'],
                'purchasing' => $validated['purchasing'],
                'mwc_coordinator' => $validated['mwc_coordinator'],
                'safety_emergency' => $validated['safety_emergency'],
                'mobile_kitchen' => $validated['mobile_kitchen'],
                'am_distribution' => $validated['am_distribution'],
                'pm_distribution' => $validated['pm_distribution'],
                'teams' => json_encode($validated['teams']),
                'kitchen_truck' => json_encode($validated['kitchen_truck'] ?? []),
                'food_prep' => json_encode($validated['food_prep'] ?? []),
                'volunteer_care' => json_encode($validated['volunteer_care'] ?? []),
                'wash_cleanup' => json_encode($validated['wash_cleanup'] ?? []),
                'inventory' => json_encode($validated['inventory'] ?? []),
                'meal_breakdown' => json_encode($validated['meal_breakdown'] ?? []),
                'vehicles' => json_encode($validated['vehicles'] ?? [])
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Assignments saved successfully',
                'org_chart_id' => $orgChart->id
            ]);
        } catch (\Exception $e) {
            Log::error('Save assignments failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to save assignments'
            ], 500);
        }
    }

    /**
     * Generate automated assignments based on volunteer skills and availability
     */
    private function generateAutomatedAssignments($volunteers)
    {
        $assignments = [
            'planning' => '',
            'purchasing' => '',
            'mwc_coordinator' => '',
            'safety_emergency' => '',
            'mobile_kitchen' => '',
            'am_distribution' => '',
            'pm_distribution' => '',
            'teams' => [],
            'kitchen_truck' => [],
            'food_prep' => [],
            'volunteer_care' => [],
            'wash_cleanup' => [],
            'inventory' => []
        ];

        // Define team structures
        $teamStructures = [
            'alpha' => ['type' => 'VF/GA/ANNEX', 'max_members' => 4],
            'bravo' => ['type' => 'MAR/WBBN', 'max_members' => 5],
            'charlie1' => ['type' => 'MASVLLE', 'max_members' => 4],
            'charlie2' => ['type' => 'BANNA', 'max_members' => 4],
            'delta1' => ['type' => 'arroP', 'max_members' => 3],
            'delta2' => ['type' => 'EUCATYN', 'max_members' => 4],
            'echo' => ['type' => 'DELPAN', 'max_members' => 4],
            'foxtrot' => ['type' => 'PAR/SUN', 'max_members' => 4]
        ];

        // Initialize teams
        foreach ($teamStructures as $teamKey => $structure) {
            $assignments['teams'][$teamKey] = [
                'type' => $structure['type'],
                'leader' => '',
                'members' => []
            ];
        }

        // Categorize volunteers by skills and experience
        $leaders = [];
        $drivers = [];
        $experienced = [];
        $general = [];

        foreach ($volunteers as $volunteer) {
            $skills = strtolower($volunteer->skills ?? '');
            $training = strtolower($volunteer->training ?? '');
            $availability = explode(', ', $volunteer->availability ?? '');

            // Identify potential leaders (experienced volunteers)
            if (strpos($skills, 'leadership') !== false ||
                strpos($training, 'leadership') !== false ||
                $volunteer->created_at < now()->subMonths(6)) {
                $leaders[] = $volunteer;
            }

            // Identify drivers
            if (strpos($skills, 'driving') !== false ||
                strpos($training, 'driving') !== false) {
                $drivers[] = $volunteer;
            }

            // Experienced volunteers (more than 3 months)
            if ($volunteer->created_at < now()->subMonths(3)) {
                $experienced[] = $volunteer;
            } else {
                $general[] = $volunteer;
            }
        }

        // Assign coordinators from experienced volunteers
        if (!empty($experienced)) {
            shuffle($experienced);

            $assignments['planning'] = $experienced[0]->first_name . ' ' . $experienced[0]->last_name;
            array_shift($experienced);

            if (!empty($experienced)) {
                $assignments['purchasing'] = $experienced[0]->first_name . ' ' . $experienced[0]->last_name;
                array_shift($experienced);
            }

            if (!empty($experienced)) {
                $assignments['mwc_coordinator'] = $experienced[0]->first_name . ' ' . $experienced[0]->last_name;
                array_shift($experienced);
            }

            if (!empty($experienced)) {
                $assignments['safety_emergency'] = $experienced[0]->first_name . ' ' . $experienced[0]->last_name;
                array_shift($experienced);
            }
        }

        // Assign team leaders from leaders pool
        $teamKeys = array_keys($teamStructures);
        $leaderIndex = 0;

        foreach ($teamKeys as $teamKey) {
            if ($leaderIndex < count($leaders)) {
                $leader = $leaders[$leaderIndex];
                $assignments['teams'][$teamKey]['leader'] = $leader->first_name . ' ' . $leader->last_name;
                $leaderIndex++;
            }
        }

        // Assign team members
        $allVolunteers = array_merge($experienced, $general);
        shuffle($allVolunteers);

        $memberIndex = 0;
        foreach ($teamKeys as $teamKey) {
            $maxMembers = $teamStructures[$teamKey]['max_members'] - 1; // -1 for leader
            $assignments['teams'][$teamKey]['members'] = [];

            for ($i = 0; $i < $maxMembers && $memberIndex < count($allVolunteers); $i++) {
                $member = $allVolunteers[$memberIndex];
                $assignments['teams'][$teamKey]['members'][] = $member->first_name . ' ' . $member->last_name;
                $memberIndex++;
            }
        }

        // Assign kitchen roles
        $kitchenRoles = [
            'kitchen_truck' => 4,
            'food_prep' => 6,
            'volunteer_care' => 3,
            'wash_cleanup' => 4,
            'inventory' => 3
        ];

        $kitchenIndex = 0;
        foreach ($kitchenRoles as $role => $count) {
            $assignments[$role] = [];
            for ($i = 0; $i < $count && $kitchenIndex < count($allVolunteers); $i++) {
                $volunteer = $allVolunteers[$kitchenIndex];
                $assignments[$role][] = $volunteer->first_name . ' ' . $volunteer->last_name;
                $kitchenIndex++;
            }
        }

        // Assign distribution coordinators
        if (!empty($experienced)) {
            $assignments['mobile_kitchen'] = $experienced[0]->first_name . ' ' . $experienced[0]->last_name;
            $assignments['am_distribution'] = $experienced[1]->first_name . ' ' . $experienced[1]->last_name ?? '';
            $assignments['pm_distribution'] = $experienced[2]->first_name . ' ' . $experienced[2]->last_name ?? '';
        }

        return $assignments;
    }

    /**
     * Get org chart data for editing
     */
    public function edit()
    {
        $orgData = OrgChart::latest()->first();

        if ($orgData) {
            // Decode JSON fields
            $orgData->teams = json_decode($orgData->teams, true);
            $orgData->kitchen_truck = json_decode($orgData->kitchen_truck, true);
            $orgData->food_prep = json_decode($orgData->food_prep, true);
            $orgData->volunteer_care = json_decode($orgData->volunteer_care, true);
            $orgData->wash_cleanup = json_decode($orgData->wash_cleanup, true);
            $orgData->inventory = json_decode($orgData->inventory, true);
            $orgData->meal_breakdown = json_decode($orgData->meal_breakdown, true);
            $orgData->vehicles = json_decode($orgData->vehicles, true);
        }

        return view('admin.org-chart-editor', compact('orgData'));
    }
}
