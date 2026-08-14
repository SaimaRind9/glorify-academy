<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Teacher;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    private function getTeacher()
    {
        return Teacher::where(
            'email',
            auth()->user()->email
        )->firstOrFail();
    }

    public function index()
    {
        $teacher = $this->getTeacher();

        $exams = Exam::where('teacher_id', $teacher->id)
            ->where('class_room_id', $teacher->class_room_id)
            ->latest()
            ->get();

        return view(
            'teacher.exams.index',
            compact('teacher', 'exams')
        );
    }

    public function create()
    {
        $teacher = $this->getTeacher();

        return view(
            'teacher.exams.create',
            compact('teacher')
        );
    }

    public function store(Request $request)
    {
        $teacher = $this->getTeacher();

        $validated = $request->validate([
            'exam_name' => 'required|string|max:255',
            'session' => 'required|string|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:0,1',
        ]);

        Exam::create([
            'class_room_id' => $teacher->class_room_id,
            'teacher_id' => $teacher->id,
            'exam_name' => $validated['exam_name'],
            'session' => $validated['session'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('teacher.exams.index')
            ->with('success', 'Exam Created Successfully.');
    }

    public function edit(Exam $exam)
    {
        $teacher = $this->getTeacher();

        abort_if($exam->teacher_id !== $teacher->id, 403);

        abort_if(
            $exam->class_room_id !== $teacher->class_room_id,
            403
        );

        return view(
            'teacher.exams.edit',
            compact('teacher', 'exam')
        );
    }

    public function update(Request $request, Exam $exam)
    {
        $teacher = $this->getTeacher();

        abort_if($exam->teacher_id !== $teacher->id, 403);

        abort_if(
            $exam->class_room_id !== $teacher->class_room_id,
            403
        );

        $validated = $request->validate([
            'exam_name' => 'required|string|max:255',
            'session' => 'required|string|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:0,1',
        ]);

        $exam->update([
            'exam_name' => $validated['exam_name'],
            'session' => $validated['session'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('teacher.exams.index')
            ->with('success', 'Exam Updated Successfully.');
    }
}