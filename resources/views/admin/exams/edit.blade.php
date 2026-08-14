@extends('layouts.admin')

@section('content')

<div class="container-fluid py-4">

    {{-- Page Header --}}
    <div class="page-header mb-4">

        <div>
            <p class="page-subtitle mb-1">
                Academic Management
            </p>

            <h2 class="page-title mb-2">
                Edit Exam
            </h2>

            <p class="page-description mb-0">
                Update the examination details, schedule and status.
            </p>
        </div>

        <div>
            <a href="{{ route('exams.index') }}"
               class="btn btn-outline-secondary back-btn">

                <i class="fas fa-arrow-left me-2"></i>
                Back to Exams

            </a>
        </div>

    </div>

    {{-- Validation Errors --}}
    @if($errors->any())

        <div class="alert alert-danger alert-dismissible fade show mb-4"
             role="alert">

            <div class="d-flex align-items-start">

                <i class="fas fa-circle-exclamation me-3 mt-1"></i>

                <div>

                    <strong>
                        Please fix the following errors:
                    </strong>

                    <ul class="mb-0 mt-2 ps-3">

                        @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            </div>

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close">
            </button>

        </div>

    @endif

    <div class="row justify-content-center">

        <div class="col-xl-9 col-lg-10">

            <div class="form-card">

                {{-- Card Header --}}
                <div class="form-card-header">

                    <div class="form-card-icon">
                        <i class="fas fa-file-pen"></i>
                    </div>

                    <div>

                        <h5 class="form-card-title mb-1">
                            Exam Information
                        </h5>

                        <p class="form-card-description mb-0">
                            Modify the selected exam and save the updated information.
                        </p>

                    </div>

                </div>

                {{-- Form --}}
                <form action="{{ route('exams.update', $exam->id) }}"
                      method="POST"
                      id="examForm">

                    @csrf
                    @method('PUT')

                    <div class="form-card-body">

                        <div class="row g-4">

                            {{-- Class --}}
                            <div class="col-md-6">

                                <label for="class_room_id"
                                       class="form-label">

                                    Class
                                    <span class="required">*</span>

                                </label>

                                <select name="class_room_id"
                                        id="class_room_id"
                                        class="form-select @error('class_room_id') is-invalid @enderror"
                                        required>

                                    <option value="">
                                        Select Class
                                    </option>

                                    @foreach($classes as $class)

                                        <option value="{{ $class->id }}"
                                            {{ old('class_room_id', $exam->class_room_id) == $class->id ? 'selected' : '' }}>

                                            {{ $class->class_name }}

                                        </option>

                                    @endforeach

                                </select>

                                @error('class_room_id')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                                <div class="form-text">
                                    Select the class for which this exam is conducted.
                                </div>

                            </div>

                            {{-- Exam Name --}}
                            <div class="col-md-6">

                                <label for="exam_name"
                                       class="form-label">

                                    Exam Name
                                    <span class="required">*</span>

                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">
                                        <i class="fas fa-file-pen"></i>
                                    </span>

                                    <input type="text"
                                           name="exam_name"
                                           id="exam_name"
                                           class="form-control @error('exam_name') is-invalid @enderror"
                                           value="{{ old('exam_name', $exam->exam_name) }}"
                                           placeholder="Example: Mid Term Exam"
                                           maxlength="255"
                                           required>

                                    @error('exam_name')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>

                                <div class="form-text">
                                    Enter a clear and recognizable exam title.
                                </div>

                            </div>

                            {{-- Academic Session --}}
                            <div class="col-md-6">

                                <label for="session"
                                       class="form-label">

                                    Academic Session
                                    <span class="required">*</span>

                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">
                                        <i class="fas fa-calendar"></i>
                                    </span>

                                    <input type="text"
                                           name="session"
                                           id="session"
                                           class="form-control @error('session') is-invalid @enderror"
                                           value="{{ old('session', $exam->session) }}"
                                           placeholder="Example: 2026-2027"
                                           maxlength="50"
                                           required>

                                    @error('session')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>

                                <div class="form-text">
                                    Use a format such as 2026-2027.
                                </div>

                            </div>

                            {{-- Status --}}
                            <div class="col-md-6">

                                <label for="status"
                                       class="form-label">

                                    Status
                                    <span class="required">*</span>

                                </label>

                                <select name="status"
                                        id="status"
                                        class="form-select @error('status') is-invalid @enderror"
                                        required>

                                    <option value="1"
                                        {{ old('status', $exam->status) == 1 ? 'selected' : '' }}>

                                        Active

                                    </option>

                                    <option value="0"
                                        {{ old('status', $exam->status) == 0 ? 'selected' : '' }}>

                                        Inactive

                                    </option>

                                </select>

                                @error('status')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                                <div class="form-text">
                                    Active exams are available for marks entry and result processing.
                                </div>

                            </div>

                        </div>

                        {{-- Exam Schedule Section --}}
                        <div class="schedule-section mt-4">

                            <div class="section-heading mb-4">

                                <div class="section-heading-icon">
                                    <i class="fas fa-calendar-days"></i>
                                </div>

                                <div>

                                    <h6 class="mb-1">
                                        Examination Schedule
                                    </h6>

                                    <p class="mb-0">
                                        Update the starting and ending dates of this examination.
                                    </p>

                                </div>

                            </div>

                            <div class="row g-4">

                                {{-- Start Date --}}
                                <div class="col-md-6">

                                    <label for="start_date"
                                           class="form-label">

                                        Start Date
                                        <span class="required">*</span>

                                    </label>

                                    <div class="input-group">

                                        <span class="input-group-text">
                                            <i class="fas fa-calendar-check"></i>
                                        </span>

                                        <input type="date"
                                               name="start_date"
                                               id="start_date"
                                               class="form-control @error('start_date') is-invalid @enderror"
                                               value="{{ old('start_date', optional($exam->start_date)->format('Y-m-d')) }}"
                                               required>

                                        @error('start_date')

                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>

                                        @enderror

                                    </div>

                                    <div class="form-text">
                                        Select the first day of the examination.
                                    </div>

                                </div>

                                {{-- End Date --}}
                                <div class="col-md-6">

                                    <label for="end_date"
                                           class="form-label">

                                        End Date
                                        <span class="required">*</span>

                                    </label>

                                    <div class="input-group">

                                        <span class="input-group-text">
                                            <i class="fas fa-calendar-xmark"></i>
                                        </span>

                                        <input type="date"
                                               name="end_date"
                                               id="end_date"
                                               class="form-control @error('end_date') is-invalid @enderror"
                                               value="{{ old('end_date', optional($exam->end_date)->format('Y-m-d')) }}"
                                               required>

                                        @error('end_date')

                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>

                                        @enderror

                                    </div>

                                    <div class="form-text">
                                        End date must be the same as or later than the start date.
                                    </div>

                                </div>

                            </div>

                            {{-- Date Warning --}}
                            <div id="dateWarning"
                                 class="date-warning mt-3 d-none">

                                <i class="fas fa-triangle-exclamation me-2"></i>

                                End date cannot be earlier than the start date.

                            </div>

                            {{-- Schedule Preview --}}
                            <div id="schedulePreview"
                                 class="schedule-preview mt-4 d-none">

                                <div class="schedule-preview-icon">
                                    <i class="fas fa-clock"></i>
                                </div>

                                <div>

                                    <h6 class="mb-1">
                                        Schedule Summary
                                    </h6>

                                    <p class="mb-0"
                                       id="schedulePreviewText">
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- Form Footer --}}
                    <div class="form-card-footer">

                        <a href="{{ route('exams.index') }}"
                           class="btn btn-light border">

                            Cancel

                        </a>

                        <button type="submit"
                                class="btn btn-primary">

                            <i class="fas fa-floppy-disk me-2"></i>
                            Update Exam

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

