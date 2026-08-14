<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Mark;
use App\Models\Student;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Get Linked Student
    |--------------------------------------------------------------------------
    */

    private function getStudent()
{
    $user = auth()->user();

    return Student::with('classRoom')
        ->findOrFail($user->student_id);
}


    /*
    |--------------------------------------------------------------------------
    | Result List
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $student = $this->getStudent();

        /*
         * Only exams where this student already has marks.
         */
        $examIds = Mark::where('student_id', $student->id)
            ->where('class_room_id', $student->class_room_id)
            ->where('status', 1)
            ->distinct()
            ->pluck('exam_id');

        $exams = Exam::whereIn('id', $examIds)
            ->latest()
            ->get();

        return view(
            'parent.results.index',
            compact(
                'student',
                'exams'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Single Result Card
    |--------------------------------------------------------------------------
    */

    public function show(Exam $exam)
    {
        $student = $this->getStudent();

        /*
         * Security:
         * Parent can only see result for linked child's class.
         */
        abort_if(
            $exam->class_room_id !== $student->class_room_id,
            403
        );


        $marks = Mark::with([
            'subject',
            'exam',
            'student',
            'classRoom',
        ])
            ->where('exam_id', $exam->id)
            ->where('student_id', $student->id)
            ->where('class_room_id', $student->class_room_id)
            ->where('status', 1)
            ->orderBy('subject_id')
            ->get();


        if ($marks->isEmpty()) {

            abort(
                404,
                'No result found for this student and exam.'
            );
        }


        $summary = $this->calculateResultSummary($marks);


        return view(
            'parent.results.show',
            compact(
                'student',
                'exam',
                'marks',
                'summary'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Result Summary
    |--------------------------------------------------------------------------
    */

    private function calculateResultSummary($marks): array
    {
        $totalMarks =
            (float) $marks->sum('total_marks');


        $obtainedMarks =
            (float) $marks
                ->where('is_absent', false)
                ->sum('obtained_marks');


        $percentage = $totalMarks > 0
            ? ($obtainedMarks / $totalMarks) * 100
            : 0;


        $absentSubjects = $marks
            ->where('is_absent', true)
            ->count();


        $failedSubjects = $marks
            ->filter(function ($mark) {

                return !$mark->is_absent
                    && $mark->result_status === 'Fail';

            })
            ->count();


        $passedSubjects = $marks
            ->filter(function ($mark) {

                return !$mark->is_absent
                    && $mark->result_status === 'Pass';

            })
            ->count();


        $resultStatus =
            ($absentSubjects > 0 || $failedSubjects > 0)
                ? 'Fail'
                : 'Pass';


        return [
            'total_subjects' => $marks->count(),

            'total_marks' =>
                round($totalMarks, 2),

            'obtained_marks' =>
                round($obtainedMarks, 2),

            'percentage' =>
                round($percentage, 2),

            'grade' =>
                $this->calculateOverallGrade(
                    $percentage,
                    $resultStatus
                ),

            'result_status' =>
                $resultStatus,

            'passed_subjects' =>
                $passedSubjects,

            'failed_subjects' =>
                $failedSubjects,

            'absent_subjects' =>
                $absentSubjects,
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Overall Grade
    |--------------------------------------------------------------------------
    */

    private function calculateOverallGrade(
        float $percentage,
        string $resultStatus
    ): string {

        if ($resultStatus === 'Fail') {
            return 'F';
        }


        return match (true) {

            $percentage >= 90 => 'A+',

            $percentage >= 80 => 'A',

            $percentage >= 70 => 'B',

            $percentage >= 60 => 'C',

            $percentage >= 50 => 'D',

            $percentage >= 40 => 'E',

            default => 'F',

        };
    }
}