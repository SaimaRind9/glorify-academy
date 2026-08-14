<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AttendanceController extends Controller
{
    /**
     * Show only the logged-in teacher's class students.
     */
    public function index()
    {
        $user = auth()->user();

        $teacher = Teacher::with('classRoom')
            ->find($user->teacher_id);

        if (!$teacher) {
            abort(403, 'Your account is not connected to a teacher profile.');
        }

        if (!$teacher->class_room_id) {
            return view('teacher.attendance.index', [
                'teacher' => $teacher,
                'students' => collect(),
            ])->with(
                'warning',
                'No class has been assigned to you.'
            );
        }

        $students = Student::where(
            'class_room_id',
            $teacher->class_room_id
        )
            ->orderBy('name')
            ->get();

        return view('teacher.attendance.index', compact(
            'teacher',
            'students'
        ));
    }

    /**
     * Save attendance only for the teacher's assigned class.
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        $teacher = Teacher::find($user->teacher_id);

        if (!$teacher) {
            abort(403, 'Your account is not connected to a teacher profile.');
        }

        if (!$teacher->class_room_id) {
            throw ValidationException::withMessages([
                'attendance' => 'No class has been assigned to you.',
            ]);
        }

        $validated = $request->validate([
            'attendance' => [
                'required',
                'array',
            ],

            'attendance.*' => [
                'required',
                'in:Present,Absent,Leave',
            ],
        ]);

        $allowedStudentIds = Student::where(
            'class_room_id',
            $teacher->class_room_id
        )
            ->pluck('id')
            ->map(fn ($id) => (string) $id)
            ->toArray();

        foreach ($validated['attendance'] as $studentId => $status) {

            if (!in_array(
                (string) $studentId,
                $allowedStudentIds,
                true
            )) {
                abort(
                    403,
                    'You cannot mark attendance for another class.'
                );
            }

            Attendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'date' => now()->toDateString(),
                ],
                [
                    'status' => $status,
                ]
            );
        }

        return back()->with(
            'success',
            'Attendance saved successfully.'
        );
    }

    /**
     * Show read-only attendance history.
     */
    public function history(Request $request)
    {
        $user = auth()->user();

        $teacher = Teacher::with('classRoom')
            ->find($user->teacher_id);

        if (!$teacher) {
            abort(403, 'Your account is not connected to a teacher profile.');
        }

        $selectedDate = $request->input(
            'date',
            now()->toDateString()
        );

        $request->validate([
            'date' => [
                'nullable',
                'date',
                'before_or_equal:today',
            ],
        ]);

        if (!$teacher->class_room_id) {
            return view('teacher.attendance.history', [
                'teacher' => $teacher,
                'attendances' => collect(),
                'selectedDate' => $selectedDate,
            ]);
        }

        $attendances = Attendance::with('student')
            ->whereDate('date', $selectedDate)
            ->whereHas('student', function ($query) use ($teacher) {
                $query->where(
                    'class_room_id',
                    $teacher->class_room_id
                );
            })
            ->get()
            ->sortBy(function ($attendance) {
                return strtolower(
                    $attendance->student?->name ?? ''
                );
            })
            ->values();

        return view('teacher.attendance.history', compact(
            'teacher',
            'attendances',
            'selectedDate'
        ));
    }
}