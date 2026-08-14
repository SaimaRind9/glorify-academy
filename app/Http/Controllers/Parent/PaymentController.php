<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\FeePayment;
use App\Models\Student;
use Illuminate\Http\Request;

class PaymentController extends Controller
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
    | Payment History
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $student = $this->getStudent();

        $query = FeePayment::with([
            'challan.academicSession',
            'receiver',
        ])
            ->whereHas('challan', function ($challanQuery) use ($student) {
                $challanQuery->where(
                    'student_id',
                    $student->id
                );
            });


        /*
        |--------------------------------------------------------------------------
        | Payment Method Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('payment_method')) {
            $query->where(
                'payment_method',
                $request->payment_method
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Year Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('year')) {
            $query->whereYear(
                'payment_date',
                $request->year
            );
        }


        $payments = $query
            ->orderByDesc('payment_date')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Available Years
        |--------------------------------------------------------------------------
        */

        $years = FeePayment::whereHas(
            'challan',
            function ($challanQuery) use ($student) {
                $challanQuery->where(
                    'student_id',
                    $student->id
                );
            }
        )
            ->selectRaw('YEAR(payment_date) as payment_year')
            ->whereNotNull('payment_date')
            ->distinct()
            ->orderByDesc('payment_year')
            ->pluck('payment_year');


        /*
        |--------------------------------------------------------------------------
        | Payment Methods
        |--------------------------------------------------------------------------
        */

        $paymentMethods = FeePayment::whereHas(
            'challan',
            function ($challanQuery) use ($student) {
                $challanQuery->where(
                    'student_id',
                    $student->id
                );
            }
        )
            ->whereNotNull('payment_method')
            ->where('payment_method', '!=', '')
            ->distinct()
            ->orderBy('payment_method')
            ->pluck('payment_method');


        /*
        |--------------------------------------------------------------------------
        | Summary
        |--------------------------------------------------------------------------
        */

        $allPayments = FeePayment::whereHas(
            'challan',
            function ($challanQuery) use ($student) {
                $challanQuery->where(
                    'student_id',
                    $student->id
                );
            }
        )->get();


        $totalPayments = $allPayments->count();

        $totalPaid = (float) $allPayments->sum('amount');


        return view(
            'parent.payments.index',
            compact(
                'student',
                'payments',
                'years',
                'paymentMethods',
                'totalPayments',
                'totalPaid'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Single Receipt
    |--------------------------------------------------------------------------
    */

    public function show(FeePayment $payment)
    {
        $student = $this->getStudent();

        $payment->load([
            'challan.student.classRoom',
            'challan.academicSession',
            'receiver',
        ]);


        /*
         * Security:
         * Parent can only open payments belonging to
         * their linked student's challan.
         */

        abort_if(
            !$payment->challan ||
            (int) $payment->challan->student_id !==
            (int) $student->id,
            403,
            'You are not authorized to view this payment receipt.'
        );


        return view(
            'parent.payments.show',
            compact(
                'student',
                'payment'
            )
        );
    }
}