@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold">
                Edit Shift
            </h2>

            <p class="text-muted mb-0">
                Update academy shift information
            </p>

        </div>

        <a href="{{ route('shifts.index') }}"
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

            <form action="{{ route('shifts.update',$shift->id) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Shift Name
                        </label>

                        <input type="text"
                               name="name"
                               class="form-control"
                               value="{{ old('name',$shift->name) }}"
                               placeholder="Example: Afternoon">

                    </div>


                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            Start Time
                        </label>

                        <input type="time"
                               name="start_time"
                               class="form-control"
                               value="{{ old('start_time',$shift->start_time) }}">

                    </div>


                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            End Time
                        </label>

                        <input type="time"
                               name="end_time"
                               class="form-control"
                               value="{{ old('end_time',$shift->end_time) }}">

                    </div>


                    <div class="col-md-6 mb-4">

                        <label class="form-label">
                            Status
                        </label>

                        <select name="status"
                                class="form-control">

                            <option value="Active"
                                {{ old('status',$shift->status)=='Active' ? 'selected' : '' }}>
                                Active
                            </option>

                            <option value="Inactive"
                                {{ old('status',$shift->status)=='Inactive' ? 'selected' : '' }}>
                                Inactive
                            </option>

                        </select>

                    </div>

                </div>


                <button type="submit"
                        class="btn btn-primary px-5">

                    <i class="fa-solid fa-save"></i>

                    Update Shift

                </button>

            </form>

        </div>

    </div>

</div>

@endsection