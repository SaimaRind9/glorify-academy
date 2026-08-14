@extends('layouts.admin')

@section('title', 'Student Fee Assignments')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                Student Fee Assignment
            </h2>

            <p class="text-muted mb-0">
                Manage student-specific fee settings
            </p>
        </div>

        <a href="{{ route('student-fee-assignments.create') }}"
           class="btn btn-primary">

            <i class="fa-solid fa-plus"></i>
            Add Assignment

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
                            <th>Student</th>
                            <th>Class</th>
                            <th>Shift</th>
                            <th>Session</th>
                            <th>Fee Type</th>
                            <th>Custom Amount</th>
                            <th>Effective From</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>

                    </thead>


                    <tbody>

                    @forelse($assignments as $assignment)

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>


                            <td>

                                <div class="fw-semibold">
                                    {{ $assignment->student->name ?? 'N/A' }}
                                </div>

                                <div class="small text-muted">
                                    {{ $assignment->student->student_id ?? '' }}
                                </div>

                            </td>


                            <td>

                                {{ $assignment->student->classRoom->class_name ?? 'N/A' }}

                            </td>


                            <td>

                                {{ $assignment->student->shift->name ?? 'N/A' }}

                            </td>


                            <td>

                                {{ $assignment->academicSession->session_name ?? 'N/A' }}

                            </td>


                            <td class="fw-semibold">

                                {{ $assignment->feeType->fee_name ?? 'N/A' }}

                            </td>


                            <td>

                                @if($assignment->custom_amount !== null)

                                    <span class="fw-bold text-primary">
                                        Rs.
                                        {{ number_format($assignment->custom_amount, 0) }}
                                    </span>

                                @else

                                    <span class="badge bg-light text-dark border">
                                        Default Fee Structure
                                    </span>

                                @endif

                            </td>


                            <td>

                                {{ $assignment->effective_from
                                    ? date(
                                        'd M Y',
                                        strtotime($assignment->effective_from)
                                    )
                                    : 'N/A'
                                }}

                            </td>


                            <td>

                                @if($assignment->status === 'Active')

                                    <span class="badge bg-success">
                                        Active
                                    </span>

                                @else

                                    <span class="badge bg-secondary">
                                        Inactive
                                    </span>

                                @endif

                            </td>


                            <td class="text-center">

                                <a href="{{ route(
                                        'student-fee-assignments.edit',
                                        $assignment->id
                                    ) }}"
                                   class="btn btn-warning btn-sm">

                                    <i class="fa-solid fa-pen-to-square"></i>
                                    Edit

                                </a>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td colspan="10"
                                class="text-center py-5">

                                <div class="mb-3">

                                    <i class="fa-solid fa-user-tag fa-3x text-muted"></i>

                                </div>

                                <h5>
                                    No Student Fee Assignments Found
                                </h5>

                                <p class="text-muted">
                                    Add a custom fee assignment only when a student's fee differs from the standard fee structure.
                                </p>

                                <a href="{{ route('student-fee-assignments.create') }}"
                                   class="btn btn-primary">

                                    <i class="fa-solid fa-plus"></i>
                                    Add Assignment

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