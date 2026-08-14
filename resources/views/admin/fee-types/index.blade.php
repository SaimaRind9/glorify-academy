@extends('layouts.admin')

@section('title', 'Fee Types')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                Fee Type Management
            </h2>

            <p class="text-muted mb-0">
                Manage academy fee categories
            </p>
        </div>

        <a href="{{ route('fee-types.create') }}"
           class="btn btn-primary">

            <i class="fa-solid fa-plus"></i>
            Add Fee Type

        </a>

    </div>


    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show"
             role="alert">

            <i class="fa-solid fa-circle-check me-1"></i>
            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close">
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
                            <th>Fee Name</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($feeTypes as $feeType)

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>

                                <td class="fw-semibold">
                                    {{ $feeType->fee_name }}
                                </td>

                                <td>
                                    @if($feeType->description)

                                        {{ \Illuminate\Support\Str::limit(
                                            $feeType->description,
                                            70
                                        ) }}

                                    @else

                                        <span class="text-muted">
                                            No description
                                        </span>

                                    @endif
                                </td>

                                <td>

                                    @if($feeType->status === 'Active')

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
                                            'fee-types.edit',
                                            $feeType->id
                                        ) }}"
                                       class="btn btn-sm btn-warning"
                                       title="Edit Fee Type">

                                        <i class="fa-solid fa-pen-to-square"></i>
                                        Edit

                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5"
                                    class="text-center py-5">

                                    <div class="mb-3">
                                        <i class="fa-solid fa-money-bill-wave fa-3x text-muted"></i>
                                    </div>

                                    <h5 class="mb-2">
                                        No Fee Types Found
                                    </h5>

                                    <p class="text-muted mb-3">
                                        Add your academy's fee categories to continue.
                                    </p>

                                    <a href="{{ route('fee-types.create') }}"
                                       class="btn btn-primary">

                                        <i class="fa-solid fa-plus"></i>
                                        Add First Fee Type

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