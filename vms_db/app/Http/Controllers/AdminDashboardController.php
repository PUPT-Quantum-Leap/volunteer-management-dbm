<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\OrgChart;
use App\Models\PerformanceTracking;
use App\Models\Poll;
use App\Models\User;
use App\Models\Volunteer;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            if (! $user || $user->role !== 'admin') {
                return redirect('/')->with('error', 'Unauthorized access');
            }

            return $next($request);
        });
    }

    public function index()
    {
        // Dashboard stats
        $stats = [
            'total_volunteers' => Volunteer::count(),
            'total_users' => User::count(),
            'total_polls' => Poll::count(),
            'total_attendance_records' => Attendance::count(),
            'average_attendance_rate' => $this->calculateAverageAttendanceRate(),
        ];

        // Recent volunteers
        $recentVolunteers = Volunteer::latest()->limit(5)->get();

        // Active polls
        $activePolls = Poll::with('options')->latest()->limit(5)->get()->map(function ($poll) {
            $poll->responses_count = $poll->options->sum('votes');

            return $poll;
        });

        // Performance summary
        $topPerformers = Volunteer::select('volunteers.id', 'volunteers.first_name', 'volunteers.last_name', 'volunteers.email', 'volunteers.volunteer_area')
            ->join('performance_tracking', 'volunteers.id', '=', 'performance_tracking.volunteer_id')
            ->selectRaw('volunteers.id, volunteers.first_name, volunteers.last_name, volunteers.email, volunteers.volunteer_area, AVG(performance_tracking.score) as performance_score')
            ->groupBy('volunteers.id', 'volunteers.first_name', 'volunteers.last_name', 'volunteers.email', 'volunteers.volunteer_area')
            ->orderByDesc('performance_score')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentVolunteers',
            'activePolls',
            'topPerformers'
        ));
    }

    public function volunteers()
    {
        $volunteers = Volunteer::paginate(15);

        return view('admin.volunteers', compact('volunteers'));
    }

    public function volunteerShow($id)
    {
        $volunteer = Volunteer::findOrFail($id);
        $attendance = Attendance::where('volunteer_id', $id)->latest()->limit(10)->get();
        $performance = PerformanceTracking::where('volunteer_id', $id)->latest()->limit(10)->get();

        return view('admin.volunteer-detail', compact('volunteer', 'attendance', 'performance'));
    }

    public function volunteerUpdate(Request $request, $id)
    {
        $volunteer = Volunteer::findOrFail($id);

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'mobile' => 'required|string|max:20',
            'volunteer_area' => 'required|string|max:255',
            'status' => 'nullable|string|max:50',
        ]);

        $volunteer->update($validated);

        return back()->with('success', 'Volunteer updated successfully!');
    }

    public function volunteerDelete($id)
    {
        $volunteer = Volunteer::findOrFail($id);
        $volunteer->delete();

        return redirect('/admin/volunteers')->with('success', 'Volunteer deleted successfully!');
    }

    public function attendance()
    {
        $records = Attendance::with('volunteer')->latest()->paginate(20);
        $volunteers = Volunteer::orderBy('first_name')->get();

        return view('admin.attendance', compact('records', 'volunteers'));
    }

    public function recordAttendance(Request $request)
    {
        $validated = $request->validate([
            'volunteer_id' => 'required|exists:volunteers,id',
            'attendance_date' => 'required|date',
            'status' => 'required|in:present,absent,excused',
            'event_name' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:500',
        ]);

        Attendance::updateOrCreate(
            [
                'volunteer_id' => $validated['volunteer_id'],
                'attendance_date' => $validated['attendance_date'],
                'event_name' => $validated['event_name'] ?? 'General',
            ],
            [
                'status' => $validated['status'],
                'notes' => $validated['notes'] ?? null,
            ]
        );

        return back()->with('success', 'Attendance recorded successfully!');
    }

    public function performance()
    {
        $records = PerformanceTracking::with('volunteer')->latest()->paginate(20);
        $volunteers = Volunteer::orderBy('first_name')->get();

        return view('admin.performance', compact('records', 'volunteers'));
    }

    public function recordPerformance(Request $request)
    {
        $validated = $request->validate([
            'volunteer_id' => 'required|exists:volunteers,id',
            'metric_name' => 'required|in:reliability,punctuality,quality',
            'score' => 'required|integer|min:0|max:100',
            'feedback' => 'nullable|string|max:1000',
        ]);

        $user = Auth::user();
        PerformanceTracking::create([
            'volunteer_id' => $validated['volunteer_id'],
            'metric_name' => $validated['metric_name'],
            'score' => $validated['score'],
            'feedback' => $validated['feedback'],
            'evaluated_by' => $user ? ($user->name ?? 'Admin') : 'Admin',
        ]);

        return back()->with('success', 'Performance evaluation recorded successfully!');
    }

    public function orgChart()
    {
        $orgChart = OrgChart::latest()->first();

        return view('admin.org-chart-editor', compact('orgChart'));
    }

    public function updateOrgChart(Request $request)
    {
        $validated = $request->validate([
            'objective' => 'nullable|string|max:255',
            'date' => 'nullable|date',
            'volunteers_count' => 'nullable|integer|min:1',
            'planning' => 'nullable|string|max:255',
            'purchasing' => 'nullable|string|max:255',
            'leader_name' => 'nullable|string|max:255',
            'deputy_leader' => 'nullable|string|max:255',
            'treasurer' => 'nullable|string|max:255',
            'secretary' => 'nullable|string|max:255',
            'planning_team_lead' => 'nullable|string|max:255',
            'purchasing_team_lead' => 'nullable|string|max:255',
            'operations_team_lead' => 'nullable|string|max:255',
            'communications_team_lead' => 'nullable|string|max:255',
            'meeting_frequency' => 'nullable|string|max:255',
            'budget_cycle' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);

        $latest = OrgChart::latest()->first();
        if ($latest) {
            $latest->update($validated);
        } else {
            OrgChart::create($validated);
        }

        return back()->with('success', 'Organization chart updated successfully!');
    }

    private function calculateAverageAttendanceRate()
    {
        $volunteers = Volunteer::all();
        if ($volunteers->isEmpty()) {
            return 0;
        }

        $totalRate = 0;
        foreach ($volunteers as $volunteer) {
            $total = Attendance::where('volunteer_id', $volunteer->id)->count();
            $present = Attendance::where('volunteer_id', $volunteer->id)
                ->where('status', 'present')
                ->count();

            $rate = $total > 0 ? ($present / $total) * 100 : 0;
            $totalRate += $rate;
        }

        return round($totalRate / $volunteers->count());
    }
}
