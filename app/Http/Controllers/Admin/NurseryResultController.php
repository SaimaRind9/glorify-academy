<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NurseryActivityAssessment;
use App\Models\Student;

class NurseryResultController extends Controller
{
    public function show(Student $student, $exam)
    {
        $activities = NurseryActivityAssessment::with([
            'activityType',
            'exam',
            'student',
            'classRoom'
        ])
        ->where('student_id', $student->id)
        ->where('exam_id', $exam)
        ->join(
    'nursery_activity_types',
    'nursery_activity_assessments.nursery_activity_type_id',
    '=',
    'nursery_activity_types.id'
)
->select('nursery_activity_assessments.*')
->orderBy('nursery_activity_types.display_order')
->orderBy('nursery_activity_types.activity_name')
->get();

        if ($activities->isEmpty()) {
            return back()->with(
                'error',
                'No Nursery Result Found.'
            );
        }

        $scoreMap = [
            'Excellent' => 5,
            'Very Good' => 4,
            'Good' => 3,
            'Satisfactory' => 2,
            'Needs Improvement' => 1,
        ];

        $average = $activities->avg(function ($item) use ($scoreMap) {
            return $scoreMap[$item->assessment];
        });

        if ($average >= 4.5) {
            $overall = "Excellent";
            $stars = "★★★★★";
        } elseif ($average >= 3.5) {
            $overall = "Very Good";
            $stars = "★★★★☆";
        } elseif ($average >= 2.5) {
            $overall = "Good";
            $stars = "★★★☆☆";
        } elseif ($average >= 1.5) {
            $overall = "Satisfactory";
            $stars = "★★☆☆☆";
        } else {
            $overall = "Needs Improvement";
            $stars = "★☆☆☆☆";
        }

        return view(
            'admin.nursery-results.show',
            compact(
                'student',
                'activities',
                'overall',
                'stars'
            )
        );
    }
}