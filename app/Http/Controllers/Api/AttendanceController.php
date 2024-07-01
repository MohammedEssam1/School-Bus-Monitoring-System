<?php
namespace App\Http\Controllers\Api;

use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\AttendanceResource;
use App\Http\Requests\SearchAttendanceByIdRequest;
use App\Http\Requests\SearchAttendanceByNameRequest;

class AttendanceController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attendance = Attendance::where('attendence_date', date('Y-m-d'))->get();
        return $this->respondSuccess(AttendanceResource::collection($attendance));
    }
    /**
     * Search attendances by student ID within a date range.
     *
     */
    public function searchBy_Student_Id(SearchAttendanceByIdRequest $request)
    {
        $studentId = $request->input('student_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $attendances = Attendance::where('student_id', $studentId)
            ->whereBetween('attendence_date', [$startDate, $endDate])
            ->get();

        return $this->respondSuccess(AttendanceResource::collection($attendances));
    }
    /**
     * Search attendances by student name within a date range.
     *
     */
    public function searchBy_Student_Name(SearchAttendanceByNameRequest $request)
    {
        $studentName = $request->input('student_name');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        
        $attendances = Attendance::whereRelation('student','name',"like",'%'. $studentName . '%')
            ->whereBetween('attendence_date', [$startDate, $endDate])
            ->get();
        return $this->respondSuccess(AttendanceResource::collection($attendances));
    }
}
