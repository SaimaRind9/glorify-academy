<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
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
}