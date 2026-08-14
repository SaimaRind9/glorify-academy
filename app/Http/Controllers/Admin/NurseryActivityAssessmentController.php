<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\Exam;
use App\Models\NurseryActivityAssessment;
use App\Models\NurseryActivityType;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class NurseryActivityAssessmentController extends Controller
{
    /**
     * Display saved Nursery assessments.
     */
    public function index(Request $request)
    {
        $exams = Exam::latest()->get();

        $nurseryClasses = ClassRoom::where('class_name', 'like', '%Nursery%')
            ->orderBy('class_name')
            ->get();

        $query = NurseryActivityAssessment::with([
            'exam',
            'classRoom',
            'student',
            'activityType',
        ]);

        if ($request->filled('exam_id')) {
            $query->where('exam_id', $request->exam_id);
        }

        if ($request->filled('class_room_id')) {
            $query->where('class_room_id', $request->class_room_id);
        }

        if ($request->filled('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        $assessmentRecords = $query
            ->latest()
            ->get()
            ->groupBy(function ($assessment) {
                return $assessment->exam_id . '-' . $assessment->student_id;
            });

        $students = collect();

        if ($request->filled('class_room_id')) {
            $students = Student::where(
                'class_room_id',
                $request->class_room_id
            )
                ->orderBy('name')
                ->get();
        }

$totalActivities = NurseryActivityType::active()->count();

        return view('admin.nursery-assessments.index', compact(
    'exams',
    'nurseryClasses',
    'assessmentRecords',
    'students',
    'totalActivities'
));
    }

    /**
     * Show bulk assessment entry page.
     */
    public function create(Request $request)
    {
        $exams = Exam::latest()->get();

        $nurseryClasses = ClassRoom::where('class_name', 'like', '%Nursery%')
            ->orderBy('class_name')
            ->get();

        $activities = NurseryActivityType::active()
            ->ordered()
            ->get();

        $assessmentLevels = NurseryActivityAssessment::ASSESSMENT_LEVELS;

        $students = collect();
        $existingAssessments = collect();

        $selectedExamId = $request->exam_id;
        $selectedClassRoomId = $request->class_room_id;

        if ($selectedExamId && $selectedClassRoomId) {
            $classRoom = ClassRoom::findOrFail($selectedClassRoomId);

            if (
                stripos($classRoom->class_name, 'Nursery') === false
            ) {
                return redirect()
                    ->route('nursery-assessments.create')
                    ->with('error', 'Activity assessment is only available for Nursery class.');
            }

            $students = Student::where(
                'class_room_id',
                $selectedClassRoomId
            )
                ->orderBy('name')
                ->get();

            $existingAssessments = NurseryActivityAssessment::where(
                'exam_id',
                $selectedExamId
            )
                ->where('class_room_id', $selectedClassRoomId)
                ->get()
                ->keyBy(function ($assessment) {
                    return $assessment->student_id
                        . '-'
                        . $assessment->nursery_activity_type_id;
                });
        }

        return view('admin.nursery-assessments.create', compact(
            'exams',
            'nurseryClasses',
            'activities',
            'assessmentLevels',
            'students',
            'existingAssessments',
            'selectedExamId',
            'selectedClassRoomId'
        ));
    }

    /**
     * Store or update bulk Nursery assessments.
     */
    public function store(Request $request)
    {
        $assessmentLevels = NurseryActivityAssessment::ASSESSMENT_LEVELS;

        $validated = $request->validate([
            'exam_id' => [
                'required',
                'exists:exams,id',
            ],

            'class_room_id' => [
                'required',
                'exists:class_rooms,id',
            ],

            'assessments' => [
                'required',
                'array',
            ],

            'assessments.*' => [
                'required',
                'array',
            ],

            'assessments.*.*' => [
                'nullable',
                Rule::in($assessmentLevels),
            ],

            'remarks' => [
                'nullable',
                'array',
            ],

            'remarks.*' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        $classRoom = ClassRoom::findOrFail(
            $validated['class_room_id']
        );

        if (stripos($classRoom->class_name, 'Nursery') === false) {
            return back()
                ->withInput()
                ->with('error', 'Activity assessment can only be entered for Nursery class.');
        }

        $activityIds = NurseryActivityType::active()
            ->pluck('id')
            ->toArray();

        $validStudentIds = Student::where(
            'class_room_id',
            $validated['class_room_id']
        )
            ->pluck('id')
            ->toArray();

        DB::transaction(function () use (
            $validated,
            $request,
            $activityIds,
            $validStudentIds
        ) {
            foreach ($validated['assessments'] as $studentId => $studentAssessments) {
                if (!in_array((int) $studentId, $validStudentIds, true)) {
                    continue;
                }

                foreach ($studentAssessments as $activityId => $assessmentValue) {
                    if (!in_array((int) $activityId, $activityIds, true)) {
                        continue;
                    }

                    if (empty($assessmentValue)) {
                        NurseryActivityAssessment::where([
                            'exam_id' => $validated['exam_id'],
                            'student_id' => $studentId,
                            'nursery_activity_type_id' => $activityId,
                        ])->delete();

                        continue;
                    }

                    NurseryActivityAssessment::updateOrCreate(
                        [
                            'exam_id' => $validated['exam_id'],
                            'student_id' => $studentId,
                            'nursery_activity_type_id' => $activityId,
                        ],
                        [
                            'class_room_id' => $validated['class_room_id'],
                            'assessment' => $assessmentValue,
                            'remarks' => $request->input(
                                "remarks.$studentId"
                            ),
                            'status' => true,
                        ]
                    );
                }
            }
        });

        return redirect()
            ->route('nursery-assessments.create', [
                'exam_id' => $validated['exam_id'],
                'class_room_id' => $validated['class_room_id'],
            ])
            ->with('success', 'Nursery activity assessments saved successfully.');
    }



    public function publish($student, $exam)
{
    NurseryActivityAssessment::where('student_id', $student)
        ->where('exam_id', $exam)
        ->update([
            'publish_status' => 'Published'
        ]);

    return back()->with(
        'success',
        'Result published successfully.'
    );
}

public function unpublish($student, $exam)
{
    NurseryActivityAssessment::where('student_id', $student)
        ->where('exam_id', $exam)
        ->update([
            'publish_status' => 'Draft'
        ]);

    return back()->with(
        'success',
        'Result moved back to Draft.'
    );
}

    /**
     * Delete all activity assessments for one student and exam.
     */
    public function destroy(Request $request, Student $student)
    {
        $request->validate([
            'exam_id' => [
                'required',
                'exists:exams,id',
            ],
        ]);

        NurseryActivityAssessment::where(
            'exam_id',
            $request->exam_id
        )
            ->where('student_id', $student->id)
            ->delete();

        return back()->with(
            'success',
            'Student activity assessment deleted successfully.'
        );
    }
}