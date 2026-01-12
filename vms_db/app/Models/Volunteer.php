<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Volunteer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'mobile',
        'facebook_name',
        'birthdate',
        'address',
        'education',
        'training',
        'skills',
        'classes',
        'availability',
        'volunteer_area',
        'lifegroup',
        'emergency_name',
        'emergency_relation',
        'emergency_phone',
        'emergency_email',
        'user_id',
    ];

    protected $casts = [
        'birthdate' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function attendance(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function performanceTracking(): HasMany
    {
        return $this->hasMany(PerformanceTracking::class);
    }
}
