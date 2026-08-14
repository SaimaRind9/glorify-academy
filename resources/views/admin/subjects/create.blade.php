@extends('layouts.admin')

@section('content')

<div class="container-fluid py-4">

    {{-- Page Header --}}
    <div class="page-header mb-4">
        <div>
            <p class="page-subtitle mb-1">Academic Management</p>

            <h2 class="page-title mb-2">
                Add New Subject
            </h2>

            <p class="page-description mb-0">
                Create a subject for the academy academic system.
            </p>
        </div>

        <a href="{{ route('subjects.index') }}" class="back-btn">
            <i class="fa-solid fa-arrow-left"></i>
            Back to Subjects
        </a>
    </div>


    <div class="row justify-content-center">

        <div class="col-xl-9 col-lg-10">

            <div class="form-card">

                <div class="card-heading">

                    <div>
                        <h5>Subject Information</h5>
                        <p>Enter the basic details of the subject</p>
                    </div>

                    <div class="heading-icon">
                        <i class="fa-solid fa-book-open"></i>
                    </div>

                </div>


                {{-- Validation Errors --}}
                @if($errors->any())

                    <div class="alert alert-danger custom-alert">

                        <div class="d-flex align-items-center mb-2">
                            <i class="fa-solid fa-circle-exclamation me-2"></i>
                            <strong>Please correct the following errors:</strong>
                        </div>

                        <ul class="mb-0 ps-4">

                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach

                        </ul>

                    </div>

                @endif


                <form method="POST"
                      action="{{ route('subjects.store') }}">

                    @csrf


                    <div class="row g-4">

                        {{-- Subject Name --}}
                        <div class="col-md-7">

                            <label for="subject_name" class="form-label">
                                Subject Name
                                <span class="required-star">*</span>
                            </label>

                            <div class="input-group">

                                <span class="input-group-text">
                                    <i class="fa-solid fa-book"></i>
                                </span>

                                <input type="text"
                                       name="subject_name"
                                       id="subject_name"
                                       value="{{ old('subject_name') }}"
                                       class="form-control @error('subject_name') is-invalid @enderror"
                                       placeholder="Example: English"
                                       maxlength="100"
                                       required>

                            </div>

                            @error('subject_name')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror

                            <small class="form-help">
                                Enter the complete subject name.
                            </small>

                        </div>


                        {{-- Subject Code --}}
                        <div class="col-md-5">

                            <label for="subject_code" class="form-label">
                                Subject Code
                                <span class="required-star">*</span>
                            </label>

                            <div class="input-group">

                                <span class="input-group-text">
                                    <i class="fa-solid fa-code"></i>
                                </span>

                                <input type="text"
                                       name="subject_code"
                                       id="subject_code"
                                       value="{{ old('subject_code') }}"
                                       class="form-control text-uppercase @error('subject_code') is-invalid @enderror"
                                       placeholder="Example: ENG"
                                       maxlength="30"
                                       required>

                            </div>

                            @error('subject_code')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror

                            <small class="form-help">
                                Use a unique short code.
                            </small>

                        </div>


                        {{-- Description --}}
                        <div class="col-12">

                            <label for="description" class="form-label">
                                Description
                            </label>

                            <textarea name="description"
                                      id="description"
                                      rows="5"
                                      maxlength="1000"
                                      class="form-control @error('description') is-invalid @enderror"
                                      placeholder="Write a short description about this subject...">{{ old('description') }}</textarea>

                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            <div class="description-footer">

                                <small class="form-help">
                                    Optional field. Maximum 1000 characters.
                                </small>

                                <small id="characterCount" class="character-count">
                                    0 / 1000
                                </small>

                            </div>

                        </div>


                        {{-- Status --}}
                        <div class="col-12">

                            <label class="form-label">
                                Subject Status
                                <span class="required-star">*</span>
                            </label>

                            <div class="status-options">

                                <label class="status-option">

                                    <input type="radio"
                                           name="status"
                                           value="1"
                                           {{ old('status', '1') == '1' ? 'checked' : '' }}>

                                    <span class="status-card">

                                        <span class="status-icon active-icon">
                                            <i class="fa-solid fa-circle-check"></i>
                                        </span>

                                        <span>
                                            <strong>Active</strong>
                                            <small>
                                                Subject can be assigned to classes.
                                            </small>
                                        </span>

                                    </span>

                                </label>


                                <label class="status-option">

                                    <input type="radio"
                                           name="status"
                                           value="0"
                                           {{ old('status') == '0' ? 'checked' : '' }}>

                                    <span class="status-card">

                                        <span class="status-icon inactive-icon">
                                            <i class="fa-solid fa-circle-xmark"></i>
                                        </span>

                                        <span>
                                            <strong>Inactive</strong>
                                            <small>
                                                Subject will remain unavailable.
                                            </small>
                                        </span>

                                    </span>

                                </label>

                            </div>

                            @error('status')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>


                    {{-- Form Actions --}}
                    <div class="form-actions">

                        <a href="{{ route('subjects.index') }}"
                           class="cancel-btn">

                            <i class="fa-solid fa-xmark"></i>
                            Cancel

                        </a>

                        <button type="submit"
                                class="save-btn">

                            <i class="fa-solid fa-floppy-disk"></i>
                            Save Subject

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>


