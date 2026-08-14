<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Student;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Get Parent's Linked Student
    |--------------------------------------------------------------------------
    */

    private function getStudent(): Student
    {
        $user = auth()->user();

        return Student::with('classRoom')
            ->findOrFail($user->student_id);
    }


    /*
    |--------------------------------------------------------------------------
    | Attendance Page
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $student = $this->getStudent();


        /*
        |--------------------------------------------------------------------------
        | Base Query
        |--------------------------------------------------------------------------
        */

        $query = Attendance::where(
            'student_id',
            $student->id
        );


        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {
            $query->where(
                'status',
                $request->status
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Month Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('month')) {
            $query->whereMonth(
                'date',
                $request->month
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Year Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('year')) {
            $query->whereYear(
                'date',
                $request->year
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Attendance Records
        |--------------------------------------------------------------------------
        */

        $attendances = $query
            ->orderByDesc('date')
            ->paginate(15)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Summary
        |--------------------------------------------------------------------------
        */

        $allAttendance = Attendance::where(
            'student_id',
            $student->id
        )->get();


        $totalAttendance =
            $allAttendance->count();


        $presentCount =
            $allAttendance
                ->where('status', 'Present')
                ->count();


        $absentCount =
            $allAttendance
                ->where('status', 'Absent')
                ->count();


        $leaveCount =
            $allAttendance
                ->where('status', 'Leave')
                ->count();


        $attendancePercentage =
            $totalAttendance > 0
                ? round(
                    ($presentCount / $totalAttendance) * 100,
                    1
                )
                : 0;


        /*
        |--------------------------------------------------------------------------
        | Available Years
        |--------------------------------------------------------------------------
        */

        $years = Attendance::where(
            'student_id',
            $student->id
        )
            ->whereNotNull('date')
            ->selectRaw('YEAR(date) as attendance_year')
            ->distinct()
            ->orderByDesc('attendance_year')
            ->pluck('attendance_year');


        return view(
            'parent.attendance.index',
            compact(
                'student',
                'attendances',
                'totalAttendance',
                'presentCount',
                'absentCount',
                'leaveCount',
                'attendancePercentage',
                'years'
            )
        );
    }
}