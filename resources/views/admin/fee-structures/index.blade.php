@extends('layouts.admin')

@section('title', 'Fee Structure')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                Fee Structure Management
            </h2>

            <p class="text-muted mb-0">
                Manage class, shift and session wise fee structure
            </p>
        </div>

        <a href="{{ route('fee-structures.create') }}"
           class="btn btn-primary">

            <i class="fa-solid fa-plus"></i>
            Add Fee Structure

        </a>

    </div>


    {{-- Success Message --}}

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


    {{-- Error Message --}}

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

                            <th>Session</th>

                            <th>Class</th>

                            <th>Shift</th>

                            <th>Fee Type</th>

                            <th>Amount</th>

                            <th>Effective From</th>

                            <th>Status</th>

                            <th class="text-center">
                                Action
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                    @forelse($feeStructures as $feeStructure)

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>


                            <td>

                                {{ $feeStructure->academicSession->session_name ?? 'N/A' }}

                            </td>


                            <td>

                                {{ $feeStructure->classRoom->class_name ?? 'N/A' }}

                            </td>


                            <td>

                                {{ $feeStructure->shift->name ?? 'N/A' }}

                            </td>


                            <td class="fw-semibold">

                                {{ $feeStructure->feeType->fee_name ?? 'N/A' }}

                            </td>


                            <td class="fw-bold">

                                Rs.
                                {{ number_format($feeStructure->amount, 0) }}

                            </td>


                            <td>

                                {{ date(
                                    'd M Y',
                                    strtotime($feeStructure->effective_from)
                                ) }}

                            </td>


                            <td>

                                @if($feeStructure->status === 'Active')

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
                                        'fee-structures.edit',
                                        $feeStructure->id
                                    ) }}"
                                   class="btn btn-warning btn-sm">

                                    <i class="fa-solid fa-pen-to-square"></i>

                                    Edit

                                </a>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td colspan="9"
                                class="text-center py-5">

                                <div class="mb-3">

                                    <i class="fa-solid fa-money-check-dollar fa-3x text-muted"></i>

                                </div>

                                <h5>
                                    No Fee Structure Found
                                </h5>

                                <p class="text-muted">

                                    Create your first fee structure.

                                </p>

                                <a href="{{ route('fee-structures.create') }}"
                                   class="btn btn-primary">

                                    <i class="fa-solid fa-plus"></i>

                                    Add Fee Structure

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