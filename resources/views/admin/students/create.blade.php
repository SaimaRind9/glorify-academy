@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold">
                Add New Student
            </h2>

            <p class="text-muted">
                Register new student in The Glorify Academy
            </p>
        </div>

        <a href="{{ route('students.index') }}"
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


    <div class="card shadow border-0 rounded-4">

        <div class="card-body p-4">

            <form action="{{ route('students.store') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf


                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Student Name
                        </label>

                        <input type="text"
                               name="name"
                               value="{{ old('name') }}"
                               class="form-control"
                               placeholder="Enter student name">

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Father Name
                        </label>

                        <input type="text"
                               name="father_name"
                               value="{{ old('father_name') }}"
                               class="form-control"
                               placeholder="Enter father name">

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Date of Birth
                        </label>

                        <input type="date"
                               name="dob"
                               value="{{ old('dob') }}"
                               class="form-control">

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Gender
                        </label>

                        <select name="gender"
                                class="form-control">

                            <option value="">
                                Select Gender
                            </option>

                            <option value="Male"
                                {{ old('gender') == 'Male' ? 'selected' : '' }}>
                                Male
                            </option>

                            <option value="Female"
                                {{ old('gender') == 'Female' ? 'selected' : '' }}>
                                Female
                            </option>

                        </select>

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Contact
                        </label>

                        <input type="text"
                               name="contact"
                               value="{{ old('contact') }}"
                               class="form-control"
                               placeholder="03xx xxxxxxx">

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Class
                        </label>

                        <select name="class_room_id"
                                class="form-control">

                            <option value="">
                                Select Class
                            </option>

                            @foreach($classes as $class)

                                <option value="{{ $class->id }}"
                                    {{ old('class_room_id') == $class->id ? 'selected' : '' }}>

                                    {{ $class->class_name }}

                                </option>

                            @endforeach

                        </select>

                    </div>



                    
                <div class="col-md-6 mb-3">

    <label class="form-label">
        Shift
    </label>

    <select name="shift_id"
            class="form-control">

        <option value="">
            Select Shift
        </option>

        @foreach($shifts as $shift)

            <option value="{{ $shift->id }}"
                {{ old('shift_id') == $shift->id ? 'selected' : '' }}>

                {{ $shift->name }}

            </option>

        @endforeach

    </select>

</div>



                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Quran Classes
                        </label>

                        <select name="quran_classes"
                                class="form-control">

                            <option value="No"
                                {{ old('quran_classes', 'No') == 'No' ? 'selected' : '' }}>
                                No
                            </option>

                            <option value="Yes"
                                {{ old('quran_classes') == 'Yes' ? 'selected' : '' }}>
                                Yes
                            </option>

                        </select>

                        <small class="text-muted">
                            Select Yes if the student is enrolled in Quran classes.
                        </small>

                    </div>


                    <div class="col-md-12 mb-3">

                        <label class="form-label">
                            Address
                        </label>

                        <textarea name="address"
                                  class="form-control"
                                  rows="3"
                                  placeholder="Enter complete address">{{ old('address') }}</textarea>

                    </div>


                    

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Student Photo
                        </label>

                        <input type="file"
                               name="photo"
                               class="form-control"
                               accept="image/*">

                    </div>

                </div>


                <button type="submit"
                        class="btn btn-primary px-5">

                    <i class="fa-solid fa-save"></i>
                    Save Student

                </button>

            </form>

        </div>

    </div>

</div>

@endsection