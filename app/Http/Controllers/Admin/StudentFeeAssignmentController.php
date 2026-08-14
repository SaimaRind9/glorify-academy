<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicSession;
use App\Models\FeeType;
use App\Models\Student;
use App\Models\StudentFeeAssignment;
use Illuminate\Http\Request;

class StudentFeeAssignmentController extends Controller
{
    public function index()
    {
        $assignments = StudentFeeAssignment::with([
            'student.classRoom',
            'student.shift',
            'academicSession',
            'feeType',
        ])
        ->latest()
        ->get();

        return view(
            'admin.student-fee-assignments.index',
            compact('assignments')
        );
    }

    public function create()
    {
        $students = Student::with([
            'classRoom',
            'shift',
        ])
        ->orderBy('name')
        ->get();

        $academicSessions = AcademicSession::orderByDesc('start_date')
            ->get();

        $feeTypes = FeeType::where('status', 'Active')
            ->orderBy('fee_name')
            ->get();

        return view(
            'admin.student-fee-assignments.create',
            compact(
                'students',
                'academicSessions',
                'feeTypes'
            )
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => [
                'required',
                'exists:students,id',
            ],

            'academic_session_id' => [
                'required',
                'exists:academic_sessions,id',
            ],

            'fee_type_id' => [
                'required',
                'exists:fee_types,id',
            ],

            'custom_amount' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'effective_from' => [
                'required',
                'date',
            ],

            'status' => [
                'required',
                'in:Active,Inactive',
            ],
        ]);

        $duplicate = StudentFeeAssignment::where(
            'student_id',
            $validated['student_id']
        )
            ->where(
                'academic_session_id',
                $validated['academic_session_id']
            )
            ->where(
                'fee_type_id',
                $validated['fee_type_id']
            )
            ->whereDate(
                'effective_from',
                $validated['effective_from']
            )
            ->exists();

        if ($duplicate) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'This student fee assignment already exists.'
                );
        }

        StudentFeeAssignment::create($validated);

        return redirect()
            ->route('student-fee-assignments.index')
            ->with(
                'success',
                'Student Fee Assignment Added Successfully.'
            );
    }

    public function edit(StudentFeeAssignment $studentFeeAssignment)
    {
        $students = Student::with([
            'classRoom',
            'shift',
        ])
        ->orderBy('name')
        ->get();

        $academicSessions = AcademicSession::orderByDesc('start_date')
            ->get();

        $feeTypes = FeeType::where('status', 'Active')
            ->orWhere(
                'id',
                $studentFeeAssignment->fee_type_id
            )
            ->orderBy('fee_name')
            ->get();

        return view(
            'admin.student-fee-assignments.edit',
            compact(
                'studentFeeAssignment',
                'students',
                'academicSessions',
                'feeTypes'
            )
        );
    }

    public function update(
        Request $request,
        StudentFeeAssignment $studentFeeAssignment
    ) {
        $validated = $request->validate([
            'student_id' => [
                'required',
                'exists:students,id',
            ],

            'academic_session_id' => [
                'required',
                'exists:academic_sessions,id',
            ],

            'fee_type_id' => [
                'required',
                'exists:fee_types,id',
            ],

            'custom_amount' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'effective_from' => [
                'required',
                'date',
            ],

            'status' => [
                'required',
                'in:Active,Inactive',
            ],
        ]);

        $duplicate = StudentFeeAssignment::where(
            'student_id',
            $validated['student_id']
        )
            ->where(
                'academic_session_id',
                $validated['academic_session_id']
            )
            ->where(
                'fee_type_id',
                $validated['fee_type_id']
            )
            ->whereDate(
                'effective_from',
                $validated['effective_from']
            )
            ->where(
                'id',
                '!=',
                $studentFeeAssignment->id
            )
            ->exists();

        if ($duplicate) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Another fee assignment already exists with the same details.'
                );
        }

        $studentFeeAssignment->update($validated);

        return redirect()
            ->route('student-fee-assignments.index')
            ->with(
                'success',
                'Student Fee Assignment Updated Successfully.'
            );
    }
}