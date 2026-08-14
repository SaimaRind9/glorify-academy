@extends('layouts.admin')

@section('title', 'Fee Receipt')

@section('content')

@php

    $challan = $feePayment->challan;

    $student = $challan->student;

    $remainingAmount =
        (float) $challan->total_amount
        - (float) $challan->paid_amount;

@endphp


<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4 no-print">

        <div>

            <h2 class="fw-bold mb-1">
                Fee Receipt
            </h2>

            <p class="text-muted mb-0">
                Receipt No:
                <strong>{{ $feePayment->receipt_no }}</strong>
            </p>

        </div>


        <div class="d-flex gap-2">

            <a href="{{ route('fee-challans.index') }}"
               class="btn btn-secondary">

                <i class="fa-solid fa-arrow-left"></i>
                Back

            </a>

            <button type="button"
                    class="btn btn-primary"
                    onclick="window.print()">

                <i class="fa-solid fa-print"></i>
                Print Receipt

            </button>

        </div>

    </div>


    @if(session('success'))

        <div class="alert alert-success no-print">
            {{ session('success') }}
        </div>

    @endif


    <div class="receipt-wrapper">

        <div class="receipt-card">

            <div class="receipt-header">

                <div>

                    <h2>
                        THE GLORIFY ACADEMY
                    </h2>

                    <p class="mb-0">
                        Umerkot
                    </p>

                </div>

                <div class="receipt-title">
                    FEE RECEIPT
                </div>

            </div>


            <div class="receipt-number">

                <strong>Receipt No:</strong>
                {{ $feePayment->receipt_no }}

                <span class="float-end">

                    <strong>Date:</strong>

                    {{ $feePayment->payment_date
                        ? date(
                            'd M Y',
                            strtotime($feePayment->payment_date)
                        )
                        : 'N/A'
                    }}

                </span>

            </div>


            <div class="section-title">
                Student Information
            </div>


            <table class="receipt-table">

                <tr>

                    <th>
                        Student Name
                    </th>

                    <td>
                        {{ $student->name ?? 'N/A' }}
                    </td>

                    <th>
                        Student ID
                    </th>

                    <td>
                        {{ $student->student_id ?? 'N/A' }}
                    </td>

                </tr>


                <tr>

                    <th>
                        Father Name
                    </th>

                    <td>
                        {{ $student->father_name ?? 'N/A' }}
                    </td>

                    <th>
                        Class
                    </th>

                    <td>
                        {{ $student->classRoom->class_name ?? 'N/A' }}
                    </td>

                </tr>


                <tr>

                    <th>
                        Shift
                    </th>

                    <td>
                        {{ $student->shift->name ?? 'N/A' }}
                    </td>

                    <th>
                        Session
                    </th>

                    <td>
                        {{ $challan->academicSession->session_name ?? 'N/A' }}
                    </td>

                </tr>


                <tr>

                    <th>
                        Challan No
                    </th>

                    <td>
                        {{ $challan->challan_no }}
                    </td>

                    <th>
                        Contact
                    </th>

                    <td>
                        {{ $student->contact ?? 'N/A' }}
                    </td>

                </tr>

            </table>


            <div class="section-title">
                Payment Information
            </div>


            <table class="receipt-table">

                <tr>

                    <th>
                        Total Challan
                    </th>

                    <td>
                        Rs.
                        {{ number_format($challan->total_amount, 0) }}
                    </td>

                    <th>
                        This Payment
                    </th>

                    <td class="fw-bold text-success">
                        Rs.
                        {{ number_format($feePayment->amount, 0) }}
                    </td>

                </tr>


                <tr>

                    <th>
                        Total Paid
                    </th>

                    <td>
                        Rs.
                        {{ number_format($challan->paid_amount, 0) }}
                    </td>

                    <th>
                        Remaining
                    </th>

                    <td class="fw-bold">

                        Rs.
                        {{ number_format($remainingAmount, 0) }}

                    </td>

                </tr>


                <tr>

                    <th>
                        Payment Method
                    </th>

                    <td>
                        {{ $feePayment->payment_method }}
                    </td>

                    <th>
                        Reference No
                    </th>

                    <td>
                        {{ $feePayment->reference_no ?? '—' }}
                    </td>

                </tr>


                <tr>

                    <th>
                        Status
                    </th>

                    <td>

                        @if($challan->status === 'Paid')

                            <span class="badge bg-success">
                                Paid
                            </span>

                        @elseif($challan->status === 'Partial')

                            <span class="badge bg-warning text-dark">
                                Partial
                            </span>

                        @else

                            <span class="badge bg-danger">
                                Pending
                            </span>

                        @endif

                    </td>

                    <th>
                        Received By
                    </th>

                    <td>
                        {{ $feePayment->receiver->name ?? 'Admin' }}
                    </td>

                </tr>

            </table>


            @if($feePayment->remarks)

                <div class="remarks-box">

                    <strong>
                        Remarks:
                    </strong>

                    {{ $feePayment->remarks }}

                </div>

            @endif


            <div class="signature-row">

                <div>

                    <div class="signature-line"></div>

                    <span>
                        Parent / Student
                    </span>

                </div>


                <div>

                    <div class="signature-line"></div>

                    <span>
                        Received By
                    </span>

                </div>

            </div>


            <div class="receipt-footer">

                Thank you for your payment.

            </div>

        </div>

    </div>

</div>

@endsection


@push('styles')

<style>

.receipt-wrapper{
    max-width:900px;
    margin:0 auto;
}

.receipt-card{
    background:#fff;
    border:1px solid #ddd;
    padding:30px;
    border-radius:14px;
}

.receipt-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding-bottom:15px;
    border-bottom:3px solid #174ea6;
}

.receipt-header h2{
    margin:0;
    color:#174ea6;
    font-weight:900;
}

.receipt-title{
    font-size:22px;
    font-weight:900;
    color:#174ea6;
}

.receipt-number{
    margin-top:18px;
    padding:10px;
    background:#f8f9fa;
    border:1px solid #ddd;
}

.section-title{
    margin-top:20px;
    background:#174ea6;
    color:#fff;
    padding:8px 10px;
    font-weight:800;
}

.receipt-table{
    width:100%;
    border-collapse:collapse;
}

.receipt-table th,
.receipt-table td{
    border:1px solid #ddd;
    padding:10px;
}

.receipt-table th{
    background:#f8f9fa;
    width:20%;
}

.remarks-box{
    margin-top:18px;
    padding:12px;
    border:1px solid #ddd;
}

.signature-row{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:120px;
    margin-top:60px;
    text-align:center;
}

.signature-line{
    border-top:1px solid #333;
}

.signature-row span{
    display:block;
    margin-top:5px;
    font-weight:600;
}

.receipt-footer{
    margin-top:30px;
    padding-top:12px;
    border-top:1px solid #ddd;
    text-align:center;
    color:#666;
}


@media print{

    @page{
        size:A4 portrait;
        margin:12mm;
    }

    body *{
        visibility:hidden;
    }

    .receipt-wrapper,
    .receipt-wrapper *{
        visibility:visible;
    }

    .receipt-wrapper{
        position:absolute;
        left:0;
        top:0;
        width:100%;
        max-width:none;
    }

    .receipt-card{
        border:none;
        box-shadow:none;
        padding:0;
    }

    .no-print{
        display:none !important;
    }

}

</style>

@endpush