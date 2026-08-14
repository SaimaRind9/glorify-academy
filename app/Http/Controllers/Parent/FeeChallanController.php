<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\FeeChallan;
use App\Models\Student;
use Illuminate\Http\Request;

class FeeChallanController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Get Parent's Linked Student
    |--------------------------------------------------------------------------
    */

    private function getStudent(): Student
    {
        $user = auth()->user();

        return Student::with('classRoom')
            ->findOrFail($user->student_id);
    }


    /*
    |--------------------------------------------------------------------------
    | Fee Challan List
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $student = $this->getStudent();

        $query = FeeChallan::with([
            'academicSession',
            'items',
            'payments',
        ])
            ->where('student_id', $student->id);


        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Year Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('year')) {

            $query->where(
                'year',
                $request->year
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Challans
        |--------------------------------------------------------------------------
        */

        $challans = $query
            ->orderByDesc('year')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Available Years
        |--------------------------------------------------------------------------
        */

        $years = FeeChallan::where(
            'student_id',
            $student->id
        )
            ->whereNotNull('year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');


        /*
        |--------------------------------------------------------------------------
        | Dashboard Summary
        |--------------------------------------------------------------------------
        */

        $allChallans = FeeChallan::where(
            'student_id',
            $student->id
        )->get();


        $totalChallans =
            $allChallans->count();


        $totalAmount =
            (float) $allChallans->sum(
                'total_amount'
            );


        $paidAmount =
            (float) $allChallans->sum(
                'paid_amount'
            );


        $pendingAmount =
            max(
                0,
                $totalAmount - $paidAmount
            );


        return view(
            'parent.fee-challans.index',
            compact(
                'student',
                'challans',
                'years',
                'totalChallans',
                'totalAmount',
                'paidAmount',
                'pendingAmount'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Single Fee Challan
    |--------------------------------------------------------------------------
    */

    public function show(FeeChallan $feeChallan)
    {
        $student = $this->getStudent();


        /*
         * Security:
         * Parent cannot open another student's challan
         * by manually changing the URL.
         */

        abort_if(
            (int) $feeChallan->student_id !==
            (int) $student->id,
            403,
            'You are not authorized to view this fee challan.'
        );


        $feeChallan->load([
            'student.classRoom',
            'academicSession',
            'items',
            'payments',
        ]);


        $remainingAmount = max(
            0,
            (float) $feeChallan->total_amount -
            (float) $feeChallan->paid_amount
        );


        return view(
            'parent.fee-challans.show',
            compact(
                'student',
                'feeChallan',
                'remainingAmount'
            )
        );
    }
}