@extends('layouts.admin')

@section('title', 'Generate Fee Challan')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                Generate Fee Challan
            </h2>

            <p class="text-muted mb-0">
                Generate monthly fee challan for a student
            </p>
        </div>

        <a href="{{ route('fee-challans.index') }}"
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


    @if(session('error'))

        <div class="alert alert-danger">
            {{ session('error') }}
        </div>

    @endif


    <div class="card shadow border-0 rounded-4">

        <div class="card-body p-4">

            <form action="{{ route('fee-challans.store') }}"
                  method="POST">

                @csrf

                <div class="row">

                    {{-- Student --}}

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Student
                        </label>

                        <select name="student_id"
                                class="form-control"
                                required>

                            <option value="">
                                Select Student
                            </option>

                            @foreach($students as $student)

                                <option value="{{ $student->id }}"
                                    {{ old('student_id') == $student->id ? 'selected' : '' }}>

                                    {{ $student->name }}

                                    @if($student->classRoom)
                                        - {{ $student->classRoom->class_name }}
                                    @endif

                                    @if($student->shift)
                                        - {{ $student->shift->name }}
                                    @endif

                                    @if($student->quran_classes === 'Yes')
                                        - Quran
                                    @endif

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Academic Session --}}

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Academic Session
                        </label>

                        <select name="academic_session_id"
                                class="form-control"
                                required>

                            <option value="">
                                Select Academic Session
                            </option>

                            @foreach($academicSessions as $session)

                                <option value="{{ $session->id }}"
                                    {{ old('academic_session_id') == $session->id ? 'selected' : '' }}>

                                    {{ $session->session_name }}

                                    @if($session->status === 'Active')
                                        (Active)
                                    @endif

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Month --}}

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Month
                        </label>

                        <select name="month"
                                class="form-control"
                                required>

                            <option value="">
                                Select Month
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
                                    {{ old('month') == $number ? 'selected' : '' }}>

                                    {{ $name }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Year --}}

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Year
                        </label>

                        <input type="number"
                               name="year"
                               class="form-control"
                               value="{{ old('year', now()->year) }}"
                               min="2020"
                               max="2100"
                               required>

                    </div>


                    {{-- Issue Date --}}

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Issue Date
                        </label>

                        <input type="date"
                               name="issue_date"
                               class="form-control"
                               value="{{ old('issue_date', now()->format('Y-m-d')) }}"
                               required>

                    </div>


                    {{-- Due Date --}}

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Due Date
                        </label>

                        <input type="date"
                               name="due_date"
                               class="form-control"
                               value="{{ old('due_date') }}"
                               required>

                        <small class="text-muted">
                            Example: 10th of the selected month.
                        </small>

                    </div>


                    {{-- Late Fine --}}

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Late Fine
                        </label>

                        <input type="number"
                               name="late_fine"
                               class="form-control"
                               value="{{ old('late_fine', 0) }}"
                               min="0"
                               step="0.01">

                    </div>


                    {{-- Admission Fee --}}

                    <div class="col-md-12 mb-4">

                        <div class="form-check">

                            <input class="form-check-input"
                                   type="checkbox"
                                   name="include_admission_fee"
                                   value="1"
                                   id="includeAdmissionFee"
                                   {{ old('include_admission_fee') ? 'checked' : '' }}>

                            <label class="form-check-label"
                                   for="includeAdmissionFee">

                                Include Admission Fee

                            </label>

                        </div>

                        <small class="text-muted">
                            Check this only for a new admission or when admission fee is still due.
                        </small>

                    </div>

                </div>


                <div class="alert alert-info">

                    <strong>Automatic Rules:</strong>

                    Monthly Fee will be added automatically.

                    Quran Fee will be added only if the student's Quran Classes
                    setting is Yes.

                    Admission Fee will be added only if you check the option above.

                </div>


                <button type="submit"
                        class="btn btn-primary px-5">

                    <i class="fa-solid fa-file-invoice-dollar"></i>
                    Generate Challan

                </button>

            </form>

        </div>

    </div>

</div>

@endsection