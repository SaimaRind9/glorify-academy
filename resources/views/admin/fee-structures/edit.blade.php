@extends('layouts.admin')

@section('title', 'Edit Fee Structure')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                Edit Fee Structure
            </h2>

            <p class="text-muted mb-0">
                Update session, class and shift wise fee amount
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

            <form action="{{ route('fee-structures.update', $feeStructure->id) }}"
                  method="POST">

                @csrf
                @method('PUT')


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
                                    {{ old('academic_session_id', $feeStructure->academic_session_id) == $session->id ? 'selected' : '' }}>

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
                                    {{ old('class_room_id', $feeStructure->class_room_id) == $class->id ? 'selected' : '' }}>

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
                                    {{ old('shift_id', $feeStructure->shift_id) == $shift->id ? 'selected' : '' }}>

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
                                    {{ old('fee_type_id', $feeStructure->fee_type_id) == $feeType->id ? 'selected' : '' }}>

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
                               value="{{ old('amount', $feeStructure->amount) }}"
                               min="0"
                               step="0.01"
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
                               value="{{ old(
                                   'effective_from',
                                   $feeStructure->effective_from
                                       ? date('Y-m-d', strtotime($feeStructure->effective_from))
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
                                {{ old('status', $feeStructure->status) === 'Active' ? 'selected' : '' }}>
                                Active
                            </option>

                            <option value="Inactive"
                                {{ old('status', $feeStructure->status) === 'Inactive' ? 'selected' : '' }}>
                                Inactive
                            </option>

                        </select>

                    </div>

                </div>


                <button type="submit"
                        class="btn btn-primary px-5">

                    <i class="fa-solid fa-save"></i>
                    Update Fee Structure

                </button>

            </form>

        </div>

    </div>

</div>

@endsection