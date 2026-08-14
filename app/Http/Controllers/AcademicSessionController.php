<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AcademicSessionController extends Controller
{
    public function index()
    {
        $sessions = AcademicSession::latest()->get();

        return view('admin.academic-sessions.index', compact('sessions'));
    }

    public function create()
    {
        return view('admin.academic-sessions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'session_name' => 'required|string|max:100|unique:academic_sessions,session_name',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:Active,Inactive',
        ]);

        DB::transaction(function () use ($validated) {

            if ($validated['status'] === 'Active') {
                AcademicSession::where('status', 'Active')
                    ->update(['status' => 'Inactive']);
            }

            AcademicSession::create($validated);
        });

        return redirect()
            ->route('academic-sessions.index')
            ->with('success', 'Academic session added successfully.');
    }

    public function edit(AcademicSession $academicSession)
    {
        return view(
            'admin.academic-sessions.edit',
            compact('academicSession')
        );
    }

    public function update(
        Request $request,
        AcademicSession $academicSession
    ) {
        $validated = $request->validate([
            'session_name' => 'required|string|max:100|unique:academic_sessions,session_name,' . $academicSession->id,
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:Active,Inactive',
        ]);

        DB::transaction(function () use (
            $validated,
            $academicSession
        ) {
            if ($validated['status'] === 'Active') {
                AcademicSession::where('id', '!=', $academicSession->id)
                    ->where('status', 'Active')
                    ->update(['status' => 'Inactive']);
            }

            $academicSession->update($validated);
        });

        return redirect()
            ->route('academic-sessions.index')
            ->with('success', 'Academic session updated successfully.');
    }

    public function toggleStatus(AcademicSession $academicSession)
    {
        DB::transaction(function () use ($academicSession) {

            if ($academicSession->status === 'Inactive') {
                AcademicSession::where('status', 'Active')
                    ->update(['status' => 'Inactive']);

                $academicSession->update([
                    'status' => 'Active',
                ]);
            } else {
                $academicSession->update([
                    'status' => 'Inactive',
                ]);
            }
        });

        return redirect()
            ->route('academic-sessions.index')
            ->with('success', 'Academic session status updated.');
    }
}