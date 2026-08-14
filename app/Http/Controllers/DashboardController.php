<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\ClassRoom;
use App\Models\Notice;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $role = strtolower($user->role);

        /*
        |--------------------------------------------------------------------------
        | Admin Dashboard
        |--------------------------------------------------------------------------
        */

        if ($role === 'admin') {

            $totalStudents = Student::count();
            $totalTeachers = Teacher::count();
            $totalParents = User::where('role', 'parent')->count();
            $totalClasses = ClassRoom::count();

            $maleStudents = Student::where('gender', 'Male')->count();
            $femaleStudents = Student::where('gender', 'Female')->count();

            $studentsByClass = ClassRoom::withCount('students')
                ->orderBy('class_name')
                ->get();

            $classNames = $studentsByClass->pluck('class_name');
            $classStudentCounts = $studentsByClass->pluck('students_count');

            $monthlyAdmissions = Student::selectRaw(
                'MONTH(created_at) as month, COUNT(*) as total'
            )
                ->whereYear('created_at', now()->year)
                ->groupBy('month')
                ->orderBy('month')
                ->pluck('total', 'month');

            $monthlyAdmissionData = [];

            for ($month = 1; $month <= 12; $month++) {
                $monthlyAdmissionData[] = $monthlyAdmissions[$month] ?? 0;
            }

            $recentStudents = Student::latest()
                ->take(5)
                ->get();

            $recentTeachers = Teacher::latest()
                ->take(5)
                ->get();

            return view('admin.dashboard', compact(
                'totalStudents',
                'totalTeachers',
                'totalParents',
                'totalClasses',
                'maleStudents',
                'femaleStudents',
                'classNames',
                'classStudentCounts',
                'monthlyAdmissionData',
                'recentStudents',
                'recentTeachers'
            ));
        }

        /*
        |--------------------------------------------------------------------------
        | Teacher Dashboard
        |--------------------------------------------------------------------------
        */

        if ($role === 'teacher') {

            $teacher = Teacher::with('classRoom')
                ->find($user->teacher_id);

            $students = collect();
            $totalStudents = 0;

            if ($teacher && $teacher->class_room_id) {

                $students = Student::where(
                    'class_room_id',
                    $teacher->class_room_id
                )
                    ->latest()
                    ->get();

                $totalStudents = $students->count();
            }

            return view('dashboard.teacher', compact(
                'teacher',
                'students',
                'totalStudents'
            ));
        }

        /*
        |--------------------------------------------------------------------------
        | Parent Dashboard
        |--------------------------------------------------------------------------
        */

        if ($role === 'parent') {

            $student = Student::with('classRoom')
                ->find($user->student_id);

            $totalAttendance = 0;
            $presentCount = 0;
            $absentCount = 0;
            $leaveCount = 0;
            $attendancePercentage = 0;
            $recentAttendances = collect();

            /*
            |--------------------------------------------------------------------------
            | Parent Notices
            |--------------------------------------------------------------------------
            */

            $notices = Notice::where('status', 1)
                ->where(function ($query) {
                    $query->whereNull('publish_date')
                        ->orWhereDate(
                            'publish_date',
                            '<=',
                            now()->toDateString()
                        );
                })
                ->orderByDesc('publish_date')
                ->orderByDesc('id')
                ->take(5)
                ->get();

            /*
            |--------------------------------------------------------------------------
            | Student Attendance
            |--------------------------------------------------------------------------
            */

            if ($student) {

                $attendanceQuery = Attendance::where(
                    'student_id',
                    $student->id
                );

                $totalAttendance = (clone $attendanceQuery)->count();

                $presentCount = (clone $attendanceQuery)
                    ->where('status', 'Present')
                    ->count();

                $absentCount = (clone $attendanceQuery)
                    ->where('status', 'Absent')
                    ->count();

                $leaveCount = (clone $attendanceQuery)
                    ->where('status', 'Leave')
                    ->count();

                if ($totalAttendance > 0) {

                    $attendancePercentage = round(
                        ($presentCount / $totalAttendance) * 100,
                        1
                    );
                }

                $recentAttendances = Attendance::where(
                    'student_id',
                    $student->id
                )
                    ->orderByDesc('date')
                    ->take(7)
                    ->get();
            }

            return view('dashboard.parent', compact(
                'student',
                'totalAttendance',
                'presentCount',
                'absentCount',
                'leaveCount',
                'attendancePercentage',
                'recentAttendances',
                'notices'
            ));
        }

        abort(403, 'Unauthorized account role.');
    }
}