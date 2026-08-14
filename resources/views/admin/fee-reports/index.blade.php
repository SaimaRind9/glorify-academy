@extends('layouts.admin')

@section('title', 'Fee Reports')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                Fee Reports
            </h2>

            <p class="text-muted mb-0">
                View fee collection, pending dues and student-wise fee status
            </p>
        </div>

    </div>


    {{-- Summary Cards --}}

    <div class="row g-3 mb-4">

        <div class="col-lg-3 col-md-6">

            <div class="card shadow-sm border-0 rounded-4">

                <div class="card-body">

                    <div class="text-muted mb-1">
                        Total Challans
                    </div>

                    <h3 class="fw-bold mb-0">
                        {{ $totalChallans }}
                    </h3>

                </div>

            </div>

        </div>


        <div class="col-lg-3 col-md-6">

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


        <div class="col-lg-3 col-md-6">

            <div class="card shadow-sm border-0 rounded-4">

                <div class="card-body">

                    <div class="text-muted mb-1">
                        Total Received
                    </div>

                    <h3 class="fw-bold text-success mb-0">
                        Rs. {{ number_format($totalPaid, 0) }}
                    </h3>

                </div>

            </div>

        </div>


        <div class="col-lg-3 col-md-6">

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


    {{-- Status Cards --}}

    <div class="row g-3 mb-4">

        <div class="col-md-3">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body text-center">

                    <span class="badge bg-success mb-2">
                        Paid
                    </span>

                    <h4 class="fw-bold mb-0">
                        {{ $paidCount }}
                    </h4>

                </div>

            </div>

        </div>


        <div class="col-md-3">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body text-center">

                    <span class="badge bg-warning text-dark mb-2">
                        Partial
                    </span>

                    <h4 class="fw-bold mb-0">
                        {{ $partialCount }}
                    </h4>

                </div>

            </div>

        </div>


        <div class="col-md-3">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body text-center">

                    <span class="badge bg-danger mb-2">
                        Pending
                    </span>

                    <h4 class="fw-bold mb-0">
                        {{ $pendingCount }}
                    </h4>

                </div>

            </div>

        </div>


        <div class="col-md-3">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body text-center">

                    <span class="badge bg-secondary mb-2">
                        Cancelled
                    </span>

                    <h4 class="fw-bold mb-0">
                        {{ $cancelledCount }}
                    </h4>

                </div>

            </div>

        </div>

    </div>


    {{-- Filters --}}

    <div class="card shadow border-0 rounded-4 mb-4">

        <div class="card-body p-4">

            <h5 class="fw-bold mb-3">
                Filter Report
            </h5>


            <form method="GET"
                  action="{{ route('fee-reports.index') }}">

                <div class="row">


                    <div class="col-lg-3 col-md-6 mb-3">

                        <label class="form-label">
                            Academic Session
                        </label>

                        <select name="academic_session_id"
                                class="form-control">

                            <option value="">
                                All Sessions
                            </option>

                            @foreach($academicSessions as $session)

                                <option value="{{ $session->id }}"
                                    {{ request('academic_session_id') == $session->id ? 'selected' : '' }}>

                                    {{ $session->session_name }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    <div class="col-lg-3 col-md-6 mb-3">

                        <label class="form-label">
                            Month
                        </label>

                        <select name="month"
                                class="form-control">

                            <option value="">
                                All Months
                            </option>

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

                            @foreach($months as $number => $name)

                                <option value="{{ $number }}"
                                    {{ request('month') == $number ? 'selected' : '' }}>

                                    {{ $name }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    <div class="col-lg-3 col-md-6 mb-3">

                        <label class="form-label">
                            Year
                        </label>

                        <input type="number"
                               name="year"
                               class="form-control"
                               value="{{ request('year') }}"
                               placeholder="2026">

                    </div>


                    <div class="col-lg-3 col-md-6 mb-3">

                        <label class="form-label">
                            Status
                        </label>

                        <select name="status"
                                class="form-control">

                            <option value="">
                                All Status
                            </option>

                            <option value="Paid"
                                {{ request('status') === 'Paid' ? 'selected' : '' }}>
                                Paid
                            </option>

                            <option value="Partial"
                                {{ request('status') === 'Partial' ? 'selected' : '' }}>
                                Partial
                            </option>

                            <option value="Pending"
                                {{ request('status') === 'Pending' ? 'selected' : '' }}>
                                Pending
                            </option>

                            <option value="Cancelled"
                                {{ request('status') === 'Cancelled' ? 'selected' : '' }}>
                                Cancelled
                            </option>

                        </select>

                    </div>


                    <div class="col-lg-3 col-md-6 mb-3">

                        <label class="form-label">
                            Class
                        </label>

                        <select name="class_room_id"
                                class="form-control">

                            <option value="">
                                All Classes
                            </option>

                            @foreach($classes as $class)

                                <option value="{{ $class->id }}"
                                    {{ request('class_room_id') == $class->id ? 'selected' : '' }}>

                                    {{ $class->class_name }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    <div class="col-lg-3 col-md-6 mb-3">

                        <label class="form-label">
                            Shift
                        </label>

                        <select name="shift_id"
                                class="form-control">

                            <option value="">
                                All Shifts
                            </option>

                            @foreach($shifts as $shift)

                                <option value="{{ $shift->id }}"
                                    {{ request('shift_id') == $shift->id ? 'selected' : '' }}>

                                    {{ $shift->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    <div class="col-lg-3 col-md-6 mb-3">

                        <label class="form-label">
                            Student
                        </label>

                        <select name="student_id"
                                class="form-control">

                            <option value="">
                                All Students
                            </option>

                            @foreach($students as $student)

                                <option value="{{ $student->id }}"
                                    {{ request('student_id') == $student->id ? 'selected' : '' }}>

                                    {{ $student->name }}
                                    - {{ $student->student_id }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    <div class="col-lg-3 col-md-6 mb-3 d-flex align-items-end">

                        <div class="d-flex gap-2 w-100">

                            <button type="submit"
                                    class="btn btn-primary flex-fill">

                                <i class="fa-solid fa-filter"></i>
                                Filter

                            </button>


                            <a href="{{ route('fee-reports.index') }}"
                               class="btn btn-secondary">

                                Reset

                            </a>

                        </div>

                    </div>


                </div>

            </form>

        </div>

    </div>


    {{-- Report Table --}}

    <div class="card shadow border-0 rounded-4">

        <div class="card-body p-4">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>
                            <th>#</th>
                            <th>Challan</th>
                            <th>Student</th>
                            <th>Class</th>
                            <th>Shift</th>
                            <th>Month</th>
                            <th>Total</th>
                            <th>Paid</th>
                            <th>Balance</th>
                            <th>Status</th>
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

                                <div class="fw-semibold">
                                    {{ $challan->student->name ?? 'N/A' }}
                                </div>

                                <div class="small text-muted">
                                    {{ $challan->student->student_id ?? '' }}
                                </div>

                            </td>


                            <td>
                                {{ $challan->student->classRoom->class_name ?? 'N/A' }}
                            </td>


                            <td>
                                {{ $challan->student->shift->name ?? 'N/A' }}
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

                                <a href="{{ route(
                                        'fee-reports.student',
                                        $challan->student_id
                                    ) }}"
                                   class="btn btn-sm btn-primary">

                                    <i class="fa-solid fa-clock-rotate-left"></i>
                                    History

                                </a>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td colspan="11"
                                class="text-center py-5">

                                <i class="fa-solid fa-chart-column fa-3x text-muted mb-3"></i>

                                <h5>
                                    No Fee Records Found
                                </h5>

                                <p class="text-muted mb-0">
                                    Try changing the report filters.
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