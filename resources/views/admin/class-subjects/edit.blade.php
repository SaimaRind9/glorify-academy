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
                Edit Class Subject Assignment
            </h2>

            <p class="page-description mb-0">
                Update the assigned subject and assessment configuration.
            </p>
        </div>

        <div>
            <a href="{{ route('class-subjects.index') }}"
               class="btn btn-outline-secondary">

                <i class="fas fa-arrow-left me-2"></i>
                Back to Assignments

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
                            <li>{{ $error }}</li>
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

                <div class="form-card-header">

                    <div class="form-card-icon">
                        <i class="fas fa-pen-to-square"></i>
                    </div>

                    <div>
                        <h5 class="form-card-title mb-1">
                            Assignment Information
                        </h5>

                        <p class="form-card-description mb-0">
                            Update the selected class, subject and assessment settings.
                        </p>
                    </div>

                </div>

                <form action="{{ route('class-subjects.update', $classSubject->id) }}"
                      method="POST"
                      id="classSubjectForm">

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
                                            {{ old('class_room_id', $classSubject->class_room_id) == $class->id ? 'selected' : '' }}>

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
                                    Select the class receiving this subject.
                                </div>

                            </div>

                            {{-- Subject --}}
                            <div class="col-md-6">

                                <label for="subject_id"
                                       class="form-label">

                                    Subject
                                    <span class="required">*</span>

                                </label>

                                <select name="subject_id"
                                        id="subject_id"
                                        class="form-select @error('subject_id') is-invalid @enderror"
                                        required>

                                    <option value="">
                                        Select Subject
                                    </option>

                                    @foreach($subjects as $subject)

                                        <option value="{{ $subject->id }}"
                                            {{ old('subject_id', $classSubject->subject_id) == $subject->id ? 'selected' : '' }}>

                                            {{ $subject->subject_name }}

                                            @if($subject->subject_code)
                                                — {{ $subject->subject_code }}
                                            @endif

                                        </option>

                                    @endforeach

                                </select>

                                @error('subject_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <div class="form-text">
                                    Select the subject assigned to this class.
                                </div>

                            </div>

                            {{-- Assessment Type --}}
                            <div class="col-md-6">

                                <label for="subject_type"
                                       class="form-label">

                                    Assessment Type
                                    <span class="required">*</span>

                                </label>

                                <select name="subject_type"
                                        id="subject_type"
                                        class="form-select @error('subject_type') is-invalid @enderror"
                                        required>

                                    <option value="">
                                        Select Assessment Type
                                    </option>

                                    <option value="Marks"
                                        {{ old('subject_type', $classSubject->subject_type) === 'Marks' ? 'selected' : '' }}>

                                        Marks

                                    </option>

                                    <option value="Grade"
                                        {{ old('subject_type', $classSubject->subject_type) === 'Grade' ? 'selected' : '' }}>

                                        Grade

                                    </option>

                                    <option value="Activity"
                                        {{ old('subject_type', $classSubject->subject_type) === 'Activity' ? 'selected' : '' }}>

                                        Activity

                                    </option>

                                </select>

                                @error('subject_type')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <div class="form-text">
                                    Nursery can use Activity; primary classes can use Marks.
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
                                        {{ old('status', $classSubject->status) == 1 ? 'selected' : '' }}>

                                        Active

                                    </option>

                                    <option value="0"
                                        {{ old('status', $classSubject->status) == 0 ? 'selected' : '' }}>

                                        Inactive

                                    </option>

                                </select>

                                @error('status')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <div class="form-text">
                                    Inactive assignments will not be available for assessment.
                                </div>

                            </div>

                        </div>

                        {{-- Marks Section --}}
                        <div id="marksSection"
                             class="marks-section mt-4">

                            <div class="section-heading mb-3">

                                <div class="section-heading-icon">
                                    <i class="fas fa-clipboard-check"></i>
                                </div>

                                <div>
                                    <h6 class="mb-1">
                                        Marks Configuration
                                    </h6>

                                    <p class="mb-0">
                                        Enter the maximum and passing marks for this subject.
                                    </p>
                                </div>

                            </div>

                            <div class="row g-4">

                                {{-- Full Marks --}}
                                <div class="col-md-6">

                                    <label for="full_marks"
                                           class="form-label">

                                        Full Marks
                                        <span class="required">*</span>

                                    </label>

                                    <div class="input-group">

                                        <span class="input-group-text">
                                            <i class="fas fa-star"></i>
                                        </span>

                                        <input type="number"
                                               name="full_marks"
                                               id="full_marks"
                                               class="form-control @error('full_marks') is-invalid @enderror"
                                               value="{{ old('full_marks', $classSubject->full_marks) }}"
                                               min="1"
                                               max="1000"
                                               placeholder="Example: 100">

                                        @error('full_marks')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>

                                    <div class="form-text">
                                        Maximum marks a student can obtain.
                                    </div>

                                </div>

                                {{-- Pass Marks --}}
                                <div class="col-md-6">

                                    <label for="pass_marks"
                                           class="form-label">

                                        Pass Marks
                                        <span class="required">*</span>

                                    </label>

                                    <div class="input-group">

                                        <span class="input-group-text">
                                            <i class="fas fa-check"></i>
                                        </span>

                                        <input type="number"
                                               name="pass_marks"
                                               id="pass_marks"
                                               class="form-control @error('pass_marks') is-invalid @enderror"
                                               value="{{ old('pass_marks', $classSubject->pass_marks) }}"
                                               min="0"
                                               max="1000"
                                               placeholder="Example: 40">

                                        @error('pass_marks')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>

                                    <div class="form-text">
                                        Minimum marks required to pass.
                                    </div>

                                </div>

                            </div>

                            <div id="marksWarning"
                                 class="marks-warning mt-3 d-none">

                                <i class="fas fa-triangle-exclamation me-2"></i>

                                Pass marks cannot be greater than full marks.

                            </div>

                        </div>

                        {{-- Non-Marks Information --}}
                        <div id="nonMarksInformation"
                             class="assessment-information mt-4 d-none">

                            <div class="assessment-information-icon">
                                <i class="fas fa-circle-info"></i>
                            </div>

                            <div>
                                <h6 id="assessmentInformationTitle"
                                    class="mb-1">

                                    Assessment Information

                                </h6>

                                <p id="assessmentInformationText"
                                   class="mb-0">

                                    Marks are not required for this assessment type.

                                </p>
                            </div>

                        </div>

                    </div>

                    {{-- Form Footer --}}
                    <div class="form-card-footer">

                        <a href="{{ route('class-subjects.index') }}"
                           class="btn btn-light border">

                            Cancel

                        </a>

                        <button type="submit"
                                class="btn btn-primary">

                            <i class="fas fa-floppy-disk me-2"></i>
                            Update Assignment

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
        color: #6c757d;
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.7px;
    }

    .page-title {
        color: #1f2937;
        font-size: 30px;
        font-weight: 700;
    }

    .page-description {
        color: #6b7280;
        font-size: 15px;
    }

    .form-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 5px 22px rgba(15, 23, 42, 0.06);
    }

    .form-card-header {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 22px 25px;
        border-bottom: 1px solid #e5e7eb;
        background: #fbfcff;
    }

    .form-card-icon {
        width: 48px;
        height: 48px;
        border-radius: 13px;
        background: #eef2ff;
        color: #4f46e5;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
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
        font-weight: 600;
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

    .marks-section {
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
        width: 42px;
        height: 42px;
        border-radius: 11px;
        background: #fef3c7;
        color: #92400e;
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

    .marks-warning {
        background: #fff7ed;
        color: #c2410c;
        border: 1px solid #fed7aa;
        border-radius: 10px;
        padding: 12px 14px;
        font-size: 13px;
        font-weight: 600;
    }

    .assessment-information {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 18px;
        border-radius: 13px;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
    }

    .assessment-information-icon {
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

    .assessment-information h6 {
        color: #1e3a8a;
        font-size: 14px;
        font-weight: 700;
    }

    .assessment-information p {
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

        .marks-section {
            padding: 16px;
        }

    }

</style>

<script>

    document.addEventListener('DOMContentLoaded', function () {

        const subjectType = document.getElementById('subject_type');
        const marksSection = document.getElementById('marksSection');
        const nonMarksInformation = document.getElementById('nonMarksInformation');

        const informationTitle = document.getElementById(
            'assessmentInformationTitle'
        );

        const informationText = document.getElementById(
            'assessmentInformationText'
        );

        const fullMarks = document.getElementById('full_marks');
        const passMarks = document.getElementById('pass_marks');
        const marksWarning = document.getElementById('marksWarning');
        const form = document.getElementById('classSubjectForm');

        function updateAssessmentFields() {

            const selectedType = subjectType.value;

            if (selectedType === 'Marks') {

                marksSection.classList.remove('d-none');
                nonMarksInformation.classList.add('d-none');

                fullMarks.required = true;
                passMarks.required = true;

            } else {

                marksSection.classList.add('d-none');

                fullMarks.required = false;
                passMarks.required = false;

                marksWarning.classList.add('d-none');

                if (selectedType === 'Grade') {

                    nonMarksInformation.classList.remove('d-none');

                    informationTitle.textContent =
                        'Grade-Based Assessment';

                    informationText.textContent =
                        'Students will be assessed using grades instead of numerical marks.';

                } else if (selectedType === 'Activity') {

                    nonMarksInformation.classList.remove('d-none');

                    informationTitle.textContent =
                        'Activity-Based Assessment';

                    informationText.textContent =
                        'Students will be assessed through classroom activities and performance levels.';

                } else {

                    nonMarksInformation.classList.add('d-none');

                }

            }

        }

        function validateMarks() {

            const fullMarksValue = parseFloat(fullMarks.value);
            const passMarksValue = parseFloat(passMarks.value);

            if (
                subjectType.value === 'Marks' &&
                !isNaN(fullMarksValue) &&
                !isNaN(passMarksValue) &&
                passMarksValue > fullMarksValue
            ) {

                marksWarning.classList.remove('d-none');
                passMarks.classList.add('is-invalid');

                return false;

            }

            marksWarning.classList.add('d-none');
            passMarks.classList.remove('is-invalid');

            return true;

        }

        subjectType.addEventListener('change', updateAssessmentFields);
        fullMarks.addEventListener('input', validateMarks);
        passMarks.addEventListener('input', validateMarks);

        form.addEventListener('submit', function (event) {

            if (!validateMarks()) {

                event.preventDefault();
                passMarks.focus();

            }

        });

        updateAssessmentFields();
        validateMarks();

    });

</script>

@endsection