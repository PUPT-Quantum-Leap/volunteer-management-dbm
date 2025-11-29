<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Volunteer;
use App\Models\Attendance;
use App\Models\PerformanceTracking;
use Carbon\Carbon;

class SeedAttendanceAndPerformance extends Command
{
    protected $signature = 'seed:attendance-performance';
    protected $description = 'Seed sample attendance and performance data for testing';

    public function handle()
    {
        $volunteers = Volunteer::all();

        if ($volunteers->isEmpty()) {
            $this->error('No volunteers found. Please create some volunteers first.');
            return;
        }

        foreach ($volunteers as $volunteer) {
            // Seed attendance records (last 30 days)
            for ($i = 0; $i < 15; $i++) {
                $date = Carbon::now()->subDays(rand(0, 30));
                $status = rand(1, 100) > 10 ? 'present' : (rand(1, 100) > 50 ? 'absent' : 'excused');

                Attendance::updateOrCreate(
                    [
                        'volunteer_id' => $volunteer->id,
                        'attendance_date' => $date,
                        'event_name' => collect(['Sunday Worship', 'Youth Meeting', 'Service Team', 'Prayer Night'])->random(),
                    ],
                    ['status' => $status]
                );
            }

            // Seed performance tracking records
            $metrics = ['reliability', 'punctuality', 'quality'];
            foreach ($metrics as $metric) {
                for ($i = 0; $i < 3; $i++) {
                    PerformanceTracking::create([
                        'volunteer_id' => $volunteer->id,
                        'metric_name' => $metric,
                        'score' => rand(70, 100),
                        'feedback' => 'Great work! Keep it up.',
                        'evaluated_by' => 'Admin',
                    ]);
                }
            }
        }

        $this->info('Sample attendance and performance data seeded successfully!');
    }
}
