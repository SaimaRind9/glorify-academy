<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\ClassRoom;
use Illuminate\Http\Request;
use App\Models\Shift;

class StudentController extends Controller
{
    public function index(Request $request)
    {
       $query = Student::with([
    'classRoom',
    'shift'
]);

        // Search Student
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('student_id', 'like', '%' . $request->search . '%');
            });
        }

        // Gender Filter
        if ($request->gender) {
            $query->where('gender', $request->gender);
        }

        // Class Filter
        if ($request->class_room_id) {
            $query->where('class_room_id', $request->class_room_id);
        }

        $students = $query->latest()->get();

        // Cards Data
        $totalStudents = Student::count();

        $maleStudents = Student::where('gender', 'Male')->count();

        $femaleStudents = Student::where('gender', 'Female')->count();

        $newAdmissions = Student::whereMonth(
            'created_at',
            now()->month
        )->count();

        $classes = ClassRoom::all();

        return view('admin.students.index', compact(
            'students',
            'totalStudents',
            'maleStudents',
            'femaleStudents',
            'newAdmissions',
            'classes'
        ));
    }


   public function create()
{
    $classes = ClassRoom::all();

    $shifts = Shift::where('status', 'Active')
        ->orderBy('name')
        ->get();

    return view('admin.students.create', compact(
        'classes',
        'shifts'
    ));
}


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'dob' => 'nullable|date',
            'gender' => 'required|in:Male,Female',
            'contact' => 'required|string|max:50',
            'class_room_id' => 'required|exists:class_rooms,id',
            'quran_classes' => 'required|in:Yes,No',
            'address' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'shift_id' => 'required|exists:shifts,id',
        ]);

        $photo = null;

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo')
                ->store('students', 'public');
        }

        Student::create([
            'student_id' => 'STD' . rand(1000, 9999),
            'name' => $request->name,
            'father_name' => $request->father_name,
            'dob' => $request->dob,
            'gender' => $request->gender,
            'contact' => $request->contact,
            'address' => $request->address,
            'photo' => $photo,
            'class_room_id' => $request->class_room_id,
            'shift_id' => $request->shift_id,
            'quran_classes' => $request->quran_classes,
        ]);

        return redirect()
            ->route('students.index')
            ->with('success', 'Student Added Successfully');
    }


    public function edit(Student $student)
{
    $classes = ClassRoom::all();

    $shifts = Shift::where('status', 'Active')
        ->orWhere('id', $student->shift_id)
        ->orderBy('name')
        ->get();

    return view('admin.students.edit', compact(
        'student',
        'classes',
        'shifts'
    ));
}


    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'dob' => 'nullable|date',
            'gender' => 'required|in:Male,Female',
            'contact' => 'required|string|max:50',
            'class_room_id' => 'required|exists:class_rooms,id',
            'quran_classes' => 'required|in:Yes,No',
            'address' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'shift_id' => 'required|exists:shifts,id',
        ]);

        $data = [
            'name' => $request->name,
            'father_name' => $request->father_name,
            'dob' => $request->dob,
            'gender' => $request->gender,
            'contact' => $request->contact,
            'address' => $request->address,
            'class_room_id' => $request->class_room_id,
            'shift_id' => $request->shift_id,
            'quran_classes' => $request->quran_classes,
        ];

        // Photo Upload
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')
                ->store('students', 'public');

            $data['photo'] = $path;
        }

        $student->update($data);

        return redirect()
            ->route('students.index')
            ->with('success', 'Student Updated Successfully');
    }


    public function idCard($id)
    {
        $student = Student::with('classRoom')->findOrFail($id);

        return view('admin.students.id-card', compact('student'));
    }


    public function show(Student $student)
    {
        return view('admin.students.show', compact('student'));
    }


    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()
            ->route('students.index')
            ->with('success', 'Student Deleted Successfully');
    }
}