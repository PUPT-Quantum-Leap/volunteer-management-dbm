<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\PerformanceTracking;
use App\Models\Volunteer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendancePerformanceController extends Controller
{
    // Record attendance
    public function recordAttendance(Request $request, $volunteerId)
    {
        $volunteer = Volunteer::findOrFail($volunteerId);

        $validated = $request->validate([
            'attendance_date' => 'required|date',
            'status' => 'required|in:present,absent,excused',
            'event_name' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:500',
        ]);

        $eventName = $validated['event_name'] ?? 'General';

        Attendance::updateOrCreate(
            [
                'volunteer_id' => $volunteerId,
                'attendance_date' => $validated['attendance_date'],
                'event_name' => $eventName,
            ],
            [
                'status' => $validated['status'],
                'notes' => $validated['notes'] ?? null,
            ]
        );

        return back()->with('success', 'Attendance recorded successfully!');
    }

    // Record performance evaluation
    public function recordPerformance(Request $request, $volunteerId)
    {
        $volunteer = Volunteer::findOrFail($volunteerId);

        $validated = $request->validate([
            'metric_name' => 'required|in:reliability,punctuality,quality',
            'score' => 'required|integer|min:0|max:100',
            'feedback' => 'nullable|string|max:1000',
            'evaluated_by' => 'nullable|string|max:255',
        ]);
        $evaluatedBy = $validated['evaluated_by'];
        if (! $evaluatedBy) {
            $user = Auth::user();
            $evaluatedBy = $user ? ($user->name ?? 'Admin') : 'Admin';
        }

        PerformanceTracking::create([
            'volunteer_id' => $volunteerId,
            'metric_name' => $validated['metric_name'],
            'score' => $validated['score'],
            'feedback' => $validated['feedback'],
            'evaluated_by' => $evaluatedBy,
        ]);

        return back()->with('success', 'Performance evaluation recorded successfully!');
    }

    // Get volunteer attendance statistics
    public function getAttendanceStats($volunteerId)
    {
        $volunteer = Volunteer::findOrFail($volunteerId);

        $total = Attendance::where('volunteer_id', $volunteerId)->count();
        $present = Attendance::where('volunteer_id', $volunteerId)->where('status', 'present')->count();
        $absent = Attendance::where('volunteer_id', $volunteerId)->where('status', 'absent')->count();
        $excused = Attendance::where('volunteer_id', $volunteerId)->where('status', 'excused')->count();

        $rate = $total > 0 ? round(($present / $total) * 100) : 0;

        return response()->json([
            'volunteer_id' => $volunteerId,
            'total' => $total,
            'present' => $present,
            'absent' => $absent,
            'excused' => $excused,
            'attendance_rate' => $rate,
        ]);
    }

    // Get volunteer performance summary
    public function getPerformanceSummary($volunteerId)
    {
        $volunteer = Volunteer::findOrFail($volunteerId);

        $records = PerformanceTracking::where('volunteer_id', $volunteerId)
            ->get()
            ->groupBy('metric_name')
            ->map(function ($group) {
                return [
                    'average' => round($group->avg('score')),
                    'count' => $group->count(),
                    'latest' => $group->first(),
                ];
            });

        return response()->json([
            'volunteer_id' => $volunteerId,
            'performance_data' => $records,
        ]);
    }
}
