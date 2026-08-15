<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\ClassSubject;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class SubjectController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Get Logged-in Teacher
    |--------------------------------------------------------------------------
    */

    private function getTeacher()
    {
        return Teacher::with('classRoom')
            ->where('email', auth()->user()->email)
            ->firstOrFail();
    }


    /*
    |--------------------------------------------------------------------------
    | View Teacher Subjects
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $teacher = $this->getTeacher();

        $classSubjects = ClassSubject::with('subject')
            ->where('class_room_id', $teacher->class_room_id)
            ->whereHas('subject', function ($query) use ($teacher) {
                $query->where('teacher_id', $teacher->id);
            })
            ->latest()
            ->get();

        return view(
            'teacher.subjects.index',
            compact(
                'teacher',
                'classSubjects'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Add Subject Form
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $teacher = $this->getTeacher();

        return view(
            'teacher.subjects.create',
            compact('teacher')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Save Subject
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $teacher = $this->getTeacher();

        $validated = $request->validate([
            'subject_name' => [
                'required',
                'string',
                'max:255',
            ],

            'subject_code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('subjects', 'subject_code'),
            ],

            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'full_marks' => [
                'required',
                'numeric',
                'min:1',
            ],

            'pass_marks' => [
                'required',
                'numeric',
                'min:0',
                'lte:full_marks',
            ],
        ], [
            'subject_code.unique' =>
                'This subject/course code already exists.',

            'pass_marks.lte' =>
                'Pass marks cannot be greater than full marks.',
        ]);


        DB::transaction(function () use (
            $validated,
            $teacher
        ) {

            /*
            |--------------------------------------------------------------------------
            | Create Subject
            |--------------------------------------------------------------------------
            */

            $subject = Subject::create([
                'teacher_id' =>
                    $teacher->id,

                'subject_name' =>
                    $validated['subject_name'],

                'subject_code' =>
                    strtoupper(
                        trim($validated['subject_code'])
                    ),

                'description' =>
                    $validated['description'] ?? null,

                'status' =>
                    true,
            ]);


            /*
            |--------------------------------------------------------------------------
            | Automatically Assign Subject To Teacher's Class
            |--------------------------------------------------------------------------
            */

            ClassSubject::create([
                'class_room_id' =>
                    $teacher->class_room_id,

                'subject_id' =>
                    $subject->id,

                /*
                | Temporary safe value.
                | Current database enum accepts:
                | Marks, Grade, Activity
                */
                'subject_type' =>
                    'Marks',

                'full_marks' =>
                    $validated['full_marks'],

                'pass_marks' =>
                    $validated['pass_marks'],

                'status' =>
                    true,
            ]);
        });


        return redirect()
            ->route('teacher.subjects.index')
            ->with(
                'success',
                'Subject created successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Edit Subject
    |--------------------------------------------------------------------------
    */

    public function edit(Subject $subject)
    {
        $teacher = $this->getTeacher();

        /*
         * Teacher cannot edit another teacher's subject.
         */
        abort_if(
            $subject->teacher_id !== $teacher->id,
            403
        );


        $classSubject = ClassSubject::where(
            'subject_id',
            $subject->id
        )
            ->where(
                'class_room_id',
                $teacher->class_room_id
            )
            ->firstOrFail();


        return view(
            'teacher.subjects.edit',
            compact(
                'teacher',
                'subject',
                'classSubject'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update Subject
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Subject $subject
    ) {
        $teacher = $this->getTeacher();


        abort_if(
            $subject->teacher_id !== $teacher->id,
            403
        );


        $classSubject = ClassSubject::where(
            'subject_id',
            $subject->id
        )
            ->where(
                'class_room_id',
                $teacher->class_room_id
            )
            ->firstOrFail();


        $validated = $request->validate([
            'subject_name' => [
                'required',
                'string',
                'max:255',
            ],

            'subject_code' => [
                'required',
                'string',
                'max:50',

                Rule::unique(
                    'subjects',
                    'subject_code'
                )->ignore($subject->id),
            ],

            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'full_marks' => [
                'required',
                'numeric',
                'min:1',
            ],

            'pass_marks' => [
                'required',
                'numeric',
                'min:0',
                'lte:full_marks',
            ],

            'status' => [
                'required',
                'boolean',
            ],
        ], [
            'subject_code.unique' =>
                'This subject/course code already exists.',

            'pass_marks.lte' =>
                'Pass marks cannot be greater than full marks.',
        ]);


        DB::transaction(function () use (
            $validated,
            $subject,
            $classSubject
        ) {

            $subject->update([
                'subject_name' =>
                    $validated['subject_name'],

                'subject_code' =>
                    strtoupper(
                        trim($validated['subject_code'])
                    ),

                'description' =>
                    $validated['description'] ?? null,

                'status' =>
                    $validated['status'],
            ]);


            $classSubject->update([
                /*
                | Keep the current DB-compatible value.
                */
                'subject_type' =>
                    'Marks',

                'full_marks' =>
                    $validated['full_marks'],

                'pass_marks' =>
                    $validated['pass_marks'],

                'status' =>
                    $validated['status'],
            ]);
        });


        return redirect()
            ->route('teacher.subjects.index')
            ->with(
                'success',
                'Subject updated successfully.'
            );
    }
}