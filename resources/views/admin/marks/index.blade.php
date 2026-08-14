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
                Marks Management
            </h2>

            <p class="page-description mb-0">
                Manage students' examination marks, grades and results.
            </p>

        </div>

        <a href="{{ route('marks.create') }}"
           class="btn btn-primary add-btn">

            <i class="fas fa-plus me-2"></i>
            Enter Marks

        </a>

    </div>


    {{-- Success Message --}}
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show mb-4"
             role="alert">

            <i class="fas fa-circle-check me-2"></i>

            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close">
            </button>

        </div>

    @endif


    {{-- Error Message --}}
    @if(session('error'))

        <div class="alert alert-danger alert-dismissible fade show mb-4"
             role="alert">

            <i class="fas fa-circle-exclamation me-2"></i>

            {{ session('error') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close">
            </button>

        </div>

    @endif


    {{-- Dashboard Cards --}}
    <div class="row g-4 mb-4">

        {{-- Total Entries --}}
        <div class="col-xl-3 col-md-6">

            <div class="stat-card">

                <div class="stat-icon stat-icon-primary">

                    <i class="fas fa-list-check"></i>

                </div>

                <div>

                    <p class="stat-label mb-1">
                        Total Entries
                    </p>

                    <h3 class="stat-number mb-0">
                        {{ $totalEntries }}
                    </h3>

                </div>

            </div>

        </div>


        {{-- Pass --}}
        <div class="col-xl-3 col-md-6">

            <div class="stat-card">

                <div class="stat-icon stat-icon-success">

                    <i class="fas fa-circle-check"></i>

                </div>

                <div>

                    <p class="stat-label mb-1">
                        Pass Entries
                    </p>

                    <h3 class="stat-number mb-0">
                        {{ $passStudents }}
                    </h3>

                </div>

            </div>

        </div>


        {{-- Fail --}}
        <div class="col-xl-3 col-md-6">

            <div class="stat-card">

                <div class="stat-icon stat-icon-danger">

                    <i class="fas fa-circle-xmark"></i>

                </div>

                <div>

                    <p class="stat-label mb-1">
                        Fail Entries
                    </p>

                    <h3 class="stat-number mb-0">
                        {{ $failStudents }}
                    </h3>

                </div>

            </div>

        </div>


        {{-- Absent --}}
        <div class="col-xl-3 col-md-6">

            <div class="stat-card">

                <div class="stat-icon stat-icon-warning">

                    <i class="fas fa-user-clock"></i>

                </div>

                <div>

                    <p class="stat-label mb-1">
                        Absent Entries
                    </p>

                    <h3 class="stat-number mb-0">
                        {{ $absentStudents }}
                    </h3>

                </div>

            </div>

        </div>

    </div>


    {{-- Filters Card --}}
    <div class="filter-card mb-4">

        <div class="filter-card-header">

            <div class="filter-heading">

                <div class="filter-icon">

                    <i class="fas fa-filter"></i>

                </div>

                <div>

                    <h5 class="mb-1">
                        Search and Filters
                    </h5>

                    <p class="mb-0">
                        Find marks records using student, exam, class, subject or result status.
                    </p>

                </div>

            </div>

        </div>


        <div class="filter-card-body">

            <form action="{{ route('marks.index') }}"
                  method="GET">

                <div class="row g-3">

                    {{-- Search --}}
                    <div class="col-xl-3 col-lg-4 col-md-6">

                        <label for="search"
                               class="form-label">

                            Student Search

                        </label>

                        <div class="input-group">

                            <span class="input-group-text">

                                <i class="fas fa-magnifying-glass"></i>

                            </span>

                            <input type="text"
                                   name="search"
                                   id="search"
                                   class="form-control"
                                   value="{{ request('search') }}"
                                   placeholder="Name or Student ID">

                        </div>

                    </div>


                    {{-- Exam Filter --}}
                    <div class="col-xl-2 col-lg-4 col-md-6">

                        <label for="exam_id"
                               class="form-label">

                            Exam

                        </label>

                        <select name="exam_id"
                                id="exam_id"
                                class="form-select">

                            <option value="">
                                All Exams
                            </option>

                            @foreach($exams as $exam)

                                <option value="{{ $exam->id }}"
                                    {{ request('exam_id') == $exam->id ? 'selected' : '' }}>

                                    {{ $exam->exam_name }}
                                    -
                                    {{ $exam->session }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Class Filter --}}
                    <div class="col-xl-2 col-lg-4 col-md-6">

                        <label for="class_room_id"
                               class="form-label">

                            Class

                        </label>

                        <select name="class_room_id"
                                id="class_room_id"
                                class="form-select">

                            <option value="">
                                All Classes
                            </option>

                            @foreach($classes as $class)

                                <option value="{{ $class->id }}"
                                    {{ request('class_room_id') == $class->id ? 'selected' : '' }}>

                                    {{ $class->class_name }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Subject Filter --}}
                    <div class="col-xl-2 col-lg-4 col-md-6">

                        <label for="subject_id"
                               class="form-label">

                            Subject

                        </label>

                        <select name="subject_id"
                                id="subject_id"
                                class="form-select">

                            <option value="">
                                All Subjects
                            </option>

                            @foreach($subjects as $subject)

                                <option value="{{ $subject->id }}"
                                    {{ request('subject_id') == $subject->id ? 'selected' : '' }}>

                                    {{ $subject->subject_name }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Result Filter --}}
                    <div class="col-xl-2 col-lg-4 col-md-6">

                        <label for="result_status"
                               class="form-label">

                            Result Status

                        </label>

                        <select name="result_status"
                                id="result_status"
                                class="form-select">

                            <option value="">
                                All Results
                            </option>

                            <option value="Pass"
                                {{ request('result_status') === 'Pass' ? 'selected' : '' }}>

                                Pass

                            </option>

                            <option value="Fail"
                                {{ request('result_status') === 'Fail' ? 'selected' : '' }}>

                                Fail

                            </option>

                            <option value="Absent"
                                {{ request('result_status') === 'Absent' ? 'selected' : '' }}>

                                Absent

                            </option>

                            <option value="Pending"
                                {{ request('result_status') === 'Pending' ? 'selected' : '' }}>

                                Pending

                            </option>

                        </select>

                    </div>


                    {{-- Buttons --}}
                    <div class="col-xl-1 col-lg-4 col-md-6 d-flex align-items-end">

                        <button type="submit"
                                class="btn btn-primary w-100 filter-btn"
                                title="Apply Filters">

                            <i class="fas fa-search"></i>

                        </button>

                    </div>

                </div>


                @if(
                    request()->filled('search') ||
                    request()->filled('exam_id') ||
                    request()->filled('class_room_id') ||
                    request()->filled('subject_id') ||
                    request()->filled('result_status')
                )

                    <div class="mt-3">

                        <a href="{{ route('marks.index') }}"
                           class="btn btn-light border reset-btn">

                            <i class="fas fa-rotate-left me-2"></i>
                            Reset Filters

                        </a>

                    </div>

                @endif

            </form>

        </div>

    </div>


    {{-- Marks Table --}}
    <div class="table-card">

        <div class="table-card-header">

            <div>

                <h5 class="mb-1">
                    Marks Records
                </h5>

                <p class="mb-0">
                    Showing saved marks entries and calculated results.
                </p>

            </div>

            <div class="record-count">

                <i class="fas fa-database me-2"></i>

                {{ $marks->total() }}

                {{ $marks->total() === 1 ? 'Record' : 'Records' }}

            </div>

        </div>


        <div class="table-responsive">

            <table class="table marks-table align-middle mb-0">

                <thead>

                    <tr>

                        <th>
                            #
                        </th>

                        <th>
                            Student
                        </th>

                        <th>
                            Exam
                        </th>

                        <th>
                            Class
                        </th>

                        <th>
                            Subject
                        </th>

                        <th class="text-center">
                            Marks
                        </th>

                        <th class="text-center">
                            Percentage
                        </th>

                        <th class="text-center">
                            Grade
                        </th>

                        <th class="text-center">
                            Result
                        </th>

                        <th class="text-center">
                            Record Status
                        </th>

                        <th class="text-center">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($marks as $mark)

                        <tr>

                            {{-- Number --}}
                            <td>

                                <span class="row-number">

                                    {{ $marks->firstItem() + $loop->index }}

                                </span>

                            </td>


                            {{-- Student --}}
                            <td>

                                <div class="student-info">

                                    <div class="student-avatar">

                                        {{ strtoupper(substr(optional($mark->student)->name ?? 'S', 0, 1)) }}

                                    </div>

                                    <div>

                                        <div class="student-name">

                                            {{ optional($mark->student)->name ?? 'Student Deleted' }}

                                        </div>

                                        <div class="student-id">

                                            ID:
                                            {{ optional($mark->student)->student_id ?? 'N/A' }}

                                        </div>

                                    </div>

                                </div>

                            </td>


                            {{-- Exam --}}
                            <td>

                                <div class="main-text">

                                    {{ optional($mark->exam)->exam_name ?? 'N/A' }}

                                </div>

                                <div class="sub-text">

                                    {{ optional($mark->exam)->session ?? 'No Session' }}

                                </div>

                            </td>


                            {{-- Class --}}
                            <td>

                                <span class="class-badge">

                                    {{ optional($mark->classRoom)->class_name ?? 'N/A' }}

                                </span>

                            </td>


                            {{-- Subject --}}
                            <td>

                                <div class="main-text">

                                    {{ optional($mark->subject)->subject_name ?? 'N/A' }}

                                </div>

                            </td>


                            {{-- Marks --}}
                            <td class="text-center">

                                @if($mark->is_absent)

                                    <span class="marks-absent">
                                        Absent
                                    </span>

                                @elseif($mark->obtained_marks !== null)

                                    <span class="obtained-marks">

                                        {{ number_format((float) $mark->obtained_marks, 2) }}

                                    </span>

                                    <span class="total-marks">

                                        /
                                        {{ number_format((float) $mark->total_marks, 2) }}

                                    </span>

                                @else

                                    <span class="text-muted">
                                        Not Entered
                                    </span>

                                @endif

                            </td>


                            {{-- Percentage --}}
                            <td class="text-center">

                                @if(!$mark->is_absent && $mark->obtained_marks !== null)

                                    <span class="percentage-value">

                                        {{ number_format((float) $mark->percentage, 2) }}%

                                    </span>

                                @else

                                    <span class="text-muted">
                                        —
                                    </span>

                                @endif

                            </td>


                            {{-- Grade --}}
                            <td class="text-center">

                                @if($mark->grade)

                                    <span class="grade-badge">

                                        {{ $mark->grade }}

                                    </span>

                                @else

                                    <span class="text-muted">
                                        —
                                    </span>

                                @endif

                            </td>


                            {{-- Result --}}
                            <td class="text-center">

                                @if($mark->result_status === 'Pass')

                                    <span class="result-badge result-pass">

                                        <i class="fas fa-check me-1"></i>
                                        Pass

                                    </span>

                                @elseif($mark->result_status === 'Fail')

                                    <span class="result-badge result-fail">

                                        <i class="fas fa-xmark me-1"></i>
                                        Fail

                                    </span>

                                @elseif($mark->result_status === 'Absent')

                                    <span class="result-badge result-absent">

                                        <i class="fas fa-user-clock me-1"></i>
                                        Absent

                                    </span>

                                @else

                                    <span class="result-badge result-pending">

                                        <i class="fas fa-clock me-1"></i>
                                        Pending

                                    </span>

                                @endif

                            </td>


                            {{-- Active Status --}}
                            <td class="text-center">

                                @if($mark->status)

                                    <span class="record-status record-active">

                                        Active

                                    </span>

                                @else

                                    <span class="record-status record-inactive">

                                        Inactive

                                    </span>

                                @endif

                            </td>


                            {{-- Actions --}}
                            <td class="text-center">

                                <div class="action-buttons">

                                    <a href="{{ route('marks.show', $mark->id) }}"
                                       class="action-btn action-view"
                                       title="View Details">

                                        <i class="fas fa-eye"></i>

                                    </a>

                                    <a href="{{ route('marks.edit', $mark->id) }}"
                                       class="action-btn action-edit"
                                       title="Edit Marks">

                                        <i class="fas fa-pen"></i>

                                    </a>

                                    <button type="button"
                                            class="action-btn action-delete"
                                            title="Delete Record"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteMarkModal"
                                            data-delete-url="{{ route('marks.destroy', $mark->id) }}"
                                            data-student-name="{{ optional($mark->student)->name ?? 'this student' }}">

                                        <i class="fas fa-trash"></i>

                                    </button>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="11"
                                class="empty-state">

                                <div class="empty-icon">

                                    <i class="fas fa-chart-simple"></i>

                                </div>

                                <h5>
                                    No Marks Records Found
                                </h5>

                                <p>

                                    @if(
                                        request()->filled('search') ||
                                        request()->filled('exam_id') ||
                                        request()->filled('class_room_id') ||
                                        request()->filled('subject_id') ||
                                        request()->filled('result_status')
                                    )

                                        No marks match the selected search and filters.

                                    @else

                                        Marks have not been entered yet.

                                    @endif

                                </p>

                                <a href="{{ route('marks.create') }}"
                                   class="btn btn-primary">

                                    <i class="fas fa-plus me-2"></i>
                                    Enter Student Marks

                                </a>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- Pagination --}}
        @if($marks->hasPages())

            <div class="table-card-footer">

                <div class="pagination-information">

                    Showing

                    <strong>
                        {{ $marks->firstItem() }}
                    </strong>

                    to

                    <strong>
                        {{ $marks->lastItem() }}
                    </strong>

                    of

                    <strong>
                        {{ $marks->total() }}
                    </strong>

                    records

                </div>

                <div>

                    {{ $marks->links() }}

                </div>

            </div>

        @endif

    </div>

