@extends('layouts.admin')

@section('title', 'Student Fee History')

@section('content')

@php
    $months = [
        1 => 'January',
        2 => 'February',
        3 => 'March',
        4 => 'April',
        5 => 'May',
        6 => 'June',
        7 => 'July',
        8 => 'August',
        9 => 'September',
        10 => 'October',
        11 => 'November',
        12 => 'December',
    ];
@endphp

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                Student Fee History
            </h2>

            <p class="text-muted mb-0">
                Complete challan and payment history for
                <strong>{{ $student->name }}</strong>
            </p>

        </div>

        <a href="{{ route('fee-reports.index') }}"
           class="btn btn-secondary">

            <i class="fa-solid fa-arrow-left"></i>
            Back

        </a>

    </div>


    {{-- Student Information --}}

    <div class="card shadow-sm border-0 rounded-4 mb-4">

        <div class="card-body p-4">

            <div class="row">

                <div class="col-md-3 mb-3">

                    <small class="text-muted">
                        Student Name
                    </small>

                    <div class="fw-bold">
                        {{ $student->name }}
                    </div>

                </div>


                <div class="col-md-3 mb-3">

                    <small class="text-muted">
                        Student ID
                    </small>

                    <div class="fw-bold">
                        {{ $student->student_id }}
                    </div>

                </div>


                <div class="col-md-3 mb-3">

                    <small class="text-muted">
                        Class
                    </small>

                    <div class="fw-bold">
                        {{ $student->classRoom->class_name ?? 'N/A' }}
                    </div>

                </div>


                <div class="col-md-3 mb-3">

                    <small class="text-muted">
                        Shift
                    </small>

                    <div class="fw-bold">
                        {{ $student->shift->name ?? 'N/A' }}
                    </div>

                </div>


                <div class="col-md-3 mb-3">

                    <small class="text-muted">
                        Father Name
                    </small>

                    <div class="fw-bold">
                        {{ $student->father_name ?? 'N/A' }}
                    </div>

                </div>


                <div class="col-md-3 mb-3">

                    <small class="text-muted">
                        Contact
                    </small>

                    <div class="fw-bold">
                        {{ $student->contact ?? 'N/A' }}
                    </div>

                </div>


                <div class="col-md-3 mb-3">

                    <small class="text-muted">
                        Quran Classes
                    </small>

                    <div>

                        @if($student->quran_classes === 'Yes')

                            <span class="badge bg-success">
                                Yes
                            </span>

                        @else

                            <span class="badge bg-secondary">
                                No
                            </span>

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Summary Cards --}}

    <div class="row g-3 mb-4">

        <div class="col-md-4">

            <div class="card shadow-sm border-0 rounded-4">

                <div class="card-body">

                    <div class="text-muted mb-1">
                        Total Fee
                    </div>

                    <h3 class="fw-bold mb-0">
                        Rs. {{ number_format($totalFee, 0) }}
                    </h3>

                </div>

            </div>

        </div>


        <div class="col-md-4">

            <div class="card shadow-sm border-0 rounded-4">

                <div class="card-body">

                    <div class="text-muted mb-1">
                        Total Paid
                    </div>

                    <h3 class="fw-bold text-success mb-0">
                        Rs. {{ number_format($totalPaid, 0) }}
                    </h3>

                </div>

            </div>

        </div>


        <div class="col-md-4">

            <div class="card shadow-sm border-0 rounded-4">

                <div class="card-body">

                    <div class="text-muted mb-1">
                        Total Pending
                    </div>

                    <h3 class="fw-bold text-danger mb-0">
                        Rs. {{ number_format($totalPending, 0) }}
                    </h3>

                </div>

            </div>

        </div>

    </div>


    {{-- History Table --}}

    <div class="card shadow border-0 rounded-4">

        <div class="card-body p-4">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>
                            <th>#</th>
                            <th>Challan No</th>
                            <th>Session</th>
                            <th>Month</th>
                            <th>Total</th>
                            <th>Paid</th>
                            <th>Balance</th>
                            <th>Status</th>
                            <th>Payments</th>
                            <th>Action</th>
                        </tr>

                    </thead>


                    <tbody>

                    @forelse($challans as $challan)

                        @php
                            $balance =
                                (float) $challan->total_amount
                                - (float) $challan->paid_amount;
                        @endphp

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>


                            <td class="fw-semibold">

                                {{ $challan->challan_no }}

                            </td>


                            <td>

                                {{ $challan->academicSession->session_name ?? 'N/A' }}

                            </td>


                            <td>

                                {{ $months[$challan->month] ?? '' }}
                                {{ $challan->year }}

                            </td>


                            <td class="fw-bold">

                                Rs.
                                {{ number_format($challan->total_amount, 0) }}

                            </td>


                            <td class="text-success fw-semibold">

                                Rs.
                                {{ number_format($challan->paid_amount, 0) }}

                            </td>


                            <td class="text-danger fw-semibold">

                                Rs.
                                {{ number_format($balance, 0) }}

                            </td>


                            <td>

                                @if($challan->status === 'Paid')

                                    <span class="badge bg-success">
                                        Paid
                                    </span>

                                @elseif($challan->status === 'Partial')

                                    <span class="badge bg-warning text-dark">
                                        Partial
                                    </span>

                                @elseif($challan->status === 'Cancelled')

                                    <span class="badge bg-secondary">
                                        Cancelled
                                    </span>

                                @else

                                    <span class="badge bg-danger">
                                        Pending
                                    </span>

                                @endif

                            </td>


                            <td>

                                @if($challan->payments->count())

                                    @foreach($challan->payments as $payment)

                                        <div class="mb-1">

                                            <a href="{{ route(
                                                    'fee-payments.show',
                                                    $payment->id
                                                ) }}"
                                               class="btn btn-sm btn-outline-success">

                                                {{ $payment->receipt_no }}

                                            </a>

                                        </div>

                                    @endforeach

                                @else

                                    <span class="text-muted">
                                        No payment
                                    </span>

                                @endif

                            </td>


                            <td>

                                <a href="{{ route(
                                        'fee-challans.show',
                                        $challan->id
                                    ) }}"
                                   class="btn btn-sm btn-primary mb-1">

                                    <i class="fa-solid fa-eye"></i>
                                    Challan

                                </a>


                                @if(
                                    $challan->status !== 'Paid' &&
                                    $challan->status !== 'Cancelled'
                                )

                                    <a href="{{ route(
                                            'fee-payments.create',
                                            $challan->id
                                        ) }}"
                                       class="btn btn-sm btn-success mb-1">

                                        <i class="fa-solid fa-money-bill-wave"></i>
                                        Pay

                                    </a>

                                @endif

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td colspan="10"
                                class="text-center py-5">

                                <i class="fa-solid fa-receipt fa-3x text-muted mb-3"></i>

                                <h5>
                                    No Fee History Found
                                </h5>

                                <p class="text-muted mb-0">
                                    No challans have been generated for this student yet.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection