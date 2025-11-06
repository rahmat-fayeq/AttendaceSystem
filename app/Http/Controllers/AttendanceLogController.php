<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Student;
use Carbon\Carbon;

class AttendanceLogController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->query('date', date('Y-m-d'));
        $students = Student::all();

        $attendanceData = $students->map(function($student) use ($date) {
            $logs = Attendance::where('student_id', $student->id)
                ->whereDate('record_time', $date)
                ->orderBy('record_time','asc')
                ->get();

            if ($logs->isEmpty()) {
                $timeIn = null;
                $timeOut = null;
                $status = 'Absent';
            } elseif ($logs->count() == 1) {
                $status = 'Half Day'; // only one punch
                $timeIn = $logs->first()->record_time;
                $timeOut = null;
            } else {
                $timeIn = $logs->first()->record_time;
                $timeOut = $logs->last()->record_time;
                $hours = \Carbon\Carbon::parse($timeIn)->diffInHours(\Carbon\Carbon::parse($timeOut));
                
                if ($hours >= 3) {
                    $status = 'Present';
                } else {
                    $status = 'Half Day';
                }
            }

            return [
                'student' => $student,
                'date' => $date,
                'time_in' => $timeIn,
                'time_out' => $timeOut,
                'status' => $status
            ];
        });

        return view('pages.attendance.daily', compact('attendanceData','date'));
    }
}
