<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ClassRoom;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ExamController extends Controller
{
    public function index(Request $request)
    {
        $query = Exam::with('classRoom');

        if ($request->filled('search')) {
            $query->where('exam_name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('class_room_id')) {
            $query->where('class_room_id', $request->class_room_id);
        }

        if ($request->filled('session')) {
            $query->where('session', $request->session);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $exams = $query->latest()->paginate(10)->withQueryString();

        $classes = ClassRoom::orderBy('class_name')->get();

        $sessions = Exam::whereNotNull('session')
            ->where('session', '!=', '')
            ->distinct()
            ->orderBy('session', 'desc')
            ->pluck('session');

        $totalExams = Exam::count();

        $activeExams = Exam::where('status', 1)->count();

        $inactiveExams = Exam::where('status', 0)->count();

        $upcomingExams = Exam::whereDate('start_date', '>', now()->toDateString())
            ->count();

        return view('admin.exams.index', compact(
            'exams',
            'classes',
            'sessions',
            'totalExams',
            'activeExams',
            'inactiveExams',
            'upcomingExams'
        ));
    }

    public function create()
    {
        $classes = ClassRoom::orderBy('class_name')->get();

        return view('admin.exams.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_room_id' => [
                'required',
                'exists:class_rooms,id',
            ],

            'exam_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('exams')
                    ->where(function ($query) use ($request) {
                        return $query
                            ->where('class_room_id', $request->class_room_id)
                            ->where('session', $request->session);
                    }),
            ],

            'session' => [
                'required',
                'string',
                'max:50',
            ],

            'start_date' => [
                'required',
                'date',
            ],

            'end_date' => [
                'required',
                'date',
                'after_or_equal:start_date',
            ],

            'status' => [
                'required',
                'boolean',
            ],
        ], [
            'class_room_id.required' => 'Please select a class.',
            'class_room_id.exists' => 'The selected class is invalid.',

            'exam_name.required' => 'Exam name is required.',
            'exam_name.unique' => 'This exam already exists for the selected class and session.',

            'session.required' => 'Academic session is required.',

            'start_date.required' => 'Start date is required.',

            'end_date.required' => 'End date is required.',
            'end_date.after_or_equal' => 'End date must be the same as or later than the start date.',

            'status.required' => 'Please select the exam status.',
        ]);

        Exam::create($validated);

        return redirect()
            ->route('exams.index')
            ->with('success', 'Exam created successfully.');
    }

    public function show(Exam $exam)
    {
        $exam->load('classRoom');

        return view('admin.exams.show', compact('exam'));
    }

    public function edit(Exam $exam)
    {
        $classes = ClassRoom::orderBy('class_name')->get();

        return view('admin.exams.edit', compact(
            'exam',
            'classes'
        ));
    }

    public function update(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'class_room_id' => [
                'required',
                'exists:class_rooms,id',
            ],

            'exam_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('exams')
                    ->ignore($exam->id)
                    ->where(function ($query) use ($request) {
                        return $query
                            ->where('class_room_id', $request->class_room_id)
                            ->where('session', $request->session);
                    }),
            ],

            'session' => [
                'required',
                'string',
                'max:50',
            ],

            'start_date' => [
                'required',
                'date',
            ],

            'end_date' => [
                'required',
                'date',
                'after_or_equal:start_date',
            ],

            'status' => [
                'required',
                'boolean',
            ],
        ], [
            'class_room_id.required' => 'Please select a class.',
            'class_room_id.exists' => 'The selected class is invalid.',

            'exam_name.required' => 'Exam name is required.',
            'exam_name.unique' => 'This exam already exists for the selected class and session.',

            'session.required' => 'Academic session is required.',

            'start_date.required' => 'Start date is required.',

            'end_date.required' => 'End date is required.',
            'end_date.after_or_equal' => 'End date must be the same as or later than the start date.',

            'status.required' => 'Please select the exam status.',
        ]);

        $exam->update($validated);

        return redirect()
            ->route('exams.index')
            ->with('success', 'Exam updated successfully.');
    }

    public function destroy(Exam $exam)
    {
        $exam->delete();

        return redirect()
            ->route('exams.index')
            ->with('success', 'Exam deleted successfully.');
    }
}