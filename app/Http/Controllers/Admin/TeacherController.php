<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\ClassRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $query = Teacher::with('classRoom');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('teacher_id', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }

        // Status Filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Class Filter
        if ($request->filled('class_room_id')) {
            $query->where('class_room_id', $request->class_room_id);
        }

        $teachers = $query->latest()->get();

        // Statistics
        $totalTeachers = Teacher::count();

        $activeTeachers = Teacher::where('status', 'Active')->count();

        $inactiveTeachers = Teacher::where('status', 'Inactive')->count();

        $assignedTeachers = Teacher::whereNotNull('class_room_id')->count();

        $classes = ClassRoom::orderBy('class_name')->get();

        return view('admin.teachers.index', compact(
            'teachers',
            'totalTeachers',
            'activeTeachers',
            'inactiveTeachers',
            'assignedTeachers',
            'classes'
        ));
    }

    public function create()
    {
        $classes = ClassRoom::orderBy('class_name')->get();

        return view('admin.teachers.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:teachers,email',
            'phone' => 'required|string|max:20',
            'qualification' => 'nullable|string|max:255',
            'experience' => 'nullable|string|max:255',
            'class_room_id' => 'nullable|exists:class_rooms,id',
            'status' => 'required|in:Active,Inactive',
        ]);

        do {
            $teacherId = 'TCH-' . random_int(1000, 9999);
        } while (Teacher::where('teacher_id', $teacherId)->exists());

        Teacher::create([
            'teacher_id' => $teacherId,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'qualification' => $validated['qualification'] ?? null,
            'experience' => $validated['experience'] ?? null,
            'class_room_id' => $validated['class_room_id'] ?? null,
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('teachers.index')
            ->with('success', 'Teacher added successfully.');
    }

    public function show(Teacher $teacher)
    {
        $teacher->load('classRoom');

        return view('admin.teachers.show', compact('teacher'));
    }

    public function edit(Teacher $teacher)
    {
        $classes = ClassRoom::orderBy('class_name')->get();

        return view('admin.teachers.edit', compact('teacher', 'classes'));
    }

    public function update(Request $request, Teacher $teacher)
{
    $validated = $request->validate([
        'teacher_id' => [
            'required',
            'string',
            'max:50',
            Rule::unique('teachers', 'teacher_id')->ignore($teacher->id),
        ],

        'name' => [
            'required',
            'string',
            'max:255',
        ],

        'email' => [
            'nullable',
            'email',
            'max:255',
            Rule::unique('teachers', 'email')->ignore($teacher->id),
        ],

        'phone' => [
            'required',
            'string',
            'max:30',
        ],

        'qualification' => [
            'nullable',
            'string',
            'max:255',
        ],

        'experience' => [
            'nullable',
            'string',
            'max:255',
        ],

        'class_room_id' => [
            'nullable',
            'exists:class_rooms,id',
        ],

        'status' => [
            'required',
            'in:Active,Inactive',
        ],

        'photo' => [
            'nullable',
            'image',
            'mimes:jpg,jpeg,png,webp',
            'max:10240',
        ],
    ]);

    if ($request->hasFile('photo')) {

        if ($teacher->photo && Storage::disk('public')->exists($teacher->photo)) {
            Storage::disk('public')->delete($teacher->photo);
        }

        $validated['photo'] = $request
            ->file('photo')
            ->store('teachers', 'public');
    }

    $teacher->update($validated);

    return redirect()
        ->route('teachers.index')
        ->with('success', 'Teacher profile updated successfully.');
}

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();

        return redirect()
            ->route('teachers.index')
            ->with('success', 'Teacher deleted successfully.');
    }
}