</div>


{{-- Delete Confirmation Modal --}}
<div class="modal fade"
     id="deleteMarkModal"
     tabindex="-1"
     aria-labelledby="deleteMarkModalLabel"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content delete-modal">

            <div class="modal-body text-center">

                <div class="delete-modal-icon">

                    <i class="fas fa-trash-can"></i>

                </div>

                <h4 id="deleteMarkModalLabel">
                    Delete Marks Record?
                </h4>

                <p>

                    Are you sure you want to delete marks for

                    <strong id="deleteStudentName">
                        this student
                    </strong>?

                    This action cannot be undone.

                </p>

                <form method="POST"
                      id="deleteMarkForm">

                    @csrf
                    @method('DELETE')

                    <div class="delete-modal-actions">

                        <button type="button"
                                class="btn btn-light border"
                                data-bs-dismiss="modal">

                            Cancel

                        </button>

                        <button type="submit"
                                class="btn btn-danger">

                            <i class="fas fa-trash me-2"></i>
                            Delete Record

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

    .add-btn {
        min-height: 44px;
        padding-left: 18px;
        padding-right: 18px;
        border-radius: 10px;
        font-weight: 650;
    }

    .stat-card {
        height: 100%;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        padding: 22px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 5px 20px rgba(15, 23, 42, 0.05);
        transition: 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 28px rgba(15, 23, 42, 0.08);
    }

    .stat-icon {
        width: 54px;
        height: 54px;
        border-radius: 15px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 21px;
        flex-shrink: 0;
    }

    .stat-icon-primary {
        background: #eef2ff;
        color: #4f46e5;
    }

    .stat-icon-success {
        background: #dcfce7;
        color: #16a34a;
    }

    .stat-icon-danger {
        background: #fee2e2;
        color: #dc2626;
    }

    .stat-icon-warning {
        background: #ffedd5;
        color: #ea580c;
    }

    .stat-label {
        color: #6b7280;
        font-size: 13px;
        font-weight: 650;
    }

    .stat-number {
        color: #111827;
        font-size: 26px;
        font-weight: 750;
    }

    .filter-card,
    .table-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 6px 24px rgba(15, 23, 42, 0.06);
    }

    .filter-card-header,
    .table-card-header {
        padding: 21px 24px;
        border-bottom: 1px solid #e5e7eb;
        background: #fbfcff;
    }

    .filter-heading {
        display: flex;
        align-items: center;
        gap: 13px;
    }

    .filter-icon {
        width: 45px;
        height: 45px;
        border-radius: 12px;
        background: #eef2ff;
        color: #4f46e5;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .filter-card-header h5,
    .table-card-header h5 {
        color: #1f2937;
        font-size: 17px;
        font-weight: 700;
    }

    .filter-card-header p,
    .table-card-header p {
        color: #6b7280;
        font-size: 13px;
    }

    .filter-card-body {
        padding: 23px 24px;
    }

    .form-label {
        color: #374151;
        font-size: 13px;
        font-weight: 650;
        margin-bottom: 8px;
    }

    .form-control,
    .form-select,
    .input-group-text {
        min-height: 44px;
        border-color: #d1d5db;
    }

    .input-group-text {
        background: #f8fafc;
        color: #64748b;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.12);
    }

    .filter-btn {
        min-height: 44px;
        border-radius: 9px;
    }

    .reset-btn {
        border-radius: 9px;
        font-size: 13px;
        font-weight: 600;
    }

    .table-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
    }

    .record-count {
        background: #eef2ff;
        color: #4338ca;
        border-radius: 999px;
        padding: 8px 13px;
        font-size: 12px;
        font-weight: 700;
    }

    .marks-table {
        min-width: 1500px;
    }

    .marks-table thead th {
        padding: 15px 14px;
        background: #f8fafc;
        border-bottom: 1px solid #e5e7eb;
        color: #475569;
        font-size: 11px;
        font-weight: 750;
        text-transform: uppercase;
        letter-spacing: 0.45px;
        white-space: nowrap;
    }

    .marks-table tbody td {
        padding: 15px 14px;
        border-color: #eef2f7;
        color: #374151;
        font-size: 13px;
        vertical-align: middle;
    }

    .marks-table tbody tr {
        transition: 0.15s ease;
    }

    .marks-table tbody tr:hover {
        background: #fafbff;
    }

    .row-number {
        color: #64748b;
        font-weight: 700;
    }

    .student-info {
        display: flex;
        align-items: center;
        gap: 11px;
    }

    .student-avatar {
        width: 40px;
        height: 40px;
        border-radius: 11px;
        background: #eef2ff;
        color: #4f46e5;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        font-weight: 750;
        flex-shrink: 0;
    }

    .student-name {
        color: #111827;
        font-size: 13px;
        font-weight: 700;
        white-space: nowrap;
    }

    .student-id,
    .sub-text {
        color: #8490a2;
        font-size: 11px;
        margin-top: 3px;
        white-space: nowrap;
    }

    .main-text {
        color: #374151;
        font-size: 13px;
        font-weight: 650;
        white-space: nowrap;
    }

    .class-badge {
        display: inline-flex;
        align-items: center;
        background: #f1f5f9;
        color: #475569;
        padding: 7px 10px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
    }

    .obtained-marks {
        color: #111827;
        font-size: 14px;
        font-weight: 750;
    }

    .total-marks {
        color: #8490a2;
        font-size: 12px;
    }

    .marks-absent {
        color: #c2410c;
        font-size: 12px;
        font-weight: 700;
    }

    .percentage-value {
        color: #374151;
        font-size: 13px;
        font-weight: 700;
    }

    .grade-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        padding: 7px 9px;
        border-radius: 8px;
        background: #eef2ff;
        color: #4338ca;
        font-size: 12px;
        font-weight: 750;
    }

    .result-badge,
    .record-status {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 7px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 750;
        white-space: nowrap;
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

    .record-active {
        background: #dcfce7;
        color: #15803d;
    }

    .record-inactive {
        background: #f1f5f9;
        color: #64748b;
    }

    .action-buttons {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 7px;
    }

    .action-btn {
        width: 34px;
        height: 34px;
        border: none;
        border-radius: 9px;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        text-decoration: none;
        font-size: 12px;
        transition: 0.2s ease;
    }

    .action-view {
        background: #eff6ff;
        color: #2563eb;
    }

    .action-edit {
        background: #fef3c7;
        color: #d97706;
    }

    .action-delete {
        background: #fee2e2;
        color: #dc2626;
    }

    .action-btn:hover {
        transform: translateY(-2px);
    }

    .action-view:hover {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .action-edit:hover {
        background: #fde68a;
        color: #b45309;
    }

    .action-delete:hover {
        background: #fecaca;
        color: #b91c1c;
    }

    .empty-state {
        padding: 60px 20px !important;
        text-align: center;
    }

    .empty-icon {
        width: 70px;
        height: 70px;
        margin: 0 auto 18px;
        border-radius: 20px;
        background: #eef2ff;
        color: #4f46e5;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 27px;
    }

    .empty-state h5 {
        color: #1f2937;
        font-size: 18px;
        font-weight: 700;
    }

    .empty-state p {
        color: #6b7280;
        font-size: 14px;
        margin-bottom: 20px;
    }

    .table-card-footer {
        padding: 17px 24px;
        border-top: 1px solid #e5e7eb;
        background: #fbfcff;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
    }

    .pagination-information {
        color: #64748b;
        font-size: 12px;
    }

    .delete-modal {
        border: none;
        border-radius: 18px;
        overflow: hidden;
    }

    .delete-modal .modal-body {
        padding: 35px 30px;
    }

    .delete-modal-icon {
        width: 72px;
        height: 72px;
        margin: 0 auto 20px;
        border-radius: 50%;
        background: #fee2e2;
        color: #dc2626;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
    }

    .delete-modal h4 {
        color: #111827;
        font-size: 21px;
        font-weight: 750;
        margin-bottom: 12px;
    }

    .delete-modal p {
        color: #6b7280;
        font-size: 14px;
        line-height: 1.7;
        margin-bottom: 24px;
    }

    .delete-modal-actions {
        display: flex;
        justify-content: center;
        gap: 10px;
    }

    @media (max-width: 767px) {

        .container-fluid {
            padding-left: 12px;
            padding-right: 12px;
        }

        .page-header {
            align-items: stretch;
        }

        .page-header .add-btn {
            width: 100%;
        }

        .page-title {
            font-size: 25px;
        }

        .filter-card-header,
        .filter-card-body,
        .table-card-header,
        .table-card-footer {
            padding-left: 16px;
            padding-right: 16px;
        }

        .table-card-footer {
            align-items: flex-start;
            flex-direction: column;
        }

        .delete-modal-actions {
            flex-direction: column-reverse;
        }

        .delete-modal-actions .btn {
            width: 100%;
        }

    }

</style>


<script>

    document.addEventListener('DOMContentLoaded', function () {

        const deleteModal = document.getElementById('deleteMarkModal');
        const deleteForm = document.getElementById('deleteMarkForm');
        const deleteStudentName = document.getElementById('deleteStudentName');

        if (deleteModal) {

            deleteModal.addEventListener('show.bs.modal', function (event) {

                const button = event.relatedTarget;

                const deleteUrl =
                    button.getAttribute('data-delete-url');

                const studentName =
                    button.getAttribute('data-student-name');

                deleteForm.action = deleteUrl;

                deleteStudentName.textContent =
                    studentName || 'this student';

            });

        }

    });

</script>

@endsection