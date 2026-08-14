@extends('layouts.admin')

@section('title', 'Add Fee Structure')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                Add Fee Structure
            </h2>

            <p class="text-muted mb-0">
                Set session, class and shift wise fee amount
            </p>
        </div>

        <a href="{{ route('fee-structures.index') }}"
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

            <form action="{{ route('fee-structures.store') }}"
                  method="POST">

                @csrf

                <div class="row">


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


                    {{-- Class --}}

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Class
                        </label>

                        <select name="class_room_id"
                                class="form-control"
                                required>

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


                    {{-- Shift --}}

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Shift
                        </label>

                        <select name="shift_id"
                                class="form-control"
                                required>

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
                                    {{ old('fee_type_id') == $feeType->id ? 'selected' : '' }}>

                                    {{ $feeType->fee_name }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Amount --}}

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Amount (Rs.)
                        </label>

                        <input type="number"
                               name="amount"
                               class="form-control"
                               value="{{ old('amount') }}"
                               min="0"
                               step="0.01"
                               placeholder="3500"
                               required>

                    </div>


                    {{-- Effective From --}}

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Effective From
                        </label>

                        <input type="date"
                               name="effective_from"
                               class="form-control"
                               value="{{ old('effective_from') }}"
                               required>

                        <small class="text-muted">
                            Fee will apply from this date onward.
                        </small>

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
                                {{ old('status', 'Active') === 'Active' ? 'selected' : '' }}>
                                Active
                            </option>

                            <option value="Inactive"
                                {{ old('status') === 'Inactive' ? 'selected' : '' }}>
                                Inactive
                            </option>

                        </select>

                    </div>

                </div>


                <button type="submit"
                        class="btn btn-primary px-5">

                    <i class="fa-solid fa-save"></i>
                    Save Fee Structure

                </button>

            </form>

        </div>

    </div>

</div>

@endsection