<style>

    .page-header {
        background: linear-gradient(135deg, #172554, #2563eb);
        color: white;
        border-radius: 20px;
        padding: 30px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        box-shadow: 0 15px 35px rgba(37, 99, 235, 0.18);
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: "";
        position: absolute;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.08);
        right: -70px;
        top: -110px;
    }

    .page-header > * {
        position: relative;
        z-index: 1;
    }

    .page-subtitle {
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        opacity: 0.85;
    }

    .page-title {
        font-size: 28px;
        font-weight: 750;
    }

    .page-description {
        font-size: 14px;
        opacity: 0.88;
    }

    .back-btn {
        background: white;
        color: #2563eb;
        border-radius: 12px;
        padding: 12px 18px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 700;
        white-space: nowrap;
        box-shadow: 0 8px 20px rgba(15, 23, 42, 0.14);
        transition: all 0.25s ease;
    }

    .back-btn:hover {
        color: #1d4ed8;
        transform: translateY(-3px);
    }

    .form-card {
        background: white;
        border: 1px solid #edf0f5;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.07);
    }

    .card-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 22px;
        margin-bottom: 26px;
        border-bottom: 1px solid #edf0f5;
    }

    .card-heading h5 {
        margin: 0 0 5px;
        color: #0f172a;
        font-size: 19px;
        font-weight: 700;
    }

    .card-heading p {
        margin: 0;
        color: #94a3b8;
        font-size: 13px;
    }

    .heading-icon {
        width: 46px;
        height: 46px;
        border-radius: 13px;
        background: #eff6ff;
        color: #2563eb;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 19px;
    }

    .custom-alert {
        border: none;
        border-radius: 13px;
        font-size: 13px;
        margin-bottom: 25px;
    }

    .form-label {
        color: #334155;
        font-size: 13px;
        font-weight: 650;
        margin-bottom: 8px;
    }

    .required-star {
        color: #dc2626;
    }

    .form-control,
    .input-group-text {
        min-height: 48px;
        border-color: #e2e8f0;
        font-size: 14px;
    }

    textarea.form-control {
        min-height: 130px;
        resize: vertical;
        padding: 14px;
    }

    .input-group-text {
        min-width: 48px;
        justify-content: center;
        background: #f8fafc;
        color: #64748b;
    }

    .form-control:focus {
        border-color: #60a5fa;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.10);
    }

    .form-help {
        display: block;
        margin-top: 7px;
        color: #94a3b8;
        font-size: 11px;
    }

    .description-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .character-count {
        color: #94a3b8;
        font-size: 11px;
        margin-top: 7px;
    }

    .status-options {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }

    .status-option {
        cursor: pointer;
    }

    .status-option input {
        display: none;
    }

    .status-card {
        min-height: 90px;
        border: 2px solid #e2e8f0;
        border-radius: 15px;
        padding: 17px;
        display: flex;
        align-items: center;
        gap: 14px;
        transition: all 0.25s ease;
    }

    .status-card:hover {
        border-color: #93c5fd;
        background: #f8fbff;
    }

    .status-option input:checked + .status-card {
        border-color: #2563eb;
        background: #eff6ff;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.08);
    }

    .status-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 18px;
    }

    .active-icon {
        background: #dcfce7;
        color: #15803d;
    }

    .inactive-icon {
        background: #fee2e2;
        color: #dc2626;
    }

    .status-card strong {
        display: block;
        margin-bottom: 4px;
        color: #0f172a;
        font-size: 14px;
    }

    .status-card small {
        display: block;
        color: #64748b;
        font-size: 11px;
        line-height: 1.5;
    }

    .form-actions {
        border-top: 1px solid #edf0f5;
        margin-top: 30px;
        padding-top: 24px;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 12px;
    }

    .cancel-btn,
    .save-btn {
        min-height: 45px;
        border-radius: 11px;
        padding: 11px 20px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border: none;
        text-decoration: none;
        font-size: 13px;
        font-weight: 700;
        transition: all 0.25s ease;
    }

    .cancel-btn {
        background: #f1f5f9;
        color: #64748b;
    }

    .cancel-btn:hover {
        background: #e2e8f0;
        color: #334155;
    }

    .save-btn {
        background: #2563eb;
        color: white;
        box-shadow: 0 7px 16px rgba(37, 99, 235, 0.22);
    }

    .save-btn:hover {
        background: #1d4ed8;
        transform: translateY(-2px);
    }

    @media (max-width: 768px) {

        .page-header {
            padding: 24px;
            flex-direction: column;
            align-items: flex-start;
        }

        .page-title {
            font-size: 23px;
        }

        .back-btn {
            width: 100%;
            justify-content: center;
        }

        .form-card {
            padding: 20px;
        }

        .status-options {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column-reverse;
        }

        .cancel-btn,
        .save-btn {
            width: 100%;
        }
    }

</style>


<script>

    document.addEventListener('DOMContentLoaded', function () {

        const description = document.getElementById('description');
        const characterCount = document.getElementById('characterCount');

        function updateCharacterCount() {

            const currentLength = description.value.length;

            characterCount.textContent = currentLength + ' / 1000';

        }

        description.addEventListener('input', updateCharacterCount);

        updateCharacterCount();

    });

</script>

@endsection