<style>

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
    }

    .page-subtitle {
        color: #6b7280;
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.7px;
    }

    .page-title {
        color: #111827;
        font-size: 30px;
        font-weight: 750;
    }

    .page-description {
        color: #6b7280;
        font-size: 15px;
    }

    .back-btn {
        min-height: 44px;
        border-radius: 10px;
        font-weight: 600;
    }

    .form-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 6px 24px rgba(15, 23, 42, 0.06);
    }

    .form-card-header {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 23px 25px;
        border-bottom: 1px solid #e5e7eb;
        background: #fbfcff;
    }

    .form-card-icon {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        background: #eef2ff;
        color: #4f46e5;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 21px;
        flex-shrink: 0;
    }

    .form-card-title {
        color: #1f2937;
        font-size: 18px;
        font-weight: 700;
    }

    .form-card-description {
        color: #6b7280;
        font-size: 14px;
    }

    .form-card-body {
        padding: 28px 25px;
    }

    .form-card-footer {
        padding: 20px 25px;
        border-top: 1px solid #e5e7eb;
        background: #fbfcff;
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 12px;
    }

    .form-label {
        color: #374151;
        font-size: 14px;
        font-weight: 650;
        margin-bottom: 8px;
    }

    .required {
        color: #dc2626;
    }

    .form-control,
    .form-select,
    .input-group-text {
        min-height: 46px;
        border-color: #d1d5db;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.12);
    }

    .input-group-text {
        background: #f8fafc;
        color: #64748b;
    }

    .form-text {
        color: #8490a2;
        font-size: 12px;
        margin-top: 7px;
    }

    .schedule-section {
        padding: 22px;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        background: #f8fafc;
    }

    .section-heading {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .section-heading-icon {
        width: 43px;
        height: 43px;
        border-radius: 12px;
        background: #fff7ed;
        color: #ea580c;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .section-heading h6 {
        color: #1f2937;
        font-size: 15px;
        font-weight: 700;
    }

    .section-heading p {
        color: #6b7280;
        font-size: 13px;
    }

    .date-warning {
        padding: 12px 14px;
        border: 1px solid #fed7aa;
        border-radius: 10px;
        background: #fff7ed;
        color: #c2410c;
        font-size: 13px;
        font-weight: 650;
    }

    .schedule-preview {
        display: flex;
        align-items: center;
        gap: 13px;
        padding: 16px;
        border: 1px solid #bfdbfe;
        border-radius: 12px;
        background: #eff6ff;
    }

    .schedule-preview-icon {
        width: 42px;
        height: 42px;
        border-radius: 11px;
        background: #dbeafe;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .schedule-preview h6 {
        color: #1e3a8a;
        font-size: 14px;
        font-weight: 700;
    }

    .schedule-preview p {
        color: #3b5f94;
        font-size: 13px;
    }

    @media (max-width: 767px) {

        .container-fluid {
            padding-left: 12px;
            padding-right: 12px;
        }

        .page-header {
            align-items: stretch;
        }

        .page-header .btn {
            width: 100%;
        }

        .page-title {
            font-size: 25px;
        }

        .form-card-header,
        .form-card-body,
        .form-card-footer {
            padding-left: 17px;
            padding-right: 17px;
        }

        .form-card-footer {
            flex-direction: column-reverse;
        }

        .form-card-footer .btn {
            width: 100%;
        }

        .schedule-section {
            padding: 16px;
        }

    }

</style>

<script>

    document.addEventListener('DOMContentLoaded', function () {

        const form = document.getElementById('examForm');
        const startDate = document.getElementById('start_date');
        const endDate = document.getElementById('end_date');
        const dateWarning = document.getElementById('dateWarning');
        const schedulePreview = document.getElementById('schedulePreview');
        const schedulePreviewText = document.getElementById('schedulePreviewText');

        function formatDate(dateValue) {

            if (!dateValue) {
                return '';
            }

            const date = new Date(dateValue + 'T00:00:00');

            return date.toLocaleDateString('en-GB', {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            });

        }

        function validateDates() {

            const startValue = startDate.value;
            const endValue = endDate.value;

            if (!startValue || !endValue) {

                dateWarning.classList.add('d-none');
                schedulePreview.classList.add('d-none');
                endDate.classList.remove('is-invalid');

                return true;

            }

            const start = new Date(startValue + 'T00:00:00');
            const end = new Date(endValue + 'T00:00:00');

            if (end < start) {

                dateWarning.classList.remove('d-none');
                schedulePreview.classList.add('d-none');
                endDate.classList.add('is-invalid');

                return false;

            }

            dateWarning.classList.add('d-none');
            endDate.classList.remove('is-invalid');

            const difference = end.getTime() - start.getTime();

            const totalDays = Math.floor(
                difference / (1000 * 60 * 60 * 24)
            ) + 1;

            schedulePreviewText.textContent =
                'Exam will run from ' +
                formatDate(startValue) +
                ' to ' +
                formatDate(endValue) +
                ' for ' +
                totalDays +
                (totalDays === 1 ? ' day.' : ' days.');

            schedulePreview.classList.remove('d-none');

            return true;

        }

        startDate.addEventListener('change', function () {

            endDate.min = startDate.value;
            validateDates();

        });

        endDate.addEventListener('change', validateDates);

        form.addEventListener('submit', function (event) {

            if (!validateDates()) {

                event.preventDefault();
                endDate.focus();

            }

        });

        if (startDate.value) {
            endDate.min = startDate.value;
        }

        validateDates();

    });

</script>

@endsection