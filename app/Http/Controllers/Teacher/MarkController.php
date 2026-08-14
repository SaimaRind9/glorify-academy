<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\ClassSubject;
use App\Models\Exam;
use App\Models\Mark;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

class MarkController extends Controller
{
    private function getTeacher()
    {
        return Teacher::with('classRoom')
            ->where('email', auth()->user()->email)
            ->firstOrFail();
    }


    /*
    |--------------------------------------------------------------------------
    | Marks Page
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $teacher = $this->getTeacher();


        /*
        |--------------------------------------------------------------------------
        | Teacher's Own Exams
        |--------------------------------------------------------------------------
        */

        $exams = Exam::where('teacher_id', $teacher->id)
            ->where('class_room_id', $teacher->class_room_id)
            ->where('status', true)
            ->latest()
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Assigned Class Subjects
        |--------------------------------------------------------------------------
        */

        $classSubjects = ClassSubject::with('subject')
            ->where('class_room_id', $teacher->class_room_id)
            ->where('status', true)
            ->get();


        $students = collect();

        $existingMarks = collect();

        $selectedExam = null;

        $selectedClassSubject = null;


        /*
        |--------------------------------------------------------------------------
        | Load Students + Existing Marks
        |--------------------------------------------------------------------------
        */

        if ($request->exam_id && $request->class_subject_id) {

            $selectedExam = Exam::where('id', $request->exam_id)
                ->where('teacher_id', $teacher->id)
                ->where('class_room_id', $teacher->class_room_id)
                ->firstOrFail();


            $selectedClassSubject = ClassSubject::with('subject')
                ->where('id', $request->class_subject_id)
                ->where('class_room_id', $teacher->class_room_id)
                ->firstOrFail();


            $students = Student::where(
                'class_room_id',
                $teacher->class_room_id
            )
                ->orderBy('name')
                ->get();


            $existingMarks = Mark::where(
                'exam_id',
                $selectedExam->id
            )
                ->where(
                    'class_room_id',
                    $teacher->class_room_id
                )
                ->where(
                    'subject_id',
                    $selectedClassSubject->subject_id
                )
                ->get()
                ->keyBy('student_id');
        }


        return view(
            'teacher.marks.index',
            compact(
                'teacher',
                'exams',
                'classSubjects',
                'students',
                'existingMarks',
                'selectedExam',
                'selectedClassSubject'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Save / Update Marks
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $teacher = $this->getTeacher();


        $request->validate([
            'exam_id' => [
                'required',
                'exists:exams,id',
            ],

            'class_subject_id' => [
                'required',
                'exists:class_subjects,id',
            ],

            'marks' => [
                'required',
                'array',
            ],

            'marks.*' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'absent' => [
                'nullable',
                'array',
            ],

            'remarks' => [
                'nullable',
                'array',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Security: Exam Must Belong To Teacher
        |--------------------------------------------------------------------------
        */

        $exam = Exam::where(
            'id',
            $request->exam_id
        )
            ->where(
                'teacher_id',
                $teacher->id
            )
            ->where(
                'class_room_id',
                $teacher->class_room_id
            )
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | Security: Subject Must Belong To Teacher's Class
        |--------------------------------------------------------------------------
        */

        $classSubject = ClassSubject::with('subject')
            ->where(
                'id',
                $request->class_subject_id
            )
            ->where(
                'class_room_id',
                $teacher->class_room_id
            )
            ->firstOrFail();


        $students = Student::where(
            'class_room_id',
            $teacher->class_room_id
        )->get();


        foreach ($students as $student) {

            $isAbsent = isset(
                $request->absent[$student->id]
            );


            $obtainedMarks = $isAbsent
                ? null
                : (
                    $request->marks[$student->id]
                    ?? null
                );


            /*
            |--------------------------------------------------------------------------
            | Prevent Marks Greater Than Full Marks
            |--------------------------------------------------------------------------
            */

            if (
                !$isAbsent &&
                $obtainedMarks !== null &&
                (float) $obtainedMarks >
                (float) $classSubject->full_marks
            ) {

                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Obtained marks cannot exceed full marks for '
                        . $student->name
                        . '.'
                    );
            }


            Mark::updateOrCreate(

                [
                    'exam_id' =>
                        $exam->id,

                    'class_room_id' =>
                        $teacher->class_room_id,

                    'subject_id' =>
                        $classSubject->subject_id,

                    'student_id' =>
                        $student->id,
                ],

                [
                    'total_marks' =>
                        $classSubject->full_marks,

                    'passing_marks' =>
                        $classSubject->pass_marks,

                    'obtained_marks' =>
                        $obtainedMarks,

                    'remarks' =>
                        $request->remarks[$student->id]
                        ?? null,

                    'is_absent' =>
                        $isAbsent,

                    'status' =>
                        true,
                ]
            );
        }


        return redirect()
            ->route(
                'teacher.marks.index',
                [
                    'exam_id' =>
                        $exam->id,

                    'class_subject_id' =>
                        $classSubject->id,
                ]
            )
            ->with(
                'success',
                'Student Marks Saved Successfully.'
            );
    }
}