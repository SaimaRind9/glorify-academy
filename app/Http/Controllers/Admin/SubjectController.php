<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SubjectController extends Controller
{
    /**
     * Display all subjects.
     */
    public function index(Request $request)
    {
        $query = Subject::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('subject_name', 'like', '%' . $search . '%')
                  ->orWhere('subject_code', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $subjects = $query->latest()->paginate(10)->withQueryString();

        $totalSubjects = Subject::count();
        $activeSubjects = Subject::where('status', true)->count();
        $inactiveSubjects = Subject::where('status', false)->count();

        return view('admin.subjects.index', compact(
            'subjects',
            'totalSubjects',
            'activeSubjects',
            'inactiveSubjects'
        ));
    }

    /**
     * Show the create subject form.
     */
    public function create()
    {
        return view('admin.subjects.create');
    }

    /**
     * Store a newly created subject.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject_name' => [
                'required',
                'string',
                'max:100',
            ],

            'subject_code' => [
                'required',
                'string',
                'max:30',
                'unique:subjects,subject_code',
            ],

            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'status' => [
                'required',
                'boolean',
            ],
        ]);

        $validated['subject_name'] = trim($validated['subject_name']);
        $validated['subject_code'] = strtoupper(trim($validated['subject_code']));

        Subject::create($validated);

        return redirect()
            ->route('subjects.index')
            ->with('success', 'Subject added successfully.');
    }

    /**
     * Display the specified subject.
     */
    public function show(Subject $subject)
    {
        return redirect()->route('subjects.edit', $subject);
    }

    /**
     * Show the edit subject form.
     */
    public function edit(Subject $subject)
    {
        return view('admin.subjects.edit', compact('subject'));
    }

    /**
     * Update the specified subject.
     */
    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'subject_name' => [
                'required',
                'string',
                'max:100',
            ],

            'subject_code' => [
                'required',
                'string',
                'max:30',
                Rule::unique('subjects', 'subject_code')
                    ->ignore($subject->id),
            ],

            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'status' => [
                'required',
                'boolean',
            ],
        ]);

        $validated['subject_name'] = trim($validated['subject_name']);
        $validated['subject_code'] = strtoupper(trim($validated['subject_code']));

        $subject->update($validated);

        return redirect()
            ->route('subjects.index')
            ->with('success', 'Subject updated successfully.');
    }

    /**
     * Delete the specified subject.
     */
    public function destroy(Subject $subject)
    {
        if ($subject->classSubjects()->exists()) {
            return redirect()
                ->route('subjects.index')
                ->with(
                    'error',
                    'This subject is assigned to a class and cannot be deleted.'
                );
        }

        $subject->delete();

        return redirect()
            ->route('subjects.index')
            ->with('success', 'Subject deleted successfully.');
    }
}