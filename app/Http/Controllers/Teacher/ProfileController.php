<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    private function getTeacher()
    {
        return Teacher::with('classRoom')
            ->where('email', auth()->user()->email)
            ->firstOrFail();
    }

    public function edit()
    {
        $teacher = $this->getTeacher();

        return view(
            'teacher.profile.edit',
            compact('teacher')
        );
    }

    public function update(Request $request)
    {
        $teacher = $this->getTeacher();

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
            ],

            'phone' => [
                'nullable',
                'string',
                'max:50',
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

            'photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        if ($request->hasFile('photo')) {

            if (
                $teacher->photo &&
                Storage::disk('public')->exists($teacher->photo)
            ) {
                Storage::disk('public')
                    ->delete($teacher->photo);
            }

            $validated['photo'] =
                $request->file('photo')
                    ->store(
                        'teachers',
                        'public'
                    );
        }

        $teacher->update([
            'name' =>
                $validated['name'],

            'email' =>
                $validated['email'],

            'phone' =>
                $validated['phone'] ?? null,

            'qualification' =>
                $validated['qualification'] ?? null,

            'experience' =>
                $validated['experience'] ?? null,

            'photo' =>
                $validated['photo']
                ?? $teacher->photo,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Keep Login Account Name / Email In Sync
        |--------------------------------------------------------------------------
        */

        auth()->user()->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        return redirect()
            ->route('teacher.profile.edit')
            ->with(
                'success',
                'Profile updated successfully.'
            );
    }
}