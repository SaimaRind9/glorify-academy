@extends('layouts.admin')

@section('title','Add Fee Type')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold">
                Add Fee Type
            </h2>

            <p class="text-muted">
                Create a new fee type
            </p>

        </div>

        <a href="{{ route('fee-types.index') }}"
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

            <form action="{{ route('fee-types.store') }}"
                  method="POST">

                @csrf

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Fee Name

                        </label>

                        <input
                            type="text"
                            name="fee_name"
                            class="form-control"
                            value="{{ old('fee_name') }}"
                            placeholder="Monthly Tuition Fee"
                            required>

                    </div>



                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Status

                        </label>

                        <select
                            name="status"
                            class="form-control">

                            <option value="Active">

                                Active

                            </option>

                            <option value="Inactive">

                                Inactive

                            </option>

                        </select>

                    </div>



                    <div class="col-md-12 mb-4">

                        <label class="form-label">

                            Description

                        </label>

                        <textarea
                            name="description"
                            rows="4"
                            class="form-control"
                            placeholder="Optional">{{ old('description') }}</textarea>

                    </div>

                </div>


                <button
                    type="submit"
                    class="btn btn-primary px-5">

                    <i class="fa-solid fa-save"></i>

                    Save Fee Type

                </button>

            </form>

        </div>

    </div>

</div>

@endsection