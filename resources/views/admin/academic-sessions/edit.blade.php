@extends('layouts.admin')

@section('title','Edit Academic Session')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold">
                Edit Academic Session
            </h2>

            <p class="text-muted">
                Update academic session details
            </p>

        </div>

        <a href="{{ route('academic-sessions.index') }}"
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

            <form action="{{ route('academic-sessions.update',$academicSession->id) }}"
                  method="POST">

                @csrf

                @method('PUT')


                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Session Name

                        </label>

                        <input
                            type="text"
                            name="session_name"
                            class="form-control"
                            value="{{ old('session_name',$academicSession->session_name) }}"
                            required>

                    </div>


                    <div class="col-md-3 mb-3">

                        <label class="form-label">

                            Start Date

                        </label>

                        <input
                            type="date"
                            name="start_date"
                            class="form-control"
                            value="{{ old('start_date',$academicSession->start_date) }}"
                            required>

                    </div>


                    <div class="col-md-3 mb-3">

                        <label class="form-label">

                            End Date

                        </label>

                        <input
                            type="date"
                            name="end_date"
                            class="form-control"
                            value="{{ old('end_date',$academicSession->end_date) }}"
                            required>

                    </div>



                    <div class="col-md-6 mb-4">

                        <label class="form-label">

                            Status

                        </label>

                        <select
                            name="status"
                            class="form-control">

                            <option value="Active"
                                {{ $academicSession->status=='Active'?'selected':'' }}>

                                Active

                            </option>

                            <option value="Inactive"
                                {{ $academicSession->status=='Inactive'?'selected':'' }}>

                                Inactive

                            </option>

                        </select>

                    </div>


                </div>


                <button class="btn btn-primary px-5">

                    <i class="fa-solid fa-save"></i>

                    Update Session

                </button>

            </form>

        </div>

    </div>

</div>

@endsection