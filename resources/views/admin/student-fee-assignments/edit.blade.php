@extends('layouts.admin')

@section('title', 'Edit Student Fee Assignment')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                Edit Student Fee Assignment
            </h2>

            <p class="text-muted mb-0">
                Update student-specific fee settings
            </p>
        </div>

        <a href="{{ route('student-fee-assignments.index') }}"
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

            <form action="{{ route(
                    'student-fee-assignments.update',
                    $studentFeeAssignment->id
                ) }}"
                  method="POST">

                @csrf
                @method('PUT')


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
                                    {{ old(
                                        'student_id',
                                        $studentFeeAssignment->student_id
                                    ) == $student->id ? 'selected' : '' }}>

                                    {{ $student->name }}

                                    @if($student->classRoom)
                                        - {{ $student->classRoom->class_name }}
                                    @endif

                                    @if($student->shift)
                                        - {{ $student->shift->name }}
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
                                    {{ old(
                                        'academic_session_id',
                                        $studentFeeAssignment->academic_session_id
                                    ) == $session->id ? 'selected' : '' }}>

                                    {{ $session->session_name }}

                                    @if($session->status === 'Active')
                                        (Active)
                                    @endif

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Fee Type --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Fee Type
                        </label>

                        <select name="fee_type_id"
                                class="form-control"
                                required>

                            <option value="">
                                Select Fee Type
                            </option>

                            @foreach($feeTypes as $feeType)

                                <option value="{{ $feeType->id }}"
                                    {{ old(
                                        'fee_type_id',
                                        $studentFeeAssignment->fee_type_id
                                    ) == $feeType->id ? 'selected' : '' }}>

                                    {{ $feeType->fee_name }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Custom Amount --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Custom Amount (Rs.)
                        </label>

                        <input type="number"
                               name="custom_amount"
                               class="form-control"
                               value="{{ old(
                                   'custom_amount',
                                   $studentFeeAssignment->custom_amount
                               ) }}"
                               min="0"
                               step="0.01"
                               placeholder="Leave empty to use default fee">

                        <small class="text-muted">
                            Leave blank to use the normal Fee Structure amount.
                        </small>

                    </div>


                    {{-- Effective From --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Effective From
                        </label>

                        <input type="date"
                               name="effective_from"
                               class="form-control"
                               value="{{ old(
                                   'effective_from',
                                   $studentFeeAssignment->effective_from
                                       ? date(
                                           'Y-m-d',
                                           strtotime(
                                               $studentFeeAssignment->effective_from
                                           )
                                       )
                                       : ''
                               ) }}"
                               required>

                    </div>


                    {{-- Status --}}
                    <div class="col-md-6 mb-4">

                        <label class="form-label">
                            Status
                        </label>

                        <select name="status"
                                class="form-control"
                                required>

                            <option value="Active"
                                {{ old(
                                    'status',
                                    $studentFeeAssignment->status
                                ) === 'Active' ? 'selected' : '' }}>

                                Active

                            </option>

                            <option value="Inactive"
                                {{ old(
                                    'status',
                                    $studentFeeAssignment->status
                                ) === 'Inactive' ? 'selected' : '' }}>

                                Inactive

                            </option>

                        </select>

                    </div>

                </div>


                <div class="alert alert-info">

                    <strong>Note:</strong>

                    If Custom Amount is empty, the standard Fee Structure
                    amount will be used. If you enter an amount, that custom
                    fee will apply to this student from the selected date.

                </div>


                <button type="submit"
                        class="btn btn-primary px-5">

                    <i class="fa-solid fa-save"></i>
                    Update Assignment

                </button>

            </form>

        </div>

    </div>

</div>

@endsection