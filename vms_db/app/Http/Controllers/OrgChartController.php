<?php

namespace App\Http\Controllers;

use App\Models\OrgChart;

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
        if (! $orgData) {
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
                    'foxtrot' => ['type' => 'PAR/SUN', 'leader' => '', 'members' => []],
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
                    ['team' => 'Foxtrot', 'vehicle' => 'Flexi/Clipper'],
                ],
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
}
