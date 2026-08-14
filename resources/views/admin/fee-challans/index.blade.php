@extends('layouts.admin')

@section('title', 'Fee Challans')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                Fee Challans
            </h2>

            <p class="text-muted mb-0">
                View and manage generated student fee challans
            </p>
        </div>

        <a href="{{ route('fee-challans.create') }}"
           class="btn btn-primary">

            <i class="fa-solid fa-plus"></i>
            Generate Challan

        </a>

    </div>


    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            <i class="fa-solid fa-circle-check me-1"></i>
            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    @if(session('error'))

        <div class="alert alert-danger alert-dismissible fade show">

            {{ session('error') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    <div class="card shadow border-0 rounded-4">

        <div class="card-body p-4">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>
                            <th>#</th>
                            <th>Challan No</th>
                            <th>Student</th>
                            <th>Class</th>
                            <th>Shift</th>
                            <th>Session</th>
                            <th>Month</th>
                            <th>Total</th>
                            <th>Paid</th>
                            <th>Status</th>
                            <th>Due Date</th>
                            <th class="text-center">Action</th>
                        </tr>

                    </thead>


                    <tbody>

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


                    @forelse($challans as $challan)

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

                                {{ $challan->academicSession->session_name ?? 'N/A' }}

                            </td>


                            <td>

                                {{ $months[$challan->month] ?? 'N/A' }}

                                {{ $challan->year }}

                            </td>


                            <td class="fw-bold">

                                Rs.
                                {{ number_format($challan->total_amount, 0) }}

                            </td>


                            <td>

                                Rs.
                                {{ number_format($challan->paid_amount, 0) }}

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

                                {{ $challan->due_date
                                    ? date(
                                        'd M Y',
                                        strtotime($challan->due_date)
                                    )
                                    : 'N/A'
                                }}

                            </td>


                            <td class="text-center">

    <a href="{{ route(
            'fee-challans.show',
            $challan->id
        ) }}"
       class="btn btn-sm btn-primary mb-1">

        <i class="fa-solid fa-eye"></i>
        View

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
            Receive Payment

        </a>

    @endif

</td>

                        </tr>


                    @empty

                        <tr>

                            <td colspan="12"
                                class="text-center py-5">

                                <div class="mb-3">
                                    <i class="fa-solid fa-file-invoice-dollar fa-3x text-muted"></i>
                                </div>

                                <h5>
                                    No Fee Challans Found
                                </h5>

                                <p class="text-muted">
                                    Generate the first monthly fee challan.
                                </p>

                                <a href="{{ route('fee-challans.create') }}"
                                   class="btn btn-primary">

                                    <i class="fa-solid fa-plus"></i>
                                    Generate Challan

                                </a>

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