@extends('layouts.admin')

@section('content')

<div class="container-fluid py-4">

    {{-- Page Header --}}
    <div class="page-header mb-4">

        <div>
            <p class="page-subtitle mb-1">
                Marks Management
            </p>

            <h2 class="page-title mb-2">
                Edit Student Marks
            </h2>

            <p class="page-description mb-0">
                Update examination marks, attendance status and remarks.
            </p>
        </div>

        <div class="header-actions">

            <a href="{{ route('marks.show', $mark->id) }}"
               class="btn btn-outline-primary">

                <i class="fas fa-eye me-2"></i>
                View Details

            </a>

            <a href="{{ route('marks.index') }}"
               class="btn btn-outline-secondary">

                <i class="fas fa-arrow-left me-2"></i>
                Back to Marks

            </a>

        </div>

    </div>


    {{-- Success Message --}}
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show mb-4"
             role="alert">

            <i class="fas fa-circle-check me-2"></i>

            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- Validation Errors --}}
    @if($errors->any())

        <div class="alert alert-danger alert-dismissible fade show mb-4"
             role="alert">

            <div class="d-flex align-items-start">

                <i class="fas fa-circle-exclamation me-3 mt-1"></i>

                <div>

                    <strong>
                        Please correct the following errors:
                    </strong>

                    <ul class="mb-0 mt-2 ps-3">

                        @foreach($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            </div>

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    <div class="row g-4">

        {{-- Student and Exam Details --}}
        <div class="col-xl-4 col-lg-5">

            <div class="student-card">

                <div class="student-card-header">

                    <div class="student-avatar">

                        {{ strtoupper(substr(optional($mark->student)->name ?? 'S', 0, 1)) }}

                    </div>

                    <h4 class="student-name mb-1">

                        {{ optional($mark->student)->name ?? 'Student Not Found' }}

                    </h4>

                    <p class="student-id mb-0">

                        Student ID:
                        {{ optional($mark->student)->student_id ?? 'N/A' }}

                    </p>

                </div>


                <div class="student-card-body">

                    {{-- Exam --}}
                    <div class="information-row">

                        <div class="information-icon">

                            <i class="fas fa-file-lines"></i>

                        </div>

                        <div>

                            <span class="information-label">
                                Examination
                            </span>

                            <strong class="information-value">

                                {{ optional($mark->exam)->exam_name ?? 'N/A' }}

                            </strong>

                            <small class="information-subvalue">

                                {{ optional($mark->exam)->session ?? 'No Session' }}

                            </small>

                        </div>

                    </div>


                    {{-- Class --}}
                    <div class="information-row">

                        <div class="information-icon">

                            <i class="fas fa-school"></i>

                        </div>

                        <div>

                            <span class="information-label">
                                Class
                            </span>

                            <strong class="information-value">

                                {{ optional($mark->classRoom)->class_name ?? 'N/A' }}

                            </strong>

                        </div>

                    </div>


                    {{-- Subject --}}
                    <div class="information-row">

                        <div class="information-icon">

                            <i class="fas fa-book-open"></i>

                        </div>

                        <div>

                            <span class="information-label">
                                Subject
                            </span>

                            <strong class="information-value">

                                {{ optional($mark->subject)->subject_name ?? 'N/A' }}

                            </strong>

                        </div>

                    </div>


                    {{-- Current Result --}}
                    <div class="information-row">

                        <div class="information-icon">

                            <i class="fas fa-square-poll-vertical"></i>

                        </div>

                        <div>

                            <span class="information-label">
                                Current Result
                            </span>

                            <div class="mt-1">

                                @if($mark->result_status === 'Pass')

                                    <span class="status-badge result-pass">

                                        <i class="fas fa-check me-1"></i>
                                        Pass

                                    </span>

                                @elseif($mark->result_status === 'Fail')

                                    <span class="status-badge result-fail">

                                        <i class="fas fa-xmark me-1"></i>
                                        Fail

                                    </span>

                                @elseif($mark->result_status === 'Absent')

                                    <span class="status-badge result-absent">

                                        <i class="fas fa-user-clock me-1"></i>
                                        Absent

                                    </span>

                                @else

                                    <span class="status-badge result-pending">

                                        <i class="fas fa-clock me-1"></i>
                                        Pending

                                    </span>

                                @endif

                            </div>

                        </div>

                    </div>


                    {{-- Current Grade --}}
                    <div class="information-row">

                        <div class="information-icon">

                            <i class="fas fa-award"></i>

                        </div>

                        <div>

                            <span class="information-label">
                                Current Grade
                            </span>

                            <strong class="information-value">

                                {{ $mark->grade ?? 'Not Calculated' }}

                            </strong>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Edit Form --}}
        <div class="col-xl-8 col-lg-7">

            <div class="form-card">

                <div class="form-card-header">

                    <div class="form-header-icon">

                        <i class="fas fa-pen-to-square"></i>

                    </div>

                    <div>

                        <h5 class="mb-1">
                            Update Marks Information
                        </h5>

                        <p class="mb-0">
                            Grade and result status will be calculated automatically.
                        </p>

                    </div>

                </div>


                <form action="{{ route('marks.update', $mark->id) }}"
                      method="POST"
                      id="editMarksForm">

                    @csrf
                    @method('PUT')


                    {{-- Required IDs --}}
                    <input type="hidden"
                           name="exam_id"
                           value="{{ $mark->exam_id }}">

                    <input type="hidden"
                           name="class_room_id"
                           value="{{ $mark->class_room_id }}">

                    <input type="hidden"
                           name="subject_id"
                           value="{{ $mark->subject_id }}">

                    <input type="hidden"
                           name="student_id"
                           value="{{ $mark->student_id }}">


                    <div class="form-card-body">

                        <div class="row g-4">

                            {{-- Total Marks --}}
                            <div class="col-md-6">

                                <label for="total_marks"
                                       class="form-label">

                                    Total Marks
                                    <span class="required">*</span>

                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">

                                        <i class="fas fa-bullseye"></i>

                                    </span>

                                    <input type="number"
                                           name="total_marks"
                                           id="total_marks"
                                           class="form-control @error('total_marks') is-invalid @enderror"
                                           value="{{ old('total_marks', $mark->total_marks) }}"
                                           min="1"
                                           step="0.01"
                                           required>

                                    @error('total_marks')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>

                                <small class="form-help">
                                    Maximum marks for this subject.
                                </small>

                            </div>


                            {{-- Passing Marks --}}
                            <div class="col-md-6">

                                <label for="passing_marks"
                                       class="form-label">

                                    Passing Marks
                                    <span class="required">*</span>

                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">

                                        <i class="fas fa-flag-checkered"></i>

                                    </span>

                                    <input type="number"
                                           name="passing_marks"
                                           id="passing_marks"
                                           class="form-control @error('passing_marks') is-invalid @enderror"
                                           value="{{ old('passing_marks', $mark->passing_marks) }}"
                                           min="0"
                                           step="0.01"
                                           required>

                                    @error('passing_marks')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>

                                <small class="form-help">
                                    Minimum marks required to pass.
                                </small>

                            </div>


                            {{-- Obtained Marks --}}
                            <div class="col-md-6">

                                <label for="obtained_marks"
                                       class="form-label">

                                    Obtained Marks

                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">

                                        <i class="fas fa-star"></i>

                                    </span>

                                    <input type="number"
                                           name="obtained_marks"
                                           id="obtained_marks"
                                           class="form-control @error('obtained_marks') is-invalid @enderror"
                                           value="{{ old('obtained_marks', $mark->obtained_marks) }}"
                                           min="0"
                                           step="0.01"
                                           {{ old('is_absent', $mark->is_absent) ? 'disabled' : '' }}>

                                    @error('obtained_marks')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>

                                <small class="form-help">
                                    Cannot be greater than total marks.
                                </small>

                            </div>


                            {{-- Absent Status --}}
                            <div class="col-md-6">

                                <label class="form-label">
                                    Attendance Status
                                </label>

                                <div class="absent-box">

                                    <input type="hidden"
                                           name="is_absent"
                                           value="0">

                                    <div class="form-check form-switch mb-0">

                                        <input class="form-check-input"
                                               type="checkbox"
                                               name="is_absent"
                                               id="is_absent"
                                               value="1"
                                               {{ old('is_absent', $mark->is_absent) ? 'checked' : '' }}>

                                        <label class="form-check-label"
                                               for="is_absent">

                                            Mark student as absent

                                        </label>

                                    </div>

                                    <small>
                                        Obtained marks will be cleared when absent is selected.
                                    </small>

                                </div>

                            </div>


                            {{-- Result Preview --}}
                            <div class="col-12">

                                <div class="preview-section">

                                    <div class="preview-heading">

                                        <div>

                                            <h6 class="mb-1">
                                                Result Preview
                                            </h6>

                                            <p class="mb-0">
                                                Preview based on the entered marks.
                                            </p>

                                        </div>

                                        <span id="resultPreview"
                                              class="preview-badge preview-pending">

                                            Pending

                                        </span>

                                    </div>


                                    <div class="row g-3 mt-1">

                                        <div class="col-md-4">

                                            <div class="preview-box">

                                                <span>
                                                    Percentage
                                                </span>

                                                <strong id="percentagePreview">
                                                    —
                                                </strong>

                                            </div>

                                        </div>


                                        <div class="col-md-4">

                                            <div class="preview-box">

                                                <span>
                                                    Expected Grade
                                                </span>

                                                <strong id="gradePreview">
                                                    —
                                                </strong>

                                            </div>

                                        </div>


                                        <div class="col-md-4">

                                            <div class="preview-box">

                                                <span>
                                                    Attendance
                                                </span>

                                                <strong id="attendancePreview">
                                                    Present
                                                </strong>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>


                            {{-- Remarks --}}
                            <div class="col-12">

                                <label for="remarks"
                                       class="form-label">

                                    Remarks

                                </label>

                                <textarea name="remarks"
                                          id="remarks"
                                          class="form-control @error('remarks') is-invalid @enderror"
                                          rows="4"
                                          maxlength="1000"
                                          placeholder="Enter optional remarks about the student's performance...">{{ old('remarks', $mark->remarks) }}</textarea>

                                @error('remarks')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                                <div class="textarea-footer">

                                    <small class="form-help">
                                        Optional performance notes.
                                    </small>

                                    <small id="remarksCounter">
                                        0 / 1000
                                    </small>

                                </div>

                            </div>


                            {{-- Record Status --}}
                            <div class="col-12">

                                <label class="form-label">
                                    Record Status
                                </label>

                                <div class="status-selection">

                                    <label class="status-option">

                                        <input type="radio"
                                               name="status"
                                               value="1"
                                               {{ (string) old('status', $mark->status) === '1' ? 'checked' : '' }}>

                                        <span class="status-option-content">

                                            <span class="status-option-icon active-icon">

                                                <i class="fas fa-circle-check"></i>

                                            </span>

                                            <span>

                                                <strong>
                                                    Active
                                                </strong>

                                                <small>
                                                    Record will appear in active marks results.
                                                </small>

                                            </span>

                                        </span>

                                    </label>


                                    <label class="status-option">

                                        <input type="radio"
                                               name="status"
                                               value="0"
                                               {{ (string) old('status', $mark->status) === '0' ? 'checked' : '' }}>

                                        <span class="status-option-content">

                                            <span class="status-option-icon inactive-icon">

                                                <i class="fas fa-circle-minus"></i>

                                            </span>

                                            <span>

                                                <strong>
                                                    Inactive
                                                </strong>

                                                <small>
                                                    Record will remain saved but marked inactive.
                                                </small>

                                            </span>

                                        </span>

                                    </label>

                                </div>

                            </div>

                        </div>

                    </div>


                    <div class="form-card-footer">

                        <a href="{{ route('marks.index') }}"
                           class="btn btn-light border">

                            Cancel

                        </a>

                        <button type="submit"
                                id="updateMarksBtn"
                                class="btn btn-primary">

                            <i class="fas fa-floppy-disk me-2"></i>
                            Update Marks

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

    .header-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .header-actions .btn {
        min-height: 44px;
        border-radius: 10px;
        font-weight: 650;
    }

    .student-card,
    .form-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 6px 24px rgba(15, 23, 42, 0.06);
    }

    .student-card {
        height: 100%;
    }

    .student-card-header {
        padding: 32px 24px;
        text-align: center;
        background: linear-gradient(135deg, #eef2ff, #f8fafc);
        border-bottom: 1px solid #e5e7eb;
    }

    .student-avatar {
        width: 82px;
        height: 82px;
        margin: 0 auto 17px;
        border-radius: 24px;
        background: #4f46e5;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 31px;
        font-weight: 750;
        box-shadow: 0 10px 24px rgba(79, 70, 229, 0.22);
    }

    .student-name {
        color: #111827;
        font-size: 21px;
        font-weight: 750;
    }

    .student-id {
        color: #6b7280;
        font-size: 13px;
    }

    .student-card-body {
        padding: 23px;
    }

    .information-row {
        display: flex;
        align-items: center;
        gap: 13px;
        padding: 15px 0;
        border-bottom: 1px solid #eef2f7;
    }

    .information-row:last-child {
        border-bottom: none;
    }

    .information-icon {
        width: 43px;
        height: 43px;
        border-radius: 12px;
        background: #eef2ff;
        color: #4f46e5;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .information-label {
        display: block;
        color: #8490a2;
        font-size: 11px;
        font-weight: 650;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        margin-bottom: 3px;
    }

    .information-value {
        display: block;
        color: #1f2937;
        font-size: 14px;
        font-weight: 700;
    }

    .information-subvalue {
        display: block;
        color: #8490a2;
        font-size: 11px;
        margin-top: 2px;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 7px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 750;
    }

    .result-pass {
        background: #dcfce7;
        color: #15803d;
    }

    .result-fail {
        background: #fee2e2;
        color: #b91c1c;
    }

    .result-absent {
        background: #ffedd5;
        color: #c2410c;
    }

    .result-pending {
        background: #f1f5f9;
        color: #64748b;
    }

    .form-card-header {
        padding: 22px 24px;
        border-bottom: 1px solid #e5e7eb;
        background: #fbfcff;
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .form-header-icon {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        background: #eef2ff;
        color: #4f46e5;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .form-card-header h5 {
        color: #1f2937;
        font-size: 18px;
        font-weight: 700;
    }

    .form-card-header p {
        color: #6b7280;
        font-size: 13px;
    }

    .form-card-body {
        padding: 26px 24px;
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
    .input-group-text {
        min-height: 46px;
        border-color: #d1d5db;
    }

    .input-group-text {
        background: #f8fafc;
        color: #64748b;
        min-width: 46px;
        justify-content: center;
    }

    .form-control:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.12);
    }

    textarea.form-control {
        min-height: 115px;
        resize: vertical;
    }

    .form-help {
        display: block;
        color: #8490a2;
        font-size: 11px;
        margin-top: 7px;
    }

    .absent-box {
        min-height: 76px;
        padding: 15px 17px;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        background: #f8fafc;
    }

    .absent-box .form-check-label {
        color: #374151;
        font-size: 13px;
        font-weight: 700;
    }

    .absent-box small {
        display: block;
        color: #8490a2;
        font-size: 11px;
        margin-top: 7px;
    }

    .preview-section {
        padding: 20px;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        background: #f8fafc;
    }

    .preview-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .preview-heading h6 {
        color: #1f2937;
        font-size: 15px;
        font-weight: 700;
    }

    .preview-heading p {
        color: #6b7280;
        font-size: 12px;
    }

    .preview-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 82px;
        padding: 8px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 750;
    }

    .preview-pass {
        background: #dcfce7;
        color: #15803d;
    }

    .preview-fail {
        background: #fee2e2;
        color: #b91c1c;
    }

    .preview-absent {
        background: #ffedd5;
        color: #c2410c;
    }

    .preview-pending {
        background: #e2e8f0;
        color: #64748b;
    }

    .preview-invalid {
        background: #fee2e2;
        color: #b91c1c;
    }

    .preview-box {
        height: 100%;
        padding: 14px;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 11px;
    }

    .preview-box span {
        display: block;
        color: #8490a2;
        font-size: 11px;
        margin-bottom: 5px;
    }

    .preview-box strong {
        color: #1f2937;
        font-size: 15px;
        font-weight: 750;
    }

    .textarea-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
    }

    #remarksCounter {
        color: #8490a2;
        font-size: 11px;
        margin-top: 7px;
    }

    .status-selection {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 15px;
    }

    .status-option {
        cursor: pointer;
    }

    .status-option input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .status-option-content {
        height: 100%;
        padding: 17px;
        border: 1px solid #dbe1e8;
        border-radius: 13px;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: 0.2s ease;
    }

    .status-option input:checked + .status-option-content {
        border-color: #6366f1;
        background: #f5f7ff;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.08);
    }

    .status-option-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .active-icon {
        background: #dcfce7;
        color: #15803d;
    }

    .inactive-icon {
        background: #f1f5f9;
        color: #64748b;
    }

    .status-option strong {
        display: block;
        color: #1f2937;
        font-size: 13px;
        margin-bottom: 3px;
    }

    .status-option small {
        display: block;
        color: #8490a2;
        font-size: 11px;
        line-height: 1.5;
    }

    .form-card-footer {
        padding: 20px 24px;
        border-top: 1px solid #e5e7eb;
        background: #fbfcff;
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 10px;
    }

    .form-card-footer .btn {
        min-height: 44px;
        border-radius: 10px;
        font-weight: 650;
        padding-left: 18px;
        padding-right: 18px;
    }

    @media (max-width: 767px) {

        .container-fluid {
            padding-left: 12px;
            padding-right: 12px;
        }

        .page-title {
            font-size: 25px;
        }

        .page-header {
            align-items: stretch;
        }

        .header-actions {
            width: 100%;
            flex-direction: column;
        }

        .header-actions .btn {
            width: 100%;
        }

        .student-card-header,
        .student-card-body,
        .form-card-header,
        .form-card-body,
        .form-card-footer {
            padding-left: 17px;
            padding-right: 17px;
        }

        .status-selection {
            grid-template-columns: 1fr;
        }

        .form-card-footer {
            flex-direction: column-reverse;
            align-items: stretch;
        }

        .form-card-footer .btn {
            width: 100%;
        }

    }

