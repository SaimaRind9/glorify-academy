@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">

        <div>
            <h2 class="fw-bold mb-1">Teacher Details</h2>
            <p class="text-muted mb-0">
                View complete teacher information.
            </p>
        </div>

        <div class="d-flex gap-2">

            <a href="{{ route('teachers.edit', $teacher->id) }}"
               class="btn btn-warning">

                <i class="fa-solid fa-pen-to-square me-2"></i>
                Edit Teacher

            </a>

            <a href="{{ route('teachers.index') }}"
               class="btn btn-outline-secondary">

                <i class="fa-solid fa-arrow-left me-2"></i>
                Back

            </a>

        </div>

    </div>


    <div class="row g-4">

        <div class="col-lg-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body text-center p-4">

                    @if($teacher->photo)

                        <img src="{{ asset('storage/' . $teacher->photo) }}"
                             alt="{{ $teacher->name }}"
                             class="rounded-circle object-fit-cover border mb-3"
                             width="150"
                             height="150">

                    @else

                        <div class="rounded-circle bg-primary-subtle text-primary
                                    d-flex align-items-center justify-content-center
                                    fw-bold mx-auto mb-3"
                             style="width:150px; height:150px; font-size:55px;">

                            {{ strtoupper(substr($teacher->name, 0, 1)) }}

                        </div>

                    @endif

                    <h4 class="fw-bold mb-1">
                        {{ $teacher->name }}
                    </h4>

                    <p class="text-muted mb-3">
                        {{ $teacher->teacher_id }}
                    </p>

                    @if($teacher->status === 'Active')

                        <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2">

                            <i class="fa-solid fa-circle-check me-1"></i>
                            Active

                        </span>

                    @else

                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2">

                            <i class="fa-solid fa-circle-xmark me-1"></i>
                            Inactive

                        </span>

                    @endif

                </div>

            </div>

        </div>


        <div class="col-lg-8">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white border-0 py-3">

                    <h5 class="fw-bold mb-0">

                        <i class="fa-solid fa-circle-info text-primary me-2"></i>
                        Personal Information

                    </h5>

                </div>

                <div class="card-body">

                    <div class="row g-4">

                        <div class="col-md-6">

                            <label class="text-muted small mb-1">
                                Full Name
                            </label>

                            <p class="fw-semibold mb-0">
                                {{ $teacher->name }}
                            </p>

                        </div>


                        <div class="col-md-6">

                            <label class="text-muted small mb-1">
                                Teacher ID
                            </label>

                            <p class="fw-semibold mb-0">
                                {{ $teacher->teacher_id }}
                            </p>

                        </div>


                        <div class="col-md-6">

                            <label class="text-muted small mb-1">
                                Email Address
                            </label>

                            <p class="fw-semibold mb-0">
                                {{ $teacher->email ?? 'Not Provided' }}
                            </p>

                        </div>


                        <div class="col-md-6">

                            <label class="text-muted small mb-1">
                                Contact Number
                            </label>

                            <p class="fw-semibold mb-0">
                                {{ $teacher->phone ?? 'Not Provided' }}
                            </p>

                        </div>


                        <div class="col-md-6">

                            <label class="text-muted small mb-1">
                                Qualification
                            </label>

                            <p class="fw-semibold mb-0">
                                {{ $teacher->qualification ?? 'Not Provided' }}
                            </p>

                        </div>


                        <div class="col-md-6">

                            <label class="text-muted small mb-1">
                                Experience
                            </label>

                            <p class="fw-semibold mb-0">
                                {{ $teacher->experience ?? 'Not Provided' }}
                            </p>

                        </div>


                        <div class="col-md-6">

                            <label class="text-muted small mb-1">
                                Assigned Class
                            </label>

                            <p class="fw-semibold mb-0">

                                @if($teacher->classRoom)

                                    <span class="badge bg-info-subtle text-info-emphasis border px-3 py-2">

                                        <i class="fa-solid fa-school me-1"></i>
                                        {{ $teacher->classRoom->class_name }}

                                    </span>

                                @else

                                    <span class="text-muted">
                                        Not Assigned
                                    </span>

                                @endif

                            </p>

                        </div>


                        <div class="col-md-6">

                            <label class="text-muted small mb-1">
                                Status
                            </label>

                            <p class="fw-semibold mb-0">
                                {{ $teacher->status }}
                            </p>

                        </div>

                    </div>

                </div>

            </div>


            <div class="card border-0 shadow-sm mt-4">

                <div class="card-body d-flex flex-wrap justify-content-between align-items-center gap-3">

                    <div>

                        <h6 class="fw-bold mb-1">
                            Manage Teacher
                        </h6>

                        <p class="text-muted mb-0">
                            Edit or remove this teacher record.
                        </p>

                    </div>

                    <div class="d-flex gap-2">

                        <a href="{{ route('teachers.edit', $teacher->id) }}"
                           class="btn btn-warning">

                            <i class="fa-solid fa-pen-to-square me-2"></i>
                            Edit

                        </a>

                        <form action="{{ route('teachers.destroy', $teacher->id) }}"
                              method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this teacher?')">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="btn btn-danger">

                                <i class="fa-solid fa-trash me-2"></i>
                                Delete

                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection