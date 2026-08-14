<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\ClassRoom;
use App\Models\Student;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Show Attendance Records
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $classes = ClassRoom::orderBy('class_name')->get();

        $selectedDate = $request->date ?? now()->toDateString();
        $selectedClass = $request->class_room_id;

        $studentsQuery = Student::with([
            'classRoom',
            'attendances' => function ($query) use ($selectedDate) {
                $query->whereDate('date', $selectedDate);
            }
        ]);

        if ($selectedClass) {
            $studentsQuery->where('class_room_id', $selectedClass);
        }

        $students = $studentsQuery
            ->orderBy('name')
            ->get();

        $totalStudents = $students->count();

        $presentCount = 0;
        $absentCount = 0;
        $leaveCount = 0;
        $notMarkedCount = 0;

        foreach ($students as $student) {

            $attendance = $student->attendances->first();

            if (!$attendance) {
                $notMarkedCount++;
                continue;
            }

            if ($attendance->status === 'Present') {
                $presentCount++;
            } elseif ($attendance->status === 'Absent') {
                $absentCount++;
            } elseif ($attendance->status === 'Leave') {
                $leaveCount++;
            }
        }

        return view('admin.attendance.index', compact(
            'classes',
            'students',
            'selectedDate',
            'selectedClass',
            'totalStudents',
            'presentCount',
            'absentCount',
            'leaveCount',
            'notMarkedCount'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | Update Attendance Record
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, Attendance $attendance)
    {
        $request->validate([
            'status' => ['required', 'in:Present,Absent,Leave'],
        ]);

        $attendance->update([
            'status' => $request->status,
        ]);

        return back()->with(
            'success',
            'Attendance updated successfully.'
        );
    }
}