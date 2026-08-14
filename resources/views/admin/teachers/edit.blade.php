@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">

        <div>
            <h2 class="fw-bold mb-1">Edit Teacher</h2>
            <p class="text-muted mb-0">
                Update teacher information and assigned class.
            </p>
        </div>

        <a href="{{ route('teachers.index') }}"
           class="btn btn-outline-secondary">

            <i class="fa-solid fa-arrow-left me-2"></i>
            Back to Teachers

        </a>

    </div>


    @if($errors->any())

        <div class="alert alert-danger">

            <h6 class="fw-bold mb-2">
                Please fix the following errors:
            </h6>

            <ul class="mb-0">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white border-0 py-3">

            <h5 class="fw-bold mb-0">

                <i class="fa-solid fa-pen-to-square text-primary me-2"></i>
                Teacher Information

            </h5>

        </div>


        <div class="card-body p-4">

         <form action="{{ route('teachers.update', $teacher->id) }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf
    @method('PUT')


                <div class="row g-4">

                    <div class="col-md-6">

                        <label for="name"
                               class="form-label fw-semibold">

                            Full Name
                            <span class="text-danger">*</span>

                        </label>

                        <input type="text"
                               id="name"
                               name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $teacher->name) }}"
                               required>

                        @error('name')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    <div class="col-md-6">

                        <label for="teacher_id"
                               class="form-label fw-semibold">

                            Teacher ID
                            <span class="text-danger">*</span>

                        </label>

                        <input type="text"
                               id="teacher_id"
                               name="teacher_id"
                               class="form-control @error('teacher_id') is-invalid @enderror"
                               value="{{ old('teacher_id', $teacher->teacher_id) }}"
                               required>

                        @error('teacher_id')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    <div class="col-md-6">

                        <label for="email"
                               class="form-label fw-semibold">

                            Email Address

                        </label>

                        <input type="email"
                               id="email"
                               name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $teacher->email) }}"
                               placeholder="teacher@example.com">

                        @error('email')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    <div class="col-md-6">

                        <label for="phone"
                               class="form-label fw-semibold">

                            Contact Number
                            <span class="text-danger">*</span>

                        </label>

                        <input type="text"
                               id="phone"
                               name="phone"
                               class="form-control @error('phone') is-invalid @enderror"
                               value="{{ old('phone', $teacher->phone) }}"
                               required>

                        @error('phone')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    <div class="col-md-6">

                        <label for="qualification"
                               class="form-label fw-semibold">

                            Qualification

                        </label>

                        <input type="text"
                               id="qualification"
                               name="qualification"
                               class="form-control @error('qualification') is-invalid @enderror"
                               value="{{ old('qualification', $teacher->qualification) }}"
                               placeholder="Example: BS, MSc, B.Ed">

                        @error('qualification')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    <div class="col-md-6">

                        <label for="experience"
                               class="form-label fw-semibold">

                            Experience

                        </label>

                        <input type="text"
                               id="experience"
                               name="experience"
                               class="form-control @error('experience') is-invalid @enderror"
                               value="{{ old('experience', $teacher->experience) }}"
                               placeholder="Example: 3 Years">

                        @error('experience')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    <div class="col-md-6">

                        <label for="class_room_id"
                               class="form-label fw-semibold">

                            Assigned Class

                        </label>

                        <select id="class_room_id"
                                name="class_room_id"
                                class="form-select @error('class_room_id') is-invalid @enderror">

                            <option value="">
                                Not Assigned
                            </option>

                            @foreach($classes as $class)

                                <option value="{{ $class->id }}"
                                    {{ old('class_room_id', $teacher->class_room_id) == $class->id ? 'selected' : '' }}>

                                    {{ $class->class_name }}

                                </option>

                            @endforeach

                        </select>

                        @error('class_room_id')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    <div class="col-md-6">

                        <label for="status"
                               class="form-label fw-semibold">

                            Status
                            <span class="text-danger">*</span>

                        </label>

                        <select id="status"
                                name="status"
                                class="form-select @error('status') is-invalid @enderror"
                                required>

                            <option value="Active"
                                {{ old('status', $teacher->status) === 'Active' ? 'selected' : '' }}>

                                Active

                            </option>

                            <option value="Inactive"
                                {{ old('status', $teacher->status) === 'Inactive' ? 'selected' : '' }}>

                                Inactive

                            </option>

                        </select>

                        @error('status')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    <div class="col-12">

                        <label for="photo"
                               class="form-label fw-semibold">

                            Teacher Photo

                        </label>

                        <input type="file"
                               id="photo"
                               name="photo"
                               class="form-control @error('photo') is-invalid @enderror"
                               accept="image/*">

                        <small class="text-muted">
                            Leave empty to keep the current photo.
                        </small>

                        @error('photo')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    @if($teacher->photo)

                        <div class="col-12">

                            <label class="form-label fw-semibold">
                                Current Photo
                            </label>

                            <div>

                                <img src="{{ asset('storage/' . $teacher->photo) }}"
                                     alt="{{ $teacher->name }}"
                                     width="120"
                                     height="120"
                                     class="rounded-circle object-fit-cover border">

                            </div>

                        </div>

                    @endif

                </div>


                <hr class="my-4">


                <div class="d-flex justify-content-end gap-2">

                    <a href="{{ route('teachers.index') }}"
                       class="btn btn-outline-secondary px-4">

                        Cancel

                    </a>

                    <button type="submit" class="btn btn-primary px-4">
    <i class="fa-solid fa-floppy-disk me-2"></i>
    Update Teacher
</button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection