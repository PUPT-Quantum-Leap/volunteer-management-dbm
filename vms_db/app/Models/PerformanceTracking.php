<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PerformanceTracking extends Model
{
    protected $table = 'performance_tracking';

    protected $fillable = [
        'volunteer_id',
        'metric_name',
        'score',
        'feedback',
        'evaluated_by',
    ];

    public function volunteer(): BelongsTo
    {
        return $this->belongsTo(Volunteer::class);
    }
}
