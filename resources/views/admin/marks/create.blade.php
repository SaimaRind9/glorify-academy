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
                Bulk Marks Entry
            </h2>

            <p class="page-description mb-0">
                Select exam, class and subject to load students and enter their marks.
            </p>
        </div>

        <div>
            <a href="{{ route('marks.index') }}"
               class="btn btn-outline-secondary back-btn">

                <i class="fas fa-arrow-left me-2"></i>
                Back to Marks

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
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif

    <form action="{{ route('marks.store') }}"
          method="POST"
          id="marksForm">

        @csrf

        {{-- Selection Card --}}
        <div class="selection-card mb-4">

            <div class="selection-card-header">

                <div class="header-icon">
                    <i class="fas fa-sliders"></i>
                </div>

                <div>
                    <h5 class="mb-1">
                        Select Examination Details
                    </h5>

                    <p class="mb-0">
                        Choose the exam, class and assigned subject.
                    </p>
                </div>

            </div>

            <div class="selection-card-body">

                <div class="row g-4">

                    {{-- Exam --}}
                    <div class="col-lg-4 col-md-6">

                        <label for="exam_id"
                               class="form-label">

                            Exam
                            <span class="required">*</span>

                        </label>

                        <select name="exam_id"
                                id="exam_id"
                                class="form-select @error('exam_id') is-invalid @enderror"
                                required>

                            <option value="">
                                Select Exam
                            </option>

                            @foreach($exams as $exam)

                                <option value="{{ $exam->id }}"
                                    data-class="{{ $exam->class_room_id }}"
                                    {{ old('exam_id') == $exam->id ? 'selected' : '' }}>

                                    {{ $exam->exam_name }}
                                    —
                                    {{ $exam->session }}

                                </option>

                            @endforeach

                        </select>

                        @error('exam_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    {{-- Class --}}
                    <div class="col-lg-4 col-md-6">

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
                                    {{ old('class_room_id') == $class->id ? 'selected' : '' }}>

                                    {{ $class->class_name }}

                                </option>

                            @endforeach

                        </select>

                        @error('class_room_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    {{-- Subject --}}
                    <div class="col-lg-4 col-md-6">

                        <label for="subject_id"
                               class="form-label">

                            Subject
                            <span class="required">*</span>

                        </label>

                        <select name="subject_id"
                                id="subject_id"
                                class="form-select @error('subject_id') is-invalid @enderror"
                                disabled
                                required>

                            <option value="">
                                Select Class First
                            </option>

                        </select>

                        @error('subject_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    {{-- Total Marks --}}
                    <div class="col-lg-4 col-md-6">

                        <label for="total_marks"
                               class="form-label">

                            Total Marks
                            <span class="required">*</span>

                        </label>

                        <input type="number"
                               name="total_marks"
                               id="total_marks"
                               class="form-control @error('total_marks') is-invalid @enderror"
                               value="{{ old('total_marks', 100) }}"
                               min="1"
                               step="0.01"
                               required>

                        @error('total_marks')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    {{-- Passing Marks --}}
                    <div class="col-lg-4 col-md-6">

                        <label for="passing_marks"
                               class="form-label">

                            Passing Marks
                            <span class="required">*</span>

                        </label>

                        <input type="number"
                               name="passing_marks"
                               id="passing_marks"
                               class="form-control @error('passing_marks') is-invalid @enderror"
                               value="{{ old('passing_marks', 40) }}"
                               min="0"
                               step="0.01"
                               required>

                        @error('passing_marks')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    {{-- Load Button --}}
                    <div class="col-lg-4 col-md-6 d-flex align-items-end">

                        <button type="button"
                                id="loadStudentsBtn"
                                class="btn btn-primary w-100"
                                disabled>

                            <i class="fas fa-users me-2"></i>
                            Load Students

                        </button>

                    </div>

                </div>

            </div>

        </div>

        {{-- Status Messages --}}
        <div id="messageBox"
             class="alert d-none mb-4">
        </div>

        {{-- Loading --}}
        <div id="loadingBox"
             class="loading-box d-none mb-4">

            <div class="spinner-border text-primary"
                 role="status">
            </div>

            <span>
                Loading students...
            </span>

        </div>

        {{-- Students Card --}}
        <div id="studentsCard"
             class="students-card d-none">

            <div class="students-card-header">

                <div>

                    <h5 class="mb-1">
                        Students Marks Entry
                    </h5>

                    <p class="mb-0">
                        Enter obtained marks, mark absent students and add optional remarks.
                    </p>

                </div>

                <div class="student-count-badge">

                    <i class="fas fa-users me-2"></i>

                    <span id="studentCount">
                        0 Students
                    </span>

                </div>

            </div>

            <div class="table-responsive">

                <table class="table align-middle mb-0 marks-table">

                    <thead>

                        <tr>

                            <th style="width: 60px;">
                                #
                            </th>

                            <th style="min-width: 130px;">
                                Student ID
                            </th>

                            <th style="min-width: 210px;">
                                Student Name
                            </th>

                            <th style="min-width: 150px;">
                                Obtained Marks
                            </th>

                            <th style="min-width: 110px;">
                                Absent
                            </th>

                            <th style="min-width: 180px;">
                                Result Preview
                            </th>

                            <th style="min-width: 220px;">
                                Remarks
                            </th>

                        </tr>

                    </thead>

                    <tbody id="studentsTableBody">
                    </tbody>

                </table>

            </div>

            <div class="students-card-footer">

                <div class="footer-note">

                    <i class="fas fa-circle-info me-2"></i>

                    Empty rows without marks, absent status or remarks will not be saved.

                </div>

                <div class="footer-actions">

                    <a href="{{ route('marks.index') }}"
                       class="btn btn-light border">

                        Cancel

                    </a>

                    <button type="submit"
                            id="saveMarksBtn"
                            class="btn btn-success"
                            disabled>

                        <i class="fas fa-floppy-disk me-2"></i>
                        Save All Marks

                    </button>

                </div>

            </div>

        </div>

    </form>

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

    .selection-card,
    .students-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 6px 24px rgba(15, 23, 42, 0.06);
    }

    .selection-card-header,
    .students-card-header {
        padding: 22px 24px;
        border-bottom: 1px solid #e5e7eb;
        background: #fbfcff;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        flex-wrap: wrap;
    }

    .selection-card-header {
        justify-content: flex-start;
    }

    .selection-card-header h5,
    .students-card-header h5 {
        color: #1f2937;
        font-size: 18px;
        font-weight: 700;
    }

    .selection-card-header p,
    .students-card-header p {
        color: #6b7280;
        font-size: 14px;
    }

    .header-icon {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        background: #eef2ff;
        color: #4f46e5;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .selection-card-body {
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
    .form-select {
        min-height: 46px;
        border-color: #d1d5db;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.12);
    }

    .loading-box {
        padding: 20px;
        border: 1px solid #bfdbfe;
        border-radius: 14px;
        background: #eff6ff;
        color: #1e40af;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 12px;
        font-weight: 600;
    }

    .student-count-badge {
        background: #eef2ff;
        color: #4338ca;
        border-radius: 999px;
        padding: 9px 14px;
        font-size: 13px;
        font-weight: 700;
    }

    .marks-table thead th {
        background: #f8fafc;
        color: #475569;
        border-bottom: 1px solid #e5e7eb;
        font-size: 12px;
        font-weight: 750;
        text-transform: uppercase;
        letter-spacing: 0.45px;
        padding: 15px 16px;
        white-space: nowrap;
    }

    .marks-table tbody td {
        padding: 15px 16px;
        border-color: #eef2f7;
        color: #374151;
        font-size: 14px;
    }

    .student-name {
        color: #111827;
        font-weight: 700;
    }

    .student-id-badge {
        display: inline-block;
        background: #f1f5f9;
        color: #475569;
        padding: 6px 10px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
    }

    .marks-input {
        min-width: 120px;
    }

    .remarks-input {
        min-width: 190px;
    }

    .result-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 85px;
        padding: 7px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 750;
    }

    .result-pending {
        background: #f1f5f9;
        color: #64748b;
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

    .students-card-footer {
        padding: 20px 24px;
        border-top: 1px solid #e5e7eb;
        background: #fbfcff;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 18px;
        flex-wrap: wrap;
    }

    .footer-note {
        color: #64748b;
        font-size: 13px;
    }

    .footer-actions {
        display: flex;
        gap: 10px;
    }

    .empty-state {
        padding: 45px 20px !important;
        text-align: center;
        color: #64748b;
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

        .selection-card-header,
        .selection-card-body,
        .students-card-header,
        .students-card-footer {
            padding-left: 16px;
            padding-right: 16px;
        }

        .students-card-footer {
            flex-direction: column;
            align-items: stretch;
        }

        .footer-actions {
            flex-direction: column-reverse;
        }

        .footer-actions .btn {
            width: 100%;
        }

    }

</style>

<script>

    document.addEventListener('DOMContentLoaded', function () {

        const examSelect = document.getElementById('exam_id');
        const classSelect = document.getElementById('class_room_id');
        const subjectSelect = document.getElementById('subject_id');
        const totalMarksInput = document.getElementById('total_marks');
        const passingMarksInput = document.getElementById('passing_marks');
        const loadStudentsBtn = document.getElementById('loadStudentsBtn');
        const saveMarksBtn = document.getElementById('saveMarksBtn');

        const studentsCard = document.getElementById('studentsCard');
        const studentsTableBody = document.getElementById('studentsTableBody');
        const studentCount = document.getElementById('studentCount');
        const loadingBox = document.getElementById('loadingBox');
        const messageBox = document.getElementById('messageBox');
        const marksForm = document.getElementById('marksForm');

        const oldSubjectId = @json(old('subject_id'));

        function showMessage(message, type = 'danger') {

            messageBox.className = 'alert alert-' + type + ' mb-4';
            messageBox.textContent = message;
            messageBox.classList.remove('d-none');

        }

        function hideMessage() {

            messageBox.classList.add('d-none');
            messageBox.textContent = '';

        }

        function resetStudents() {

            studentsTableBody.innerHTML = '';
            studentsCard.classList.add('d-none');
            saveMarksBtn.disabled = true;
            studentCount.textContent = '0 Students';

        }

        function updateLoadButton() {

            loadStudentsBtn.disabled = !(
                examSelect.value &&
                classSelect.value &&
                subjectSelect.value
            );

        }

        function validateExamClass() {

            const selectedExamOption =
                examSelect.options[examSelect.selectedIndex];

            const examClassId =
                selectedExamOption?.dataset?.class;

            if (
                examSelect.value &&
                classSelect.value &&
                examClassId &&
                String(examClassId) !== String(classSelect.value)
            ) {

                showMessage(
                    'Selected exam does not belong to the selected class.'
                );

                loadStudentsBtn.disabled = true;

                return false;

            }

            hideMessage();
            updateLoadButton();

            return true;

        }

        async function loadSubjects(classRoomId) {

            resetStudents();

            subjectSelect.disabled = true;
            subjectSelect.innerHTML =
                '<option value="">Loading Subjects...</option>';

            if (!classRoomId) {

                subjectSelect.innerHTML =
                    '<option value="">Select Class First</option>';

                updateLoadButton();

                return;

            }

            try {

                const url =
                    "{{ route('marks.get-subjects', ':classRoomId') }}"
                        .replace(':classRoomId', classRoomId);

                const response = await fetch(url, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const data = await response.json();

                if (!response.ok || !data.success) {
                    throw new Error('Unable to load subjects.');
                }

                subjectSelect.innerHTML =
                    '<option value="">Select Subject</option>';

                if (!data.subjects.length) {

                    subjectSelect.innerHTML =
                        '<option value="">No Assigned Subjects Found</option>';

                    subjectSelect.disabled = true;

                    showMessage(
                        'No active subjects are assigned to this class.',
                        'warning'
                    );

                    updateLoadButton();

                    return;

                }

                data.subjects.forEach(function (subject) {

                    const option = document.createElement('option');

                    option.value = subject.id;
                    option.textContent = subject.subject_name;

                    if (
                        oldSubjectId &&
                        String(oldSubjectId) === String(subject.id)
                    ) {
                        option.selected = true;
                    }

                    subjectSelect.appendChild(option);

                });

                subjectSelect.disabled = false;
                hideMessage();
                updateLoadButton();

            } catch (error) {

                subjectSelect.innerHTML =
                    '<option value="">Unable to Load Subjects</option>';

                subjectSelect.disabled = true;

                showMessage(
                    error.message || 'Unable to load subjects.'
                );

            }

        }

        function calculateResult(obtainedMarks, isAbsent) {

            if (isAbsent) {
                return {
                    text: 'Absent',
                    className: 'result-absent'
                };
            }

            if (
                obtainedMarks === '' ||
                obtainedMarks === null ||
                isNaN(obtainedMarks)
            ) {
                return {
                    text: 'Pending',
                    className: 'result-pending'
                };
            }

            const totalMarks = parseFloat(totalMarksInput.value);
            const passingMarks = parseFloat(passingMarksInput.value);
            const obtained = parseFloat(obtainedMarks);

            if (
                isNaN(totalMarks) ||
                isNaN(passingMarks) ||
                obtained > totalMarks
            ) {
                return {
                    text: 'Invalid',
                    className: 'result-fail'
                };
            }

            if (obtained >= passingMarks) {
                return {
                    text: 'Pass',
                    className: 'result-pass'
                };
            }

            return {
                text: 'Fail',
                className: 'result-fail'
            };

        }

        function updateRowPreview(row) {

            const marksInput = row.querySelector('.marks-input');
            const absentInput = row.querySelector('.absent-input');
            const resultBadge = row.querySelector('.result-badge');

            const result = calculateResult(
                marksInput.value,
                absentInput.checked
            );

            resultBadge.textContent = result.text;

            resultBadge.className =
                'result-badge ' + result.className;

            marksInput.disabled = absentInput.checked;

            if (absentInput.checked) {
                marksInput.value = '';
            }

        }

        function refreshAllPreviews() {

            document
                .querySelectorAll('#studentsTableBody tr[data-student-row]')
                .forEach(function (row) {
                    updateRowPreview(row);
                });

        }

        function createStudentRow(student, index) {

            const row = document.createElement('tr');

            row.setAttribute('data-student-row', 'true');

            const obtainedValue =
                student.obtained_marks !== null
                    ? student.obtained_marks
                    : '';

            const checked =
                student.is_absent
                    ? 'checked'
                    : '';

            const disabled =
                student.is_absent
                    ? 'disabled'
                    : '';

            row.innerHTML = `

                <td>
                    ${index + 1}

                    <input type="hidden"
                           name="marks[${index}][student_id]"
                           value="${student.id}">
                </td>

                <td>
                    <span class="student-id-badge">
                        ${student.student_id ?? '-'}
                    </span>
                </td>

                <td>
                    <span class="student-name">
                        ${student.name}
                    </span>
                </td>

                <td>
                    <input type="number"
                           name="marks[${index}][obtained_marks]"
                           class="form-control marks-input"
                           value="${obtainedValue}"
                           min="0"
                           step="0.01"
                           ${disabled}>
                </td>

                <td>
                    <div class="form-check form-switch">

                        <input type="hidden"
                               name="marks[${index}][is_absent]"
                               value="0">

                        <input type="checkbox"
                               name="marks[${index}][is_absent]"
                               value="1"
                               class="form-check-input absent-input"
                               ${checked}>

                    </div>
                </td>

                <td>
                    <span class="result-badge result-pending">
                        Pending
                    </span>
                </td>

                <td>
                    <input type="text"
                           name="marks[${index}][remarks]"
                           class="form-control remarks-input"
                           value="${student.remarks ?? ''}"
                           placeholder="Optional remarks"
                           maxlength="1000">
                </td>

            `;

            const marksInput = row.querySelector('.marks-input');
            const absentInput = row.querySelector('.absent-input');

            marksInput.addEventListener('input', function () {
                updateRowPreview(row);
            });

            absentInput.addEventListener('change', function () {
                updateRowPreview(row);
            });

            updateRowPreview(row);

            return row;

        }

        async function loadStudents() {

            hideMessage();
            resetStudents();

            if (!validateExamClass()) {
                return;
            }

            const totalMarks = parseFloat(totalMarksInput.value);
            const passingMarks = parseFloat(passingMarksInput.value);

            if (
                isNaN(totalMarks) ||
                totalMarks <= 0
            ) {

                showMessage(
                    'Total marks must be greater than zero.'
                );

                totalMarksInput.focus();

                return;

            }

            if (
                isNaN(passingMarks) ||
                passingMarks < 0 ||
                passingMarks > totalMarks
            ) {

                showMessage(
                    'Passing marks must be between 0 and total marks.'
                );

                passingMarksInput.focus();

                return;

            }

            loadingBox.classList.remove('d-none');
            loadStudentsBtn.disabled = true;

            try {

                const params = new URLSearchParams({
                    exam_id: examSelect.value,
                    class_room_id: classSelect.value,
                    subject_id: subjectSelect.value
                });

                const url =
                    "{{ route('marks.get-students') }}" +
                    '?' +
                    params.toString();

                const response = await fetch(url, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const data = await response.json();

                if (!response.ok) {

                    const firstError =
                        data.errors
                            ? Object.values(data.errors)[0][0]
                            : data.message;

                    throw new Error(
                        firstError || 'Unable to load students.'
                    );

                }

                if (!data.students.length) {

                    studentsTableBody.innerHTML = `

                        <tr>
                            <td colspan="7"
                                class="empty-state">

                                <i class="fas fa-user-slash fa-2x mb-3"></i>

                                <div>
                                    No students found in the selected class.
                                </div>

                            </td>
                        </tr>

                    `;

                    studentsCard.classList.remove('d-none');
                    studentCount.textContent = '0 Students';
                    saveMarksBtn.disabled = true;

                    return;

                }

                data.students.forEach(function (student, index) {

                    const row = createStudentRow(student, index);

                    studentsTableBody.appendChild(row);

                });

                studentsCard.classList.remove('d-none');

                studentCount.textContent =
                    data.students.length +
                    (
                        data.students.length === 1
                            ? ' Student'
                            : ' Students'
                    );

                saveMarksBtn.disabled = false;

            } catch (error) {

                showMessage(
                    error.message || 'Unable to load students.'
                );

            } finally {

                loadingBox.classList.add('d-none');
                updateLoadButton();

            }

        }

        examSelect.addEventListener('change', function () {

            resetStudents();
            validateExamClass();

        });

        classSelect.addEventListener('change', function () {

            resetStudents();
            loadSubjects(this.value);
            validateExamClass();

        });

        subjectSelect.addEventListener('change', function () {

            resetStudents();
            updateLoadButton();

        });

        totalMarksInput.addEventListener('input', refreshAllPreviews);
        passingMarksInput.addEventListener('input', refreshAllPreviews);

        loadStudentsBtn.addEventListener('click', loadStudents);

        marksForm.addEventListener('submit', function (event) {

            const totalMarks = parseFloat(totalMarksInput.value);
            const passingMarks = parseFloat(passingMarksInput.value);

            if (
                isNaN(totalMarks) ||
                totalMarks <= 0
            ) {

                event.preventDefault();

                showMessage(
                    'Total marks must be greater than zero.'
                );

                totalMarksInput.focus();

                return;

            }

            if (
                isNaN(passingMarks) ||
                passingMarks < 0 ||
                passingMarks > totalMarks
            ) {

                event.preventDefault();

                showMessage(
                    'Passing marks cannot be greater than total marks.'
                );

                passingMarksInput.focus();

                return;

            }

            let invalidMarks = false;

            document
                .querySelectorAll('.marks-input:not(:disabled)')
                .forEach(function (input) {

                    if (
                        input.value !== '' &&
                        parseFloat(input.value) > totalMarks
                    ) {

                        input.classList.add('is-invalid');
                        invalidMarks = true;

                    } else {

                        input.classList.remove('is-invalid');

                    }

                });

            if (invalidMarks) {

                event.preventDefault();

                showMessage(
                    'Obtained marks cannot be greater than total marks.'
                );

                document.querySelector('.marks-input.is-invalid')?.focus();

                return;

            }

            saveMarksBtn.disabled = true;

            saveMarksBtn.innerHTML = `
                <span class="spinner-border spinner-border-sm me-2"></span>
                Saving Marks...
            `;

        });

        if (classSelect.value) {
            loadSubjects(classSelect.value);
        }

        validateExamClass();

    });

</script>

@endsection