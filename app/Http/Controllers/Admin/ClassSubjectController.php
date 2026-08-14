<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\ClassSubject;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClassSubjectController extends Controller
{
    /**
     * Display all class-subject assignments.
     */
    public function index(Request $request)
    {
        $query = ClassSubject::with([
    'classRoom',
    'subject',
]);

        // Search by class name, subject name or subject code
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->whereHas('classRoom', function ($classQuery) use ($search) {
                    $classQuery->where('class_name', 'like', '%' . $search . '%');
                })
                ->orWhereHas('subject', function ($subjectQuery) use ($search) {
                    $subjectQuery->where('subject_name', 'like', '%' . $search . '%')
                        ->orWhere('subject_code', 'like', '%' . $search . '%');
                });
            });
        }

        // Filter by class
        if ($request->filled('class_room_id')) {
            $query->where('class_room_id', $request->class_room_id);
        }

        // Filter by subject type
        if ($request->filled('subject_type')) {
            $query->where('subject_type', $request->subject_type);
        }

        // Filter by status
        if ($request->filled('status')) {
    $query->where('status', $request->status);
}

        $classSubjects = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

     $classes = ClassRoom::orderBy('class_name')->get();

return view('admin.class-subjects.index', compact(
    'classSubjects',
    'classes'
));
    }

    /**
     * Show assignment form.
     */
  public function create()
{
    $classes = ClassRoom::orderBy('class_name', 'asc')->get();

    $subjects = Subject::where('status', 1)
        ->orderBy('subject_name', 'asc')
        ->get();

    return view('admin.class-subjects.create', compact(
        'classes',
        'subjects'
    ));
}
    

    /**
     * Store new class-subject assignment.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_room_id' => [
                'required',
                'exists:class_rooms,id',
            ],

            'subject_id' => [
                'required',
                'exists:subjects,id',
                Rule::unique('class_subjects')->where(function ($query) use ($request) {
                    return $query
                        ->where('class_room_id', $request->class_room_id)
                        ->where('subject_id', $request->subject_id);
                }),
            ],

            'subject_type' => [
                'required',
                Rule::in(['Marks', 'Grade', 'Activity']),
            ],

            'full_marks' => [
                'nullable',
                'required_if:subject_type,Marks',
                'integer',
                'min:1',
                'max:1000',
            ],

            'pass_marks' => [
                'nullable',
                'required_if:subject_type,Marks',
                'integer',
                'min:0',
                'lte:full_marks',
            ],

            'status' => 'required|boolean',
        ], [
            'class_room_id.required' => 'Please select a class.',
            'subject_id.required' => 'Please select a subject.',
            'subject_id.unique' => 'This subject is already assigned to the selected class.',
            'subject_type.required' => 'Please select a subject type.',
            'full_marks.required_if' => 'Full marks are required for marks-based subjects.',
            'pass_marks.required_if' => 'Pass marks are required for marks-based subjects.',
            'pass_marks.lte' => 'Pass marks cannot be greater than full marks.',
        ]);

        if ($validated['subject_type'] !== 'Marks') {
            $validated['full_marks'] = null;
            $validated['pass_marks'] = null;
        }

        ClassSubject::create($validated);

        return redirect()
            ->route('class-subjects.index')
            ->with('success', 'Subject assigned to class successfully.');
    }

    /**
     * Show edit form.
     */
   public function edit(ClassSubject $classSubject)
{
    $classes = ClassRoom::orderBy('class_name')->get();

   $subjects = Subject::orderBy('subject_name', 'asc')->get();
    return view('admin.class-subjects.edit', compact(
        'classSubject',
        'classes',
        'subjects'
    ));
}

    /**
     * Update class-subject assignment.
     */
    public function update(Request $request, ClassSubject $classSubject)
    {
        $validated = $request->validate([
            'class_room_id' => [
                'required',
                'exists:class_rooms,id',
            ],

            'subject_id' => [
                'required',
                'exists:subjects,id',
                Rule::unique('class_subjects')
                    ->ignore($classSubject->id)
                    ->where(function ($query) use ($request) {
                        return $query
                            ->where('class_room_id', $request->class_room_id)
                            ->where('subject_id', $request->subject_id);
                    }),
            ],

            'subject_type' => [
                'required',
                Rule::in(['Marks', 'Grade', 'Activity']),
            ],

            'full_marks' => [
                'nullable',
                'required_if:subject_type,Marks',
                'integer',
                'min:1',
                'max:1000',
            ],

            'pass_marks' => [
                'nullable',
                'required_if:subject_type,Marks',
                'integer',
                'min:0',
                'lte:full_marks',
            ],

            'status' => 'required|boolean',
        ], [
            'class_room_id.required' => 'Please select a class.',
            'subject_id.required' => 'Please select a subject.',
            'subject_id.unique' => 'This subject is already assigned to the selected class.',
            'subject_type.required' => 'Please select a subject type.',
            'full_marks.required_if' => 'Full marks are required for marks-based subjects.',
            'pass_marks.required_if' => 'Pass marks are required for marks-based subjects.',
            'pass_marks.lte' => 'Pass marks cannot be greater than full marks.',
        ]);

        if ($validated['subject_type'] !== 'Marks') {
            $validated['full_marks'] = null;
            $validated['pass_marks'] = null;
        }

        $classSubject->update($validated);

        return redirect()
            ->route('class-subjects.index')
            ->with('success', 'Class subject assignment updated successfully.');
    }

    /**
     * Delete assignment.
     */
    public function destroy(ClassSubject $classSubject)
    {
        $classSubject->delete();

        return redirect()
            ->route('class-subjects.index')
            ->with('success', 'Class subject assignment deleted successfully.');
    }
}