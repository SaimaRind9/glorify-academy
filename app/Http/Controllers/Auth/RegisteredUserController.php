<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display registration form.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        /*
        |--------------------------------------------------------------------------
        | Common validation
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'role' => [
                'required',
                'in:teacher,parent',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'confirmed',
                Rules\Password::defaults(),
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Teacher Registration
        |--------------------------------------------------------------------------
        */

        if ($request->role === 'teacher') {
            return $this->registerTeacher($request);
        }

        /*
        |--------------------------------------------------------------------------
        | Parent Registration
        |--------------------------------------------------------------------------
        */

        return $this->registerParent($request);
    }

    /**
     * Register an authorized teacher.
     */
    private function registerTeacher(Request $request): RedirectResponse
    {
        /*
        |--------------------------------------------------------------------------
        | Teacher email must already exist in teachers table
        |--------------------------------------------------------------------------
        */

        $teacher = Teacher::whereRaw(
            'LOWER(email) = ?',
            [strtolower(trim($request->email))]
        )->first();

        if (!$teacher) {
            throw ValidationException::withMessages([
                'email' => 'This email is not registered in the academy teacher records.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Prevent duplicate teacher account
        |--------------------------------------------------------------------------
        */

        $teacherAccountExists = User::where('teacher_id', $teacher->id)->exists();

        if ($teacherAccountExists) {
            throw ValidationException::withMessages([
                'email' => 'An account has already been created for this teacher.',
            ]);
        }

        $user = DB::transaction(function () use ($request, $teacher) {
            return User::create([
                // Official teacher name database se liya jayega
                'name' => $teacher->name,
                'email' => strtolower(trim($request->email)),
                'password' => Hash::make($request->password),
                'role' => 'teacher',
                'status' => 'active',
                'teacher_id' => $teacher->id,
                'student_id' => null,
            ]);
        });

        event(new Registered($user));

        Auth::login($user);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Teacher account registered successfully.');
    }

    /**
     * Register an authorized parent.
     */
    private function registerParent(Request $request): RedirectResponse
    {
        /*
        |--------------------------------------------------------------------------
        | Parent-specific validation
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'student_registration_id' => [
                'required',
                'string',
                'max:100',
            ],

            'student_name' => [
                'required',
                'string',
                'max:255',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Match Student ID and Student Name
        |--------------------------------------------------------------------------
        */

        $student = Student::where(
            'student_id',
            trim($request->student_registration_id)
        )->first();

        if (!$student) {
            throw ValidationException::withMessages([
                'student_registration_id' => 'This Student ID does not exist in academy records.',
            ]);
        }

        $enteredStudentName = strtolower(
            preg_replace('/\s+/', ' ', trim($request->student_name))
        );

        $storedStudentName = strtolower(
            preg_replace('/\s+/', ' ', trim($student->name))
        );

        if ($enteredStudentName !== $storedStudentName) {
            throw ValidationException::withMessages([
                'student_name' => 'Student name does not match the provided Student ID.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Prevent duplicate parent account for same student
        |--------------------------------------------------------------------------
        */

        $parentAccountExists = User::where('student_id', $student->id)
            ->where('role', 'parent')
            ->exists();

        if ($parentAccountExists) {
            throw ValidationException::withMessages([
                'student_registration_id' => 'A parent account has already been created for this student.',
            ]);
        }

        $user = DB::transaction(function () use ($request, $student) {
            return User::create([
                'name' => trim($request->name),
                'email' => strtolower(trim($request->email)),
                'password' => Hash::make($request->password),
                'role' => 'parent',
                'status' => 'active',
                'teacher_id' => null,

                // users.student_id mein students table ki primary ID save hogi
                'student_id' => $student->id,
            ]);
        });

        event(new Registered($user));

        Auth::login($user);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Parent account registered successfully.');
    }
}