</style>


<script>

    document.addEventListener('DOMContentLoaded', function () {

        const form = document.getElementById('editMarksForm');

        const totalMarksInput =
            document.getElementById('total_marks');

        const passingMarksInput =
            document.getElementById('passing_marks');

        const obtainedMarksInput =
            document.getElementById('obtained_marks');

        const absentInput =
            document.getElementById('is_absent');

        const resultPreview =
            document.getElementById('resultPreview');

        const percentagePreview =
            document.getElementById('percentagePreview');

        const gradePreview =
            document.getElementById('gradePreview');

        const attendancePreview =
            document.getElementById('attendancePreview');

        const remarksInput =
            document.getElementById('remarks');

        const remarksCounter =
            document.getElementById('remarksCounter');

        const updateButton =
            document.getElementById('updateMarksBtn');


        function calculateGrade(percentage) {

            if (percentage >= 90) {
                return 'A+';
            }

            if (percentage >= 80) {
                return 'A';
            }

            if (percentage >= 70) {
                return 'B';
            }

            if (percentage >= 60) {
                return 'C';
            }

            if (percentage >= 50) {
                return 'D';
            }

            if (percentage >= 40) {
                return 'E';
            }

            return 'F';

        }


        function setResultPreview(text, className) {

            resultPreview.textContent = text;

            resultPreview.className =
                'preview-badge ' + className;

        }


        function updatePreview() {

            const totalMarks =
                parseFloat(totalMarksInput.value);

            const passingMarks =
                parseFloat(passingMarksInput.value);

            const obtainedMarks =
                parseFloat(obtainedMarksInput.value);

            const isAbsent =
                absentInput.checked;


            if (isAbsent) {

                obtainedMarksInput.value = '';
                obtainedMarksInput.disabled = true;

                setResultPreview(
                    'Absent',
                    'preview-absent'
                );

                percentagePreview.textContent = '—';
                gradePreview.textContent = '—';
                attendancePreview.textContent = 'Absent';

                return;

            }


            obtainedMarksInput.disabled = false;
            attendancePreview.textContent = 'Present';


            if (
                obtainedMarksInput.value === '' ||
                isNaN(obtainedMarks)
            ) {

                setResultPreview(
                    'Pending',
                    'preview-pending'
                );

                percentagePreview.textContent = '—';
                gradePreview.textContent = '—';

                return;

            }


            if (
                isNaN(totalMarks) ||
                totalMarks <= 0 ||
                obtainedMarks < 0 ||
                obtainedMarks > totalMarks
            ) {

                setResultPreview(
                    'Invalid',
                    'preview-invalid'
                );

                percentagePreview.textContent = '—';
                gradePreview.textContent = '—';

                return;

            }


            const percentage =
                (obtainedMarks / totalMarks) * 100;

            percentagePreview.textContent =
                percentage.toFixed(2) + '%';

            gradePreview.textContent =
                calculateGrade(percentage);


            if (
                !isNaN(passingMarks) &&
                obtainedMarks >= passingMarks
            ) {

                setResultPreview(
                    'Pass',
                    'preview-pass'
                );

            } else {

                setResultPreview(
                    'Fail',
                    'preview-fail'
                );

            }

        }


        function updateRemarksCounter() {

            remarksCounter.textContent =
                remarksInput.value.length + ' / 1000';

        }


        totalMarksInput.addEventListener(
            'input',
            updatePreview
        );

        passingMarksInput.addEventListener(
            'input',
            updatePreview
        );

        obtainedMarksInput.addEventListener(
            'input',
            updatePreview
        );

        absentInput.addEventListener(
            'change',
            updatePreview
        );

        remarksInput.addEventListener(
            'input',
            updateRemarksCounter
        );


        form.addEventListener('submit', function (event) {

            const totalMarks =
                parseFloat(totalMarksInput.value);

            const passingMarks =
                parseFloat(passingMarksInput.value);

            const obtainedMarks =
                parseFloat(obtainedMarksInput.value);


            totalMarksInput.classList.remove('is-invalid');
            passingMarksInput.classList.remove('is-invalid');
            obtainedMarksInput.classList.remove('is-invalid');


            if (
                isNaN(totalMarks) ||
                totalMarks <= 0
            ) {

                event.preventDefault();

                totalMarksInput.classList.add('is-invalid');
                totalMarksInput.focus();

                alert(
                    'Total marks must be greater than zero.'
                );

                return;

            }


            if (
                isNaN(passingMarks) ||
                passingMarks < 0 ||
                passingMarks > totalMarks
            ) {

                event.preventDefault();

                passingMarksInput.classList.add('is-invalid');
                passingMarksInput.focus();

                alert(
                    'Passing marks must be between zero and total marks.'
                );

                return;

            }


            if (
                !absentInput.checked &&
                obtainedMarksInput.value !== '' &&
                (
                    isNaN(obtainedMarks) ||
                    obtainedMarks < 0 ||
                    obtainedMarks > totalMarks
                )
            ) {

                event.preventDefault();

                obtainedMarksInput.classList.add('is-invalid');
                obtainedMarksInput.focus();

                alert(
                    'Obtained marks cannot be greater than total marks.'
                );

                return;

            }


            /*
             * Disabled inputs are not submitted by the browser.
             * When the student is absent, keep obtained_marks empty
             * but enable the field immediately before submission.
             */
            if (absentInput.checked) {

                obtainedMarksInput.value = '';
                obtainedMarksInput.disabled = false;

            }


            updateButton.disabled = true;

            updateButton.innerHTML = `
                <span class="spinner-border spinner-border-sm me-2"></span>
                Updating Marks...
            `;

        });


        updatePreview();
        updateRemarksCounter();

    });

</script>

@endsection