@extends('layouts.admin')

@section('title', 'Receive Fee Payment')

@section('content')

@php
    $remainingAmount =
        (float) $feeChallan->total_amount
        - (float) $feeChallan->paid_amount;
@endphp

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                Receive Fee Payment
            </h2>

            <p class="text-muted mb-0">
                Record payment against challan
                <strong>{{ $feeChallan->challan_no }}</strong>
            </p>
        </div>

        <a href="{{ route('fee-challans.index') }}"
           class="btn btn-secondary">

            <i class="fa-solid fa-arrow-left"></i>
            Back

        </a>

    </div>


    @if($errors->any())

        <div class="alert alert-danger">

            <ul class="mb-0">

                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif


    @if(session('error'))

        <div class="alert alert-danger">
            {{ session('error') }}
        </div>

    @endif


    <div class="row">

        {{-- Challan Summary --}}

        <div class="col-lg-5 mb-4">

            <div class="card shadow border-0 rounded-4">

                <div class="card-body p-4">

                    <h5 class="fw-bold mb-3">
                        Challan Summary
                    </h5>

                    <table class="table table-borderless mb-0">

                        <tr>
                            <th>Student</th>
                            <td>
                                {{ $feeChallan->student->name ?? 'N/A' }}
                            </td>
                        </tr>

                        <tr>
                            <th>Student ID</th>
                            <td>
                                {{ $feeChallan->student->student_id ?? 'N/A' }}
                            </td>
                        </tr>

                        <tr>
                            <th>Class</th>
                            <td>
                                {{ $feeChallan->student->classRoom->class_name ?? 'N/A' }}
                            </td>
                        </tr>

                        <tr>
                            <th>Shift</th>
                            <td>
                                {{ $feeChallan->student->shift->name ?? 'N/A' }}
                            </td>
                        </tr>

                        <tr>
                            <th>Session</th>
                            <td>
                                {{ $feeChallan->academicSession->session_name ?? 'N/A' }}
                            </td>
                        </tr>

                        <tr>
                            <th>Total Amount</th>
                            <td class="fw-bold">
                                Rs. {{ number_format($feeChallan->total_amount, 0) }}
                            </td>
                        </tr>

                        <tr>
                            <th>Already Paid</th>
                            <td class="text-success fw-bold">
                                Rs. {{ number_format($feeChallan->paid_amount, 0) }}
                            </td>
                        </tr>

                        <tr>
                            <th>Remaining</th>
                            <td class="text-danger fw-bold">
                                Rs. {{ number_format($remainingAmount, 0) }}
                            </td>
                        </tr>

                        <tr>
                            <th>Status</th>
                            <td>

                                @if($feeChallan->status === 'Paid')

                                    <span class="badge bg-success">
                                        Paid
                                    </span>

                                @elseif($feeChallan->status === 'Partial')

                                    <span class="badge bg-warning text-dark">
                                        Partial
                                    </span>

                                @else

                                    <span class="badge bg-danger">
                                        Pending
                                    </span>

                                @endif

                            </td>
                        </tr>

                    </table>

                </div>

            </div>

        </div>


        {{-- Payment Form --}}

        <div class="col-lg-7">

            <div class="card shadow border-0 rounded-4">

                <div class="card-body p-4">

                    <h5 class="fw-bold mb-3">
                        Payment Details
                    </h5>

                    @if($remainingAmount <= 0)

                        <div class="alert alert-success mb-0">

                            <i class="fa-solid fa-circle-check me-1"></i>

                            This challan is already fully paid.

                        </div>

                    @else

                        <form action="{{ route(
                                'fee-payments.store',
                                $feeChallan->id
                            ) }}"
                              method="POST">

                            @csrf

                            <div class="row">

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        Payment Date
                                    </label>

                                    <input type="date"
                                           name="payment_date"
                                           class="form-control"
                                           value="{{ old(
                                               'payment_date',
                                               now()->format('Y-m-d')
                                           ) }}"
                                           required>

                                </div>


                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        Amount
                                    </label>

                                    <input type="number"
                                           name="amount"
                                           class="form-control"
                                           value="{{ old('amount') }}"
                                           min="1"
                                           max="{{ $remainingAmount }}"
                                           step="0.01"
                                           placeholder="{{ $remainingAmount }}"
                                           required>

                                    <small class="text-muted">
                                        Maximum payable:
                                        Rs. {{ number_format($remainingAmount, 0) }}
                                    </small>

                                </div>


                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        Payment Method
                                    </label>

                                    <select name="payment_method"
                                            class="form-control"
                                            required>

                                        <option value="Cash"
                                            {{ old('payment_method') === 'Cash'
                                                ? 'selected'
                                                : '' }}>
                                            Cash
                                        </option>

                                        <option value="Bank"
                                            {{ old('payment_method') === 'Bank'
                                                ? 'selected'
                                                : '' }}>
                                            Bank
                                        </option>

                                        <option value="Online"
                                            {{ old('payment_method') === 'Online'
                                                ? 'selected'
                                                : '' }}>
                                            Online
                                        </option>

                                    </select>

                                </div>


                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        Reference No
                                    </label>

                                    <input type="text"
                                           name="reference_no"
                                           class="form-control"
                                           value="{{ old('reference_no') }}"
                                           placeholder="Optional">

                                </div>


                                <div class="col-md-12 mb-4">

                                    <label class="form-label">
                                        Remarks
                                    </label>

                                    <textarea name="remarks"
                                              class="form-control"
                                              rows="3"
                                              placeholder="Optional">{{ old('remarks') }}</textarea>

                                </div>

                            </div>


                            <button type="submit"
                                    class="btn btn-primary px-5">

                                <i class="fa-solid fa-money-bill-wave"></i>
                                Receive Payment

                            </button>

                        </form>

                    @endif

                </div>

            </div>

        </div>

    </div>

</div>

@endsection