@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold">
                Shift Management
            </h2>

            <p class="text-muted mb-0">
                Manage academy shifts and timings
            </p>
        </div>

        <a href="{{ route('shifts.create') }}"
           class="btn btn-primary">

            <i class="fa-solid fa-plus"></i>
            Add Shift

        </a>

    </div>


    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    <div class="card shadow border-0 rounded-4">

        <div class="card-body p-4">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>
                            <th>#</th>
                            <th>Shift Name</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($shifts as $shift)

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>

                                <td class="fw-semibold">
                                    {{ $shift->name }}
                                </td>

                                <td>
                                    {{ $shift->start_time
                                        ? \Carbon\Carbon::parse($shift->start_time)->format('h:i A')
                                        : '—' }}
                                </td>

                                <td>
                                    {{ $shift->end_time
                                        ? \Carbon\Carbon::parse($shift->end_time)->format('h:i A')
                                        : '—' }}
                                </td>

                                <td>

                                    @if($shift->status === 'Active')

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

                                    <a href="{{ route('shifts.edit', $shift->id) }}"
                                       class="btn btn-sm btn-warning">

                                        <i class="fa-solid fa-pen-to-square"></i>
                                        Edit

                                    </a>


                                    <form action="{{ route('shifts.toggle-status', $shift->id) }}"
                                          method="POST"
                                          class="d-inline">

                                        @csrf
                                        @method('PATCH')

                                        @if($shift->status === 'Active')

                                            <button type="submit"
                                                    class="btn btn-sm btn-secondary"
                                                    onclick="return confirm('Do you want to make this shift inactive?')">

                                                <i class="fa-solid fa-ban"></i>
                                                Inactive

                                            </button>

                                        @else

                                            <button type="submit"
                                                    class="btn btn-sm btn-success"
                                                    onclick="return confirm('Do you want to activate this shift?')">

                                                <i class="fa-solid fa-circle-check"></i>
                                                Activate

                                            </button>

                                        @endif

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6"
                                    class="text-center text-muted py-4">

                                    No shifts found.

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