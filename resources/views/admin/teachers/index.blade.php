@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <!-- Page Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">

        <div>
            <h2 class="fw-bold mb-1">Teachers Management</h2>
            <p class="text-muted mb-0">
                Manage all academy teachers and their assigned classes.
            </p>
        </div>

        <a href="{{ route('teachers.create') }}"
           class="btn btn-primary px-4 py-2">

            <i class="fa-solid fa-plus me-2"></i>
            Add Teacher

        </a>

    </div>


    <!-- Success Message -->
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show" role="alert">

            <i class="fa-solid fa-circle-check me-2"></i>

            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">

        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body d-flex align-items-center justify-content-between">

                    <div>
                        <p class="text-muted mb-1">Total Teachers</p>
                        <h3 class="fw-bold mb-0">
                            {{ $totalTeachers }}
                        </h3>
                    </div>

                    <div class="fs-2 text-primary">
                        <i class="fa-solid fa-chalkboard-user"></i>
                    </div>

                </div>

            </div>

        </div>


        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body d-flex align-items-center justify-content-between">

                    <div>
                        <p class="text-muted mb-1">Active Teachers</p>
                        <h3 class="fw-bold mb-0">
                            {{ $activeTeachers }}
                        </h3>
                    </div>

                    <div class="fs-2 text-success">
                        <i class="fa-solid fa-user-check"></i>
                    </div>

                </div>

            </div>

        </div>


        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body d-flex align-items-center justify-content-between">

                    <div>
                        <p class="text-muted mb-1">Inactive Teachers</p>
                        <h3 class="fw-bold mb-0">
                            {{ $inactiveTeachers }}
                        </h3>
                    </div>

                    <div class="fs-2 text-danger">
                        <i class="fa-solid fa-user-xmark"></i>
                    </div>

                </div>

            </div>

        </div>


        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body d-flex align-items-center justify-content-between">

                    <div>
                        <p class="text-muted mb-1">Assigned Teachers</p>
                        <h3 class="fw-bold mb-0">
                            {{ $assignedTeachers }}
                        </h3>
                    </div>

                    <div class="fs-2 text-warning">
                        <i class="fa-solid fa-school"></i>
                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- Search and Filters -->
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <form method="GET"
                  action="{{ route('teachers.index') }}">

                <div class="row g-3 align-items-end">

                    <div class="col-lg-5 col-md-12">

                        <label class="form-label fw-semibold">
                            Search Teacher
                        </label>

                        <div class="input-group">

                            <span class="input-group-text bg-white">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </span>

                            <input type="text"
                                   name="search"
                                   class="form-control"
                                   placeholder="Search by name, ID, email or phone"
                                   value="{{ request('search') }}">

                        </div>

                    </div>


                    <div class="col-lg-2 col-md-4">

                        <label class="form-label fw-semibold">
                            Status
                        </label>

                        <select name="status"
                                class="form-select">

                            <option value="">All Status</option>

                            <option value="Active"
                                {{ request('status') == 'Active' ? 'selected' : '' }}>
                                Active
                            </option>

                            <option value="Inactive"
                                {{ request('status') == 'Inactive' ? 'selected' : '' }}>
                                Inactive
                            </option>

                        </select>

                    </div>


                    <div class="col-lg-3 col-md-4">

                        <label class="form-label fw-semibold">
                            Assigned Class
                        </label>

                        <select name="class_room_id"
                                class="form-select">

                            <option value="">All Classes</option>

                            @foreach($classes as $class)

                                <option value="{{ $class->id }}"
                                    {{ request('class_room_id') == $class->id ? 'selected' : '' }}>

                                    {{ $class->class_name }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    <div class="col-lg-2 col-md-4">

                        <div class="d-flex gap-2">

                            <button type="submit"
                                    class="btn btn-primary flex-grow-1">

                                <i class="fa-solid fa-filter me-1"></i>
                                Filter

                            </button>

                            <a href="{{ route('teachers.index') }}"
                               class="btn btn-outline-secondary">

                                <i class="fa-solid fa-rotate-left"></i>

                            </a>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>


    <!-- Teachers Table -->
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white border-0 py-3">

            <div class="d-flex justify-content-between align-items-center">

                <h5 class="fw-bold mb-0">
                    Teachers List
                </h5>

                <span class="badge bg-light text-dark border">
                    {{ $teachers->count() }} Records
                </span>

            </div>

        </div>


        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th class="ps-4">Teacher</th>

                            <th>Teacher ID</th>

                            <th>Contact</th>

                            <th>Qualification</th>

                            <th>Assigned Class</th>

                            <th>Status</th>

                            <th class="text-center pe-4">Actions</th>

                        </tr>

                    </thead>


                    <tbody>

                    @forelse($teachers as $teacher)

                        <tr>

                            <!-- Teacher -->
                            <td class="ps-4">

                                <div class="d-flex align-items-center gap-3">

                                    @if($teacher->photo)

                                        <img src="{{ asset('storage/' . $teacher->photo) }}"
                                             alt="{{ $teacher->name }}"
                                             width="48"
                                             height="48"
                                             class="rounded-circle object-fit-cover border">

                                    @else

                                        <div class="rounded-circle bg-primary-subtle text-primary
                                                    d-flex align-items-center justify-content-center fw-bold"
                                             style="width:48px; height:48px;">

                                            {{ strtoupper(substr($teacher->name, 0, 1)) }}

                                        </div>

                                    @endif


                                    <div>

                                        <h6 class="fw-semibold mb-1">
                                            {{ $teacher->name }}
                                        </h6>

                                        <small class="text-muted">
                                            {{ $teacher->email }}
                                        </small>

                                    </div>

                                </div>

                            </td>


                            <!-- Teacher ID -->
                            <td>

                                <span class="fw-semibold">
                                    {{ $teacher->teacher_id }}
                                </span>

                            </td>


                            <!-- Contact -->
                            <td>

                                <div>
                                    <i class="fa-solid fa-phone text-muted me-1"></i>
                                    {{ $teacher->phone }}
                                </div>

                            </td>


                            <!-- Qualification -->
                            <td>

                                {{ $teacher->qualification ?? 'Not Provided' }}

                                @if($teacher->experience)

                                    <div>
                                        <small class="text-muted">
                                            Experience: {{ $teacher->experience }}
                                        </small>
                                    </div>

                                @endif

                            </td>


                            <!-- Assigned Class -->
                            <td>

                                @if($teacher->classRoom)

                                    <span class="badge bg-info-subtle text-info-emphasis border">

                                        <i class="fa-solid fa-school me-1"></i>

                                        {{ $teacher->classRoom->class_name }}

                                    </span>

                                @else

                                    <span class="badge bg-light text-muted border">
                                        Not Assigned
                                    </span>

                                @endif

                            </td>


                            <!-- Status -->
                            <td>

                                @if($teacher->status === 'Active')

                                    <span class="badge bg-success-subtle text-success border border-success-subtle">

                                        <i class="fa-solid fa-circle-check me-1"></i>
                                        Active

                                    </span>

                                @else

                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle">

                                        <i class="fa-solid fa-circle-xmark me-1"></i>
                                        Inactive

                                    </span>

                                @endif

                            </td>


                            <!-- Actions -->
                            <td class="text-center pe-4">

    <div class="d-flex justify-content-center gap-2">

        <a href="{{ route('teachers.show', ['teacher' => $teacher->id]) }}"
           class="btn btn-sm btn-outline-primary"
           title="View Teacher">

            <i class="fa-solid fa-eye"></i>

        </a>

        <a href="{{ route('teachers.edit', ['teacher' => $teacher->id]) }}"
           class="btn btn-sm btn-outline-warning"
           title="Edit Teacher">

            <i class="fa-solid fa-pen-to-square"></i>

        </a>

        <form action="{{ route('teachers.destroy', ['teacher' => $teacher->id]) }}"
              method="POST"
              class="d-inline"
              onsubmit="return confirm('Are you sure you want to delete this teacher?')">

            @csrf
            @method('DELETE')

            <button type="submit"
                    class="btn btn-sm btn-outline-danger"
                    title="Delete Teacher">

                <i class="fa-solid fa-trash"></i>

            </button>

        </form>

    </div>

</td>

                    @empty

                        <tr>

                            <td colspan="7"
                                class="text-center py-5">

                                <div class="text-muted">

                                    <i class="fa-solid fa-chalkboard-user fa-3x mb-3"></i>

                                    <h5>No Teachers Found</h5>

                                    <p class="mb-3">
                                        No teacher records match your current search or filters.
                                    </p>

                                    <a href="{{ route('teachers.create') }}"
                                       class="btn btn-primary">

                                        <i class="fa-solid fa-plus me-2"></i>
                                        Add First Teacher

                                    </a>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection