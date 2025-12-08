<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OrgChart;

class OrgChartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OrgChart::create([
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
            'teams' => json_encode([
                'alpha' => ['type' => 'VF/GA/ANNEX', 'leader' => 'Kevin', 'members' => []],
                'bravo' => ['type' => 'MAR/WBBN', 'leader' => 'John', 'members' => ['Blessing', 'Natasya', 'Jhoy2', 'Evenmae']],
                'charlie1' => ['type' => 'MASVLLE', 'leader' => 'Sam', 'members' => ['Michay', 'Aly']],
                'charlie2' => ['type' => 'BANNA', 'leader' => 'Orly', 'members' => ['Daniel', 'Rhia']],
                'delta1' => ['type' => 'arroP', 'leader' => 'Cedie', 'members' => ['Lady']],
                'delta2' => ['type' => 'EUCATYN', 'leader' => 'Michael S', 'members' => ['Karl', 'Aly']],
                'echo' => ['type' => 'DELPAN', 'leader' => 'John', 'members' => ['Cath', 'Johan']],
                'foxtrot' => ['type' => 'PAR/SUN', 'leader' => '', 'members' => []]
            ]),
            'kitchen_truck' => json_encode(['Miah', 'Jones', 'Sam Rice', 'Blessing']),
            'food_prep' => json_encode(['Teresa', 'Cath', 'Natasya', 'Michay', 'Aly', 'Evenmae']),
            'volunteer_care' => json_encode(['Myrrh', 'Rhia', 'Lady']),
            'wash_cleanup' => json_encode(['Orly', 'John', 'Daniel', 'Ariel']),
            'inventory' => json_encode(['Beth', 'Nestor', 'Johan (pm)']),
            'meal_breakdown' => json_encode(['breakfast' => 40, 'lunch' => 50, 'snacks' => 50]),
            'vehicles' => json_encode([
                ['team' => 'Alpha', 'vehicle' => 'Flexi'],
                ['team' => 'Bravo', 'vehicle' => 'Hilux'],
                ['team' => 'Charlie 1', 'vehicle' => 'Clipper'],
                ['team' => 'Charlie 2', 'vehicle' => 'Chevy'],
                ['team' => 'Delta 1', 'vehicle' => 'Hilux'],
                ['team' => 'Delta 2', 'vehicle' => 'Black'],
                ['team' => 'Echo', 'vehicle' => 'Chevy'],
                ['team' => 'Foxtrot', 'vehicle' => 'Flexi/Clipper']
            ])
        ]);
    }
}
