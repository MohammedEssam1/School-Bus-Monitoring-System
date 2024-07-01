<?php

namespace App\Jobs;

use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class Nine_Am_Attendance_Check implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $current_date = date('Y-m-d');
        $Absent_students = Student::whereDoesntHave('attendance', function ($query) use ($current_date) {
            $query->where('attendence_date', $current_date);
        })->get();
        foreach ($Absent_students as $student) {
            Attendance::create([
                'student_id' => $student->id,
                'attendence_date' => $current_date,
                'attendence_status' => 'Absent'
            ]);
        }
        echo "Nine Am Attendance Check Done";
    }
}
