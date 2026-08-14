<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicSession;
use App\Models\ClassRoom;
use App\Models\FeeStructure;
use App\Models\FeeType;
use App\Models\Shift;
use Illuminate\Http\Request;

class FeeStructureController extends Controller
{
    public function index()
    {
        $feeStructures = FeeStructure::with([
            'academicSession',
            'classRoom',
            'shift',
            'feeType',
        ])
        ->latest()
        ->get();

        return view(
            'admin.fee-structures.index',
            compact('feeStructures')
        );
    }

    public function create()
    {
        $academicSessions = AcademicSession::orderByDesc('start_date')->get();

        $classes = ClassRoom::orderBy('class_name')->get();

        $shifts = Shift::where('status', 'Active')
            ->orderBy('name')
            ->get();

        $feeTypes = FeeType::where('status', 'Active')
            ->orderBy('fee_name')
            ->get();

        return view(
            'admin.fee-structures.create',
            compact(
                'academicSessions',
                'classes',
                'shifts',
                'feeTypes'
            )
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'academic_session_id' => [
                'required',
                'exists:academic_sessions,id',
            ],
            'class_room_id' => [
                'required',
                'exists:class_rooms,id',
            ],
            'shift_id' => [
                'required',
                'exists:shifts,id',
            ],
            'fee_type_id' => [
                'required',
                'exists:fee_types,id',
            ],
            'amount' => [
                'required',
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

        $duplicate = FeeStructure::where(
            'academic_session_id',
            $validated['academic_session_id']
        )
            ->where(
                'class_room_id',
                $validated['class_room_id']
            )
            ->where(
                'shift_id',
                $validated['shift_id']
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
                    'This fee structure already exists for the selected session, class, shift, fee type and effective date.'
                );
        }

        FeeStructure::create($validated);

        return redirect()
            ->route('fee-structures.index')
            ->with(
                'success',
                'Fee Structure Added Successfully.'
            );
    }

    public function edit(FeeStructure $feeStructure)
    {
        $academicSessions = AcademicSession::orderByDesc('start_date')->get();

        $classes = ClassRoom::orderBy('class_name')->get();

        $shifts = Shift::where('status', 'Active')
            ->orWhere('id', $feeStructure->shift_id)
            ->orderBy('name')
            ->get();

        $feeTypes = FeeType::where('status', 'Active')
            ->orWhere('id', $feeStructure->fee_type_id)
            ->orderBy('fee_name')
            ->get();

        return view(
            'admin.fee-structures.edit',
            compact(
                'feeStructure',
                'academicSessions',
                'classes',
                'shifts',
                'feeTypes'
            )
        );
    }

    public function update(
        Request $request,
        FeeStructure $feeStructure
    ) {
        $validated = $request->validate([
            'academic_session_id' => [
                'required',
                'exists:academic_sessions,id',
            ],
            'class_room_id' => [
                'required',
                'exists:class_rooms,id',
            ],
            'shift_id' => [
                'required',
                'exists:shifts,id',
            ],
            'fee_type_id' => [
                'required',
                'exists:fee_types,id',
            ],
            'amount' => [
                'required',
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

        $duplicate = FeeStructure::where(
            'academic_session_id',
            $validated['academic_session_id']
        )
            ->where(
                'class_room_id',
                $validated['class_room_id']
            )
            ->where(
                'shift_id',
                $validated['shift_id']
            )
            ->where(
                'fee_type_id',
                $validated['fee_type_id']
            )
            ->whereDate(
                'effective_from',
                $validated['effective_from']
            )
            ->where('id', '!=', $feeStructure->id)
            ->exists();

        if ($duplicate) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Another fee structure already exists with the same details.'
                );
        }

        $feeStructure->update($validated);

        return redirect()
            ->route('fee-structures.index')
            ->with(
                'success',
                'Fee Structure Updated Successfully.'
            );
    }
}