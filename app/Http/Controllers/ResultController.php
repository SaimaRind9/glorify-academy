<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use App\Models\Exam;
use App\Models\Mark;
use App\Models\Student;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    /**
     * Display result-card students list.
     */
    public function index(Request $request)
    {
        $exams = Exam::query()
            ->orderByDesc('id')
            ->get();

        $classes = ClassRoom::query()
            ->orderBy('class_name')
            ->get();

        $selectedExamId = $request->exam_id;
        $selectedClassId = $request->class_room_id;

        $students = null;

        /*
         * Students tab show honge jab exam select hoga.
         * Class selection optional rakhi gayi hai.
         */
        if ($selectedExamId) {
            $studentIdsQuery = Mark::query()
                ->where('exam_id', $selectedExamId)
                ->where('status', 1);

            if ($selectedClassId) {
                $studentIdsQuery->where(
                    'class_room_id',
                    $selectedClassId
                );
            }

            $studentIds = $studentIdsQuery
                ->distinct()
                ->pluck('student_id');

            $studentsQuery = Student::query()
                ->with('classRoom')
                ->whereIn('id', $studentIds);

            if ($request->filled('search')) {
                $search = trim($request->search);

                $studentsQuery->where(function ($query) use ($search) {
                    $query->where(
                        'name',
                        'like',
                        '%' . $search . '%'
                    )
                    ->orWhere(
                        'student_id',
                        'like',
                        '%' . $search . '%'
                    );
                });
            }

            $students = $studentsQuery
                ->orderBy('name')
                ->paginate(12)
                ->withQueryString();

            /*
             * Har student ke result summary ko attach karega.
             */
            $students->getCollection()->transform(
                function ($student) use (
                    $selectedExamId,
                    $selectedClassId
                ) {
                    $marksQuery = Mark::query()
                        ->where('exam_id', $selectedExamId)
                        ->where('student_id', $student->id)
                        ->where('status', 1);

                    if ($selectedClassId) {
                        $marksQuery->where(
                            'class_room_id',
                            $selectedClassId
                        );
                    }

                    $marks = $marksQuery->get();

                    $student->result_summary =
                        $this->calculateResultSummary($marks);

                    return $student;
                }
            );
        }

        return view('admin.results.index', compact(
            'exams',
            'classes',
            'students',
            'selectedExamId',
            'selectedClassId'
        ));
    }

    /**
     * Display an individual printable result card.
     */
    public function show(Exam $exam, Student $student)
    {
        $marks = Mark::query()
            ->with([
                'subject',
                'classRoom',
                'exam',
                'student',
            ])
            ->where('exam_id', $exam->id)
            ->where('student_id', $student->id)
            ->where('status', 1)
            ->orderBy('subject_id')
            ->get();

        if ($marks->isEmpty()) {
            abort(
                404,
                'No marks were found for this student and exam.'
            );
        }

        $summary = $this->calculateResultSummary($marks);

        $classRoom = $marks->first()->classRoom;

        $position = $this->calculateStudentPosition(
            $exam->id,
            $classRoom?->id,
            $student->id
        );

        return view('admin.results.show', compact(
            'exam',
            'student',
            'marks',
            'summary',
            'classRoom',
            'position'
        ));
    }

    /**
     * Calculate complete result summary.
     */
    private function calculateResultSummary($marks): array
    {
        if ($marks->isEmpty()) {
            return [
                'total_subjects' => 0,
                'total_marks' => 0,
                'obtained_marks' => 0,
                'percentage' => 0,
                'grade' => 'N/A',
                'result_status' => 'Pending',
                'passed_subjects' => 0,
                'failed_subjects' => 0,
                'absent_subjects' => 0,
            ];
        }

        $totalMarks = (float) $marks->sum('total_marks');

        $obtainedMarks = (float) $marks
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

        /*
         * Agar kisi ek subject mein fail ya absent ho,
         * overall result Fail hoga.
         */
        if ($absentSubjects > 0 || $failedSubjects > 0) {
            $resultStatus = 'Fail';
        } else {
            $resultStatus = 'Pass';
        }

        return [
            'total_subjects' => $marks->count(),
            'total_marks' => round($totalMarks, 2),
            'obtained_marks' => round($obtainedMarks, 2),
            'percentage' => round($percentage, 2),
            'grade' => $this->calculateOverallGrade(
                $percentage,
                $resultStatus
            ),
            'result_status' => $resultStatus,
            'passed_subjects' => $passedSubjects,
            'failed_subjects' => $failedSubjects,
            'absent_subjects' => $absentSubjects,
        ];
    }

    /**
     * Calculate overall result-card grade.
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

    /**
     * Calculate position within the selected exam and class.
     */
    private function calculateStudentPosition(
        int $examId,
        ?int $classRoomId,
        int $studentId
    ): ?int {
        if (!$classRoomId) {
            return null;
        }

        $classMarks = Mark::query()
            ->where('exam_id', $examId)
            ->where('class_room_id', $classRoomId)
            ->where('status', 1)
            ->get()
            ->groupBy('student_id')
            ->map(function ($studentMarks, $id) {
                return [
                    'student_id' => (int) $id,

                    'obtained_marks' => (float) $studentMarks
                        ->where('is_absent', false)
                        ->sum('obtained_marks'),

                    'has_failed' => $studentMarks
                        ->contains(function ($mark) {
                            return $mark->is_absent
                                || $mark->result_status === 'Fail';
                        }),
                ];
            })
            ->sort(function ($firstStudent, $secondStudent) {
                /*
                 * Passed students pehle,
                 * phir obtained marks descending.
                 */
                if (
                    $firstStudent['has_failed']
                    !== $secondStudent['has_failed']
                ) {
                    return $firstStudent['has_failed'] <=> 
                        $secondStudent['has_failed'];
                }

                return $secondStudent['obtained_marks']
                    <=> $firstStudent['obtained_marks'];
            })
            ->values();

        $studentIndex = $classMarks->search(
            function ($studentResult) use ($studentId) {
                return $studentResult['student_id'] === $studentId;
            }
        );

        return $studentIndex === false
            ? null
            : $studentIndex + 1;
    }
}