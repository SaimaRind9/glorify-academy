<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Show Parent Profile
    |--------------------------------------------------------------------------
    */

    public function edit()
    {
        $user = auth()->user();

        $student = null;

        if ($user->student_id) {
            $student = Student::with('classRoom')
                ->find($user->student_id);
        }

        return view(
            'parent.profile.edit',
            compact(
                'user',
                'student'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update Parent Profile
    |--------------------------------------------------------------------------
    */

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',

                Rule::unique('users', 'email')
                    ->ignore($user->id),
            ],
        ], [
            'name.required' =>
                'Parent name is required.',

            'email.required' =>
                'Email address is required.',

            'email.email' =>
                'Please enter a valid email address.',

            'email.unique' =>
                'This email address is already in use.',
        ]);


        $user->update([
            'name' =>
                $validated['name'],

            'email' =>
                $validated['email'],
        ]);


        return redirect()
            ->route('parent.profile.edit')
            ->with(
                'success',
                'Profile updated successfully.'
            );
    }
}