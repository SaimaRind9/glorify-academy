@extends('layouts.admin')

@section('title','Add Academic Session')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold">
                Add Academic Session
            </h2>

            <p class="text-muted mb-0">
                Create a new academic session
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

            <form action="{{ route('academic-sessions.store') }}"
                  method="POST">

                @csrf

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Session Name

                        </label>

                        <input type="text"
                               name="session_name"
                               class="form-control"
                               placeholder="2026 - 2027"
                               value="{{ old('session_name') }}">

                    </div>


                    <div class="col-md-3 mb-3">

                        <label class="form-label">

                            Start Date

                        </label>

                        <input type="date"
                               name="start_date"
                               class="form-control"
                               value="{{ old('start_date') }}">

                    </div>


                    <div class="col-md-3 mb-3">

                        <label class="form-label">

                            End Date

                        </label>

                        <input type="date"
                               name="end_date"
                               class="form-control"
                               value="{{ old('end_date') }}">

                    </div>


                    <div class="col-md-6 mb-4">

                        <label class="form-label">

                            Status

                        </label>

                        <select name="status"
                                class="form-control">

                            <option value="Inactive">

                                Inactive

                            </option>

                            <option value="Active">

                                Active

                            </option>

                        </select>

                    </div>

                </div>


                <button class="btn btn-primary px-5">

                    <i class="fa-solid fa-save"></i>

                    Save Session

                </button>

            </form>

        </div>

    </div>

</div>

@endsection