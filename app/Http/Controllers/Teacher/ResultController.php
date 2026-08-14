<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Mark;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    private function getTeacher()
    {
        return Teacher::with('classRoom')
            ->where('email', auth()->user()->email)
            ->firstOrFail();
    }

    public function index(Request $request)
    {
        $teacher = $this->getTeacher();

        $exams = Exam::where('teacher_id', $teacher->id)
            ->where('class_room_id', $teacher->class_room_id)
            ->latest()
            ->get();

        $selectedExamId = $request->exam_id;

        $students = null;

        if ($selectedExamId) {

            $exam = Exam::where('id', $selectedExamId)
                ->where('teacher_id', $teacher->id)
                ->where('class_room_id', $teacher->class_room_id)
                ->firstOrFail();

            $studentIds = Mark::where('exam_id', $exam->id)
                ->where('class_room_id', $teacher->class_room_id)
                ->where('status', 1)
                ->distinct()
                ->pluck('student_id');

            $studentsQuery = Student::whereIn('id', $studentIds)
                ->where('class_room_id', $teacher->class_room_id);

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

            $students->getCollection()->transform(
                function ($student) use ($exam, $teacher) {

                    $marks = Mark::where('exam_id', $exam->id)
                        ->where('student_id', $student->id)
                        ->where('class_room_id', $teacher->class_room_id)
                        ->where('status', 1)
                        ->get();

                    $student->result_summary =
                        $this->calculateResultSummary($marks);

                    return $student;
                }
            );
        }

        return view(
            'teacher.results.index',
            compact(
                'teacher',
                'exams',
                'students',
                'selectedExamId'
            )
        );
    }

    public function show(Exam $exam, Student $student)
    {
        $teacher = $this->getTeacher();

        abort_if(
            $exam->teacher_id !== $teacher->id,
            403
        );

        abort_if(
            $exam->class_room_id !== $teacher->class_room_id,
            403
        );

        abort_if(
            $student->class_room_id !== $teacher->class_room_id,
            403
        );

        $marks = Mark::with([
            'subject',
            'classRoom',
            'exam',
            'student',
        ])
            ->where('exam_id', $exam->id)
            ->where('student_id', $student->id)
            ->where('class_room_id', $teacher->class_room_id)
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

        $position = $this->calculateStudentPosition(
            $exam->id,
            $teacher->class_room_id,
            $student->id
        );

        return view(
            'teacher.results.show',
            compact(
                'teacher',
                'exam',
                'student',
                'marks',
                'summary',
                'position'
            )
        );
    }

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

    private function calculateStudentPosition(
        int $examId,
        int $classRoomId,
        int $studentId
    ): ?int {

        $classMarks = Mark::where('exam_id', $examId)
            ->where('class_room_id', $classRoomId)
            ->where('status', 1)
            ->get()
            ->groupBy('student_id')
            ->map(function ($studentMarks, $id) {

                return [
                    'student_id' => (int) $id,

                    'obtained_marks' =>
                        (float) $studentMarks
                            ->where('is_absent', false)
                            ->sum('obtained_marks'),

                    'has_failed' =>
                        $studentMarks
                            ->contains(function ($mark) {

                                return $mark->is_absent
                                    || $mark->result_status === 'Fail';

                            }),
                ];
            })
            ->sort(function (
                $firstStudent,
                $secondStudent
            ) {

                if (
                    $firstStudent['has_failed']
                    !== $secondStudent['has_failed']
                ) {
                    return $firstStudent['has_failed']
                        <=> $secondStudent['has_failed'];
                }

                return $secondStudent['obtained_marks']
                    <=> $firstStudent['obtained_marks'];
            })
            ->values();

        $studentIndex = $classMarks->search(
            function ($studentResult) use ($studentId) {

                return $studentResult['student_id']
                    === $studentId;

            }
        );

        return $studentIndex === false
            ? null
            : $studentIndex + 1;
    }
}