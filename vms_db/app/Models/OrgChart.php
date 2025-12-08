<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrgChart extends Model
{
    use HasFactory;

    protected $table = 'org_chart';

    protected $fillable = [
        'objective',
        'menu',
        'date',
        'volunteers_count',
        'planning',
        'purchasing',
        'mwc_coordinator',
        'safety_emergency',
        'mobile_kitchen',
        'am_distribution',
        'pm_distribution',
        'teams',
        'kitchen_truck',
        'food_prep',
        'volunteer_care',
        'wash_cleanup',
        'inventory',
        'meal_breakdown',
        'vehicles',
        'leader_name',
        'deputy_leader',
        'treasurer',
        'secretary',
        'planning_team_lead',
        'purchasing_team_lead',
        'operations_team_lead',
        'communications_team_lead',
        'meeting_frequency',
        'budget_cycle',
        'notes'
    ];

    protected $casts = [
        'date' => 'date',
    ];
}
