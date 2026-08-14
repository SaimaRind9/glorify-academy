<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use App\Models\Exam;
use App\Models\Mark;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class MarkController extends Controller
{
    /**
     * Display marks listing.
     */
    public function index(Request $request)
    {
        $query = Mark::with([
            'exam',
            'classRoom',
            'subject',
            'student',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Student Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->whereHas('student', function ($studentQuery) use ($search) {
                $studentQuery
                    ->where('name', 'like', '%' . $search . '%')
                    ->orWhere('student_id', 'like', '%' . $search . '%');
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Filters
        |--------------------------------------------------------------------------
        */

        if ($request->filled('exam_id')) {
            $query->where('exam_id', $request->exam_id);
        }

        if ($request->filled('class_room_id')) {
            $query->where('class_room_id', $request->class_room_id);
        }

        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }

        if ($request->filled('result_status')) {
            $query->where('result_status', $request->result_status);
        }

        $marks = $query
            ->latest('id')
            ->paginate(20)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Dashboard Cards
        |--------------------------------------------------------------------------
        */

        $totalEntries = Mark::count();

        $passStudents = Mark::where('result_status', 'Pass')->count();

        $failStudents = Mark::where('result_status', 'Fail')->count();

        $absentStudents = Mark::where('result_status', 'Absent')->count();

        return view('admin.marks.index', [
            'marks' => $marks,

            'exams' => Exam::where('status', 1)
                ->orderByDesc('start_date')
                ->orderBy('exam_name')
                ->get(),

            'classes' => ClassRoom::orderBy('class_name')->get(),

            'subjects' => Subject::where('status', 1)
                ->orderBy('subject_name')
                ->get(),

            'totalEntries' => $totalEntries,
            'passStudents' => $passStudents,
            'failStudents' => $failStudents,
            'absentStudents' => $absentStudents,
        ]);
    }

    /**
     * Show bulk marks entry form.
     */
    public function create()
    {
        return view('admin.marks.create', [
            'exams' => Exam::where('status', 1)
                ->orderByDesc('start_date')
                ->orderBy('exam_name')
                ->get(),

            'classes' => ClassRoom::orderBy('class_name')->get(),
        ]);
    }

    /**
     * Return subjects assigned to selected class.
     */
    public function getSubjects($classRoomId)
    {
        $classRoom = ClassRoom::findOrFail($classRoomId);

        $subjects = DB::table('class_subjects')
            ->join(
                'subjects',
                'class_subjects.subject_id',
                '=',
                'subjects.id'
            )
            ->where(
                'class_subjects.class_room_id',
                $classRoom->id
            )
            ->where('class_subjects.status', 1)
            ->where('subjects.status', 1)
            ->select([
                'subjects.id',
                'subjects.subject_name',
            ])
            ->distinct()
            ->orderBy('subjects.subject_name')
            ->get();

        return response()->json([
            'success' => true,
            'subjects' => $subjects,
        ]);
    }

    /**
     * Return students and existing marks through AJAX.
     */
    public function getStudents(Request $request)
    {
        $validated = $request->validate([
            'exam_id' => [
                'required',
                'integer',
                'exists:exams,id',
            ],

            'class_room_id' => [
                'required',
                'integer',
                'exists:class_rooms,id',
            ],

            'subject_id' => [
                'required',
                'integer',
                'exists:subjects,id',
            ],
        ]);

        $exam = Exam::findOrFail($validated['exam_id']);

        /*
        |--------------------------------------------------------------------------
        | Confirm Exam Belongs to Selected Class
        |--------------------------------------------------------------------------
        */

        if ((int) $exam->class_room_id !== (int) $validated['class_room_id']) {
            throw ValidationException::withMessages([
                'class_room_id' => 'The selected exam does not belong to this class.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Confirm Subject Is Assigned to Class
        |--------------------------------------------------------------------------
        */

        $subjectAssigned = DB::table('class_subjects')
            ->where(
                'class_room_id',
                $validated['class_room_id']
            )
            ->where(
                'subject_id',
                $validated['subject_id']
            )
            ->where('status', 1)
            ->exists();

        if (!$subjectAssigned) {
            throw ValidationException::withMessages([
                'subject_id' => 'The selected subject is not assigned to this class.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Load Students
        |--------------------------------------------------------------------------
        */

        $students = Student::where(
            'class_room_id',
            $validated['class_room_id']
        )
            ->orderBy('name')
            ->get([
                'id',
                'student_id',
                'name',
            ]);

        /*
        |--------------------------------------------------------------------------
        | Load Existing Marks
        |--------------------------------------------------------------------------
        */

        $existingMarks = Mark::where(
            'exam_id',
            $validated['exam_id']
        )
            ->where(
                'class_room_id',
                $validated['class_room_id']
            )
            ->where(
                'subject_id',
                $validated['subject_id']
            )
            ->get()
            ->keyBy('student_id');

        $studentData = $students->map(function ($student) use ($existingMarks) {
            $mark = $existingMarks->get($student->id);

            return [
                'id' => $student->id,
                'student_id' => $student->student_id,
                'name' => $student->name,

                'obtained_marks' => $mark
                    ? $mark->obtained_marks
                    : null,

                'is_absent' => $mark
                    ? (bool) $mark->is_absent
                    : false,

                'remarks' => $mark
                    ? $mark->remarks
                    : null,

                'grade' => $mark
                    ? $mark->grade
                    : null,

                'result_status' => $mark
                    ? $mark->result_status
                    : null,
            ];
        });

        return response()->json([
            'success' => true,
            'students' => $studentData,
        ]);
    }

    /**
     * Store or update marks for all students.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'exam_id' => [
                'required',
                'integer',
                'exists:exams,id',
            ],

            'class_room_id' => [
                'required',
                'integer',
                'exists:class_rooms,id',
            ],

            'subject_id' => [
                'required',
                'integer',
                'exists:subjects,id',
            ],

            'total_marks' => [
                'required',
                'numeric',
                'min:1',
                'max:999999.99',
            ],

            'passing_marks' => [
                'required',
                'numeric',
                'min:0',
                'lte:total_marks',
            ],

            'marks' => [
                'required',
                'array',
                'min:1',
            ],

            'marks.*.student_id' => [
                'required',
                'integer',
                'exists:students,id',
            ],

            'marks.*.obtained_marks' => [
                'nullable',
                'numeric',
                'min:0',
                'lte:total_marks',
            ],

            'marks.*.is_absent' => [
                'nullable',
                Rule::in([0, 1, '0', '1']),
            ],

            'marks.*.remarks' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        $exam = Exam::findOrFail($validated['exam_id']);

        /*
        |--------------------------------------------------------------------------
        | Confirm Exam Belongs to Class
        |--------------------------------------------------------------------------
        */

        if ((int) $exam->class_room_id !== (int) $validated['class_room_id']) {
            throw ValidationException::withMessages([
                'class_room_id' => 'The selected exam does not belong to this class.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Confirm Subject Assignment
        |--------------------------------------------------------------------------
        */

        $subjectAssigned = DB::table('class_subjects')
            ->where(
                'class_room_id',
                $validated['class_room_id']
            )
            ->where(
                'subject_id',
                $validated['subject_id']
            )
            ->where('status', 1)
            ->exists();

        if (!$subjectAssigned) {
            throw ValidationException::withMessages([
                'subject_id' => 'The selected subject is not assigned to this class.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Confirm Every Student Belongs to Selected Class
        |--------------------------------------------------------------------------
        */

        $submittedStudentIds = collect($validated['marks'])
            ->pluck('student_id')
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values();

        $validStudentIds = Student::where(
            'class_room_id',
            $validated['class_room_id']
        )
            ->whereIn('id', $submittedStudentIds)
            ->pluck('id')
            ->map(fn ($id) => (int) $id);

        if ($submittedStudentIds->count() !== $validStudentIds->count()) {
            throw ValidationException::withMessages([
                'marks' => 'One or more selected students do not belong to this class.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Save Marks in Database Transaction
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use ($validated) {
            foreach ($validated['marks'] as $studentMark) {
                $isAbsent = (bool) ($studentMark['is_absent'] ?? false);

                $obtainedMarks = $isAbsent
                    ? null
                    : ($studentMark['obtained_marks'] ?? null);

                /*
                |--------------------------------------------------------------------------
                | Skip Completely Empty Rows
                |--------------------------------------------------------------------------
                */

                if (
                    !$isAbsent &&
                    ($obtainedMarks === null || $obtainedMarks === '') &&
                    empty($studentMark['remarks'])
                ) {
                    continue;
                }

                Mark::updateOrCreate(
                    [
                        'exam_id' => $validated['exam_id'],
                        'class_room_id' => $validated['class_room_id'],
                        'subject_id' => $validated['subject_id'],
                        'student_id' => $studentMark['student_id'],
                    ],
                    [
                        'total_marks' => $validated['total_marks'],
                        'obtained_marks' => $obtainedMarks,
                        'passing_marks' => $validated['passing_marks'],
                        'remarks' => $studentMark['remarks'] ?? null,
                        'is_absent' => $isAbsent,
                        'status' => 1,
                    ]
                );
            }
        });

        return redirect()
            ->route('marks.index', [
                'exam_id' => $validated['exam_id'],
                'class_room_id' => $validated['class_room_id'],
                'subject_id' => $validated['subject_id'],
            ])
            ->with('success', 'Students marks saved successfully.');
    }

    /**
     * Display individual marks record.
     */
    public function show(Mark $mark)
    {
        $mark->load([
            'exam',
            'classRoom',
            'subject',
            'student',
        ]);

        return view('admin.marks.show', compact('mark'));
    }

    /**
     * Show individual marks edit form.
     */
    public function edit(Mark $mark)
    {
        $mark->load([
            'exam',
            'classRoom',
            'subject',
            'student',
        ]);

        return view('admin.marks.edit', [
            'mark' => $mark,

            'exams' => Exam::where('status', 1)
                ->orderByDesc('start_date')
                ->orderBy('exam_name')
                ->get(),

            'classes' => ClassRoom::orderBy('class_name')->get(),

            'subjects' => Subject::where('status', 1)
                ->orderBy('subject_name')
                ->get(),
        ]);
    }

    /**
     * Update individual marks record.
     */
    public function update(Request $request, Mark $mark)
    {
        $validated = $request->validate([
            'total_marks' => [
                'required',
                'numeric',
                'min:1',
                'max:999999.99',
            ],

            'passing_marks' => [
                'required',
                'numeric',
                'min:0',
                'lte:total_marks',
            ],

            'obtained_marks' => [
                'nullable',
                'numeric',
                'min:0',
                'lte:total_marks',
            ],

            'is_absent' => [
                'nullable',
                Rule::in([0, 1, '0', '1']),
            ],

            'remarks' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'status' => [
                'required',
                Rule::in([0, 1, '0', '1']),
            ],
        ]);

        $isAbsent = (bool) ($validated['is_absent'] ?? false);

        $mark->update([
            'total_marks' => $validated['total_marks'],

            'obtained_marks' => $isAbsent
                ? null
                : ($validated['obtained_marks'] ?? null),

            'passing_marks' => $validated['passing_marks'],
            'remarks' => $validated['remarks'] ?? null,
            'is_absent' => $isAbsent,
            'status' => (bool) $validated['status'],
        ]);

        return redirect()
            ->route('marks.index')
            ->with('success', 'Marks updated successfully.');
    }

    /**
     * Delete marks record.
     */
    public function destroy(Mark $mark)
    {
        $mark->delete();

        return redirect()
            ->route('marks.index')
            ->with('success', 'Marks record deleted successfully.');
    }
}