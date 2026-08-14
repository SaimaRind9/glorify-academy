<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicSession;
use App\Models\FeeChallan;
use App\Models\FeeStructure;
use App\Models\Student;
use App\Models\StudentFeeAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeeChallanController extends Controller
{
    public function index()
    {
        $challans = FeeChallan::with([
            'student.classRoom',
            'student.shift',
            'academicSession',
            'items'
        ])
        ->latest()
        ->get();

        return view(
            'admin.fee-challans.index',
            compact('challans')
        );
    }


    public function create()
    {
        $students = Student::with([
            'classRoom',
            'shift'
        ])
        ->orderBy('name')
        ->get();

        $academicSessions = AcademicSession::orderByDesc('start_date')
            ->get();

        return view(
            'admin.fee-challans.create',
            compact(
                'students',
                'academicSessions'
            )
        );
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => [
                'required',
                'exists:students,id'
            ],

            'academic_session_id' => [
                'required',
                'exists:academic_sessions,id'
            ],

            'month' => [
                'required',
                'integer',
                'between:1,12'
            ],

            'year' => [
                'required',
                'integer',
                'min:2020',
                'max:2100'
            ],

            'issue_date' => [
                'required',
                'date'
            ],

            'due_date' => [
                'required',
                'date',
                'after_or_equal:issue_date'
            ],

            'late_fine' => [
                'nullable',
                'numeric',
                'min:0'
            ],

            'include_admission_fee' => [
                'nullable',
                'boolean'
            ],
        ]);


        $student = Student::with([
            'classRoom',
            'shift'
        ])->findOrFail($validated['student_id']);


        /*
        |--------------------------------------------------------------------------
        | Duplicate Challan Protection
        |--------------------------------------------------------------------------
        */

        $alreadyExists = FeeChallan::where(
            'student_id',
            $student->id
        )
        ->where(
            'academic_session_id',
            $validated['academic_session_id']
        )
        ->where(
            'month',
            $validated['month']
        )
        ->where(
            'year',
            $validated['year']
        )
        ->exists();


        if ($alreadyExists) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Challan already exists for this student and month.'
                );
        }


        $effectiveDate = $validated['issue_date'];


        /*
        |--------------------------------------------------------------------------
        | Get Active Fee Structure
        |--------------------------------------------------------------------------
        */

        $feeStructures = FeeStructure::with('feeType')
            ->where(
                'academic_session_id',
                $validated['academic_session_id']
            )
            ->where(
                'class_room_id',
                $student->class_room_id
            )
            ->where(
                'shift_id',
                $student->shift_id
            )
            ->where(
                'status',
                'Active'
            )
            ->whereDate(
                'effective_from',
                '<=',
                $effectiveDate
            )
            ->orderBy('fee_type_id')
            ->orderByDesc('effective_from')
            ->get()
            ->unique('fee_type_id');


        if ($feeStructures->isEmpty()) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'No active fee structure found for this student class and shift.'
                );
        }


        DB::transaction(function () use (
            $validated,
            $student,
            $feeStructures,
            $effectiveDate
        ) {

            $subtotal = 0;


            $challan = FeeChallan::create([

                'challan_no' => $this->generateChallanNumber(),

                'student_id' => $student->id,

                'academic_session_id' =>
                    $validated['academic_session_id'],

                'month' => $validated['month'],

                'year' => $validated['year'],

                'issue_date' => $validated['issue_date'],

                'due_date' => $validated['due_date'],

                'subtotal' => 0,

                'late_fine' => $validated['late_fine'] ?? 0,

                'total_amount' => 0,

                'paid_amount' => 0,

                'status' => 'Pending',

            ]);


            foreach ($feeStructures as $structure) {

                $feeType = $structure->feeType;

                if (!$feeType) {
                    continue;
                }


                /*
                |--------------------------------------------------------------------------
                | Applicability Rules
                |--------------------------------------------------------------------------
                */

                // Monthly Fee -> Always include
                if ($feeType->category === 'Monthly') {
                    // allowed
                }

                // Quran Fee -> Only Quran enrolled students
                elseif ($feeType->category === 'Quran') {

                    if ($student->quran_classes !== 'Yes') {
                        continue;
                    }

                }

                // Admission Fee -> Only if admin explicitly checks it
                elseif ($feeType->category === 'Admission') {

                    if (
                        empty($validated['include_admission_fee'])
                    ) {
                        continue;
                    }

                }

                else {
                    continue;
                }


                /*
                |--------------------------------------------------------------------------
                | Check Custom Student Fee
                |--------------------------------------------------------------------------
                */

                $assignment = StudentFeeAssignment::where(
                    'student_id',
                    $student->id
                )
                ->where(
                    'academic_session_id',
                    $validated['academic_session_id']
                )
                ->where(
                    'fee_type_id',
                    $structure->fee_type_id
                )
                ->where(
                    'status',
                    'Active'
                )
                ->whereDate(
                    'effective_from',
                    '<=',
                    $effectiveDate
                )
                ->latest('effective_from')
                ->first();


                $amount = $structure->amount;


                if (
                    $assignment &&
                    $assignment->custom_amount !== null
                ) {
                    $amount = $assignment->custom_amount;
                }


                $challan->items()->create([

                    'fee_type_id' =>
                        $structure->fee_type_id,

                    'description' =>
                        $feeType->fee_name,

                    'amount' => $amount,

                ]);


                $subtotal += (float) $amount;
            }


            $lateFine =
                (float) ($validated['late_fine'] ?? 0);


            $challan->update([

                'subtotal' => $subtotal,

                'total_amount' =>
                    $subtotal + $lateFine,

            ]);

        });


        return redirect()
            ->route('fee-challans.index')
            ->with(
                'success',
                'Fee Challan Generated Successfully.'
            );
    }


    public function show(FeeChallan $feeChallan)
    {
        $feeChallan->load([
            'student.classRoom',
            'student.shift',
            'academicSession',
            'items.feeType'
        ]);

        return view(
            'admin.fee-challans.show',
            compact('feeChallan')
        );
    }


    private function generateChallanNumber()
    {
        $nextId = (FeeChallan::max('id') ?? 0) + 1;

        return 'GA-' .
            date('Y') .
            '-' .
            str_pad(
                $nextId,
                5,
                '0',
                STR_PAD_LEFT
            );
    }
}