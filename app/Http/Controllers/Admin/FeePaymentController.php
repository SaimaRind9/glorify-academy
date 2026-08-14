<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeeChallan;
use App\Models\FeePayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeePaymentController extends Controller
{
    public function create(FeeChallan $feeChallan)
    {
        $feeChallan->load([
            'student.classRoom',
            'student.shift',
            'academicSession',
            'payments'
        ]);

        return view(
            'admin.fee-payments.create',
            compact('feeChallan')
        );
    }


    public function store(Request $request, FeeChallan $feeChallan)
    {
        $validated = $request->validate([
            'payment_date' => [
                'required',
                'date',
            ],

            'amount' => [
                'required',
                'numeric',
                'min:1',
            ],

            'payment_method' => [
                'required',
                'in:Cash,Bank,Online',
            ],

            'reference_no' => [
                'nullable',
                'string',
                'max:255',
            ],

            'remarks' => [
                'nullable',
                'string',
            ],
        ]);


        if ($feeChallan->status === 'Cancelled') {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Payment cannot be received for a cancelled challan.'
                );
        }


        $remainingAmount =
            (float) $feeChallan->total_amount
            - (float) $feeChallan->paid_amount;


        if ((float) $validated['amount'] > $remainingAmount) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Payment amount cannot be greater than the remaining balance.'
                );
        }


        $payment = DB::transaction(function () use (
            $validated,
            $feeChallan
        ) {

            $payment = FeePayment::create([

                'fee_challan_id' => $feeChallan->id,

                'receipt_no' => $this->generateReceiptNumber(),

                'payment_date' => $validated['payment_date'],

                'amount' => $validated['amount'],

                'payment_method' =>
                    $validated['payment_method'],

                'reference_no' =>
                    $validated['reference_no'] ?? null,

                'remarks' =>
                    $validated['remarks'] ?? null,

                'received_by' =>
                    auth()->id(),

            ]);


            $newPaidAmount =
                (float) $feeChallan->paid_amount
                + (float) $validated['amount'];


            if ($newPaidAmount <= 0) {

                $status = 'Pending';

            } elseif (
                $newPaidAmount < (float) $feeChallan->total_amount
            ) {

                $status = 'Partial';

            } else {

                $status = 'Paid';
            }


            $feeChallan->update([

                'paid_amount' => $newPaidAmount,

                'status' => $status,

            ]);


            return $payment;
        });


        return redirect()
            ->route(
                'fee-payments.show',
                $payment->id
            )
            ->with(
                'success',
                'Payment Received Successfully.'
            );
    }


    public function show(FeePayment $feePayment)
    {
        $feePayment->load([
            'challan.student.classRoom',
            'challan.student.shift',
            'challan.academicSession',
            'challan.items',
            'receiver'
        ]);

        return view(
            'admin.fee-payments.show',
            compact('feePayment')
        );
    }


    private function generateReceiptNumber()
    {
        $nextId = (FeePayment::max('id') ?? 0) + 1;

        return 'REC-' .
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