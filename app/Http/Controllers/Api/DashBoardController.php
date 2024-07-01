<?php

namespace App\Http\Controllers\Api;

use App\Models\Tag;
use App\Models\User;
use App\Models\Student;
use App\Models\Attendance;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashBoardController extends Controller
{
    use ResponseTrait;
    public function index()
    {
        $parents = User::where('role', 'user')->count();
        $admins = User::where('role', 'admin')->count();
        $students = Student::count();
        $tags = Tag::count();
        $attendances_today_count = Attendance::where([
            'attendence_date'=> date('Y-m-d'),
            'attendence_status' => 'Present'
            ])->count();
        $absence_today_count = Attendance::where([
            'attendence_date'=> date('Y-m-d'),
            'attendence_status' => 'Absent'
            ])->count();
        $accident_count=DB::table('bus_accelerometer_readings')->where('status','Accident')->count();
        $acceleration_count=DB::table('bus_accelerometer_readings')->where('status','Acceleration')->count();
        return $this->respondSuccess([
            'parent_count' => $parents,
            'admin_count' => $admins,
            'student_count' => $students,
            'tag_count' => $tags,
            'attendances_today_count' =>$attendances_today_count ,
            'absence_today_count' =>$absence_today_count ,
            'accident_count'=>$accident_count,
            'acceleration_count'=>$acceleration_count,
        ]);
    }

}
