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
                Exam Management
            </h2>

            <p class="page-description mb-0">
                Manage exams, schedules, classes, sessions and status.
            </p>
        </div>

        <div>
            <a href="{{ route('exams.create') }}"
               class="btn btn-primary add-exam-btn">

                <i class="fas fa-plus me-2"></i>
                Add New Exam

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
                    data-bs-dismiss="alert"
                    aria-label="Close">
            </button>

        </div>

    @endif

    {{-- Dashboard Cards --}}
    <div class="row g-4 mb-4">

        {{-- Total Exams --}}
        <div class="col-xl-3 col-md-6">

            <div class="stat-card">

                <div class="stat-card-content">

                    <p class="stat-label mb-2">
                        Total Exams
                    </p>

                    <h3 class="stat-value mb-1">
                        {{ $totalExams }}
                    </h3>

                    <p class="stat-description mb-0">
                        All exam records
                    </p>

                </div>

                <div class="stat-icon total-icon">
                    <i class="fas fa-file-lines"></i>
                </div>

            </div>

        </div>

        {{-- Active Exams --}}
        <div class="col-xl-3 col-md-6">

            <div class="stat-card">

                <div class="stat-card-content">

                    <p class="stat-label mb-2">
                        Active Exams
                    </p>

                    <h3 class="stat-value mb-1">
                        {{ $activeExams }}
                    </h3>

                    <p class="stat-description mb-0">
                        Currently active
                    </p>

                </div>

                <div class="stat-icon active-icon">
                    <i class="fas fa-circle-check"></i>
                </div>

            </div>

        </div>

        {{-- Inactive Exams --}}
        <div class="col-xl-3 col-md-6">

            <div class="stat-card">

                <div class="stat-card-content">

                    <p class="stat-label mb-2">
                        Inactive Exams
                    </p>

                    <h3 class="stat-value mb-1">
                        {{ $inactiveExams }}
                    </h3>

                    <p class="stat-description mb-0">
                        Disabled exams
                    </p>

                </div>

                <div class="stat-icon inactive-icon">
                    <i class="fas fa-circle-xmark"></i>
                </div>

            </div>

        </div>

        {{-- Upcoming Exams --}}
        <div class="col-xl-3 col-md-6">

            <div class="stat-card">

                <div class="stat-card-content">

                    <p class="stat-label mb-2">
                        Upcoming Exams
                    </p>

                    <h3 class="stat-value mb-1">
                        {{ $upcomingExams }}
                    </h3>

                    <p class="stat-description mb-0">
                        Starting later
                    </p>

                </div>

                <div class="stat-icon upcoming-icon">
                    <i class="fas fa-calendar-days"></i>
                </div>

            </div>

        </div>

    </div>

    {{-- Filter Card --}}
    <div class="filter-card mb-4">

        <form action="{{ route('exams.index') }}"
              method="GET">

            <div class="row g-3 align-items-end">

                {{-- Search --}}
                <div class="col-xl-3 col-lg-4 col-md-6">

                    <label for="search"
                           class="form-label">

                        Search Exam

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
                               placeholder="Enter exam name">

                    </div>

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

                {{-- Session Filter --}}
                <div class="col-xl-2 col-lg-4 col-md-6">

                    <label for="session"
                           class="form-label">

                        Session

                    </label>

                    <select name="session"
                            id="session"
                            class="form-select">

                        <option value="">
                            All Sessions
                        </option>

                        @foreach($sessions as $session)

                            <option value="{{ $session }}"
                                {{ request('session') == $session ? 'selected' : '' }}>

                                {{ $session }}

                            </option>

                        @endforeach

                    </select>

                </div>

                {{-- Status Filter --}}
                <div class="col-xl-2 col-lg-4 col-md-6">

                    <label for="status"
                           class="form-label">

                        Status

                    </label>

                    <select name="status"
                            id="status"
                            class="form-select">

                        <option value="">
                            All Statuses
                        </option>

                        <option value="1"
                            {{ request('status') === '1' ? 'selected' : '' }}>

                            Active

                        </option>

                        <option value="0"
                            {{ request('status') === '0' ? 'selected' : '' }}>

                            Inactive

                        </option>

                    </select>

                </div>

                {{-- Filter Buttons --}}
                <div class="col-xl-3 col-lg-8 col-md-12">

                    <div class="filter-actions">

                        <button type="submit"
                                class="btn btn-primary">

                            <i class="fas fa-filter me-2"></i>
                            Apply Filters

                        </button>

                        <a href="{{ route('exams.index') }}"
                           class="btn btn-light border">

                            <i class="fas fa-rotate-left me-2"></i>
                            Reset

                        </a>

                    </div>

                </div>

            </div>

        </form>

    </div>

    {{-- Exams Table --}}
    <div class="table-card">

        <div class="table-card-header">

            <div>
                <h5 class="table-card-title mb-1">
                    Exam Records
                </h5>

                <p class="table-card-description mb-0">
                    View and manage all scheduled exams.
                </p>
            </div>

            <div class="record-count">
                {{ $exams->total() }} Records
            </div>

        </div>

        <div class="table-responsive">

            <table class="table align-middle mb-0">

                <thead>

                    <tr>

                        <th>
                            #
                        </th>

                        <th>
                            Exam Information
                        </th>

                        <th>
                            Class
                        </th>

                        <th>
                            Session
                        </th>

                        <th>
                            Start Date
                        </th>

                        <th>
                            End Date
                        </th>

                        <th>
                            Status
                        </th>

                        <th class="text-end">
                            Actions
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($exams as $exam)

                        <tr>

                            {{-- Number --}}
                            <td>

                                <span class="serial-number">

                                    {{ $exams->firstItem() + $loop->index }}

                                </span>

                            </td>

                            {{-- Exam Information --}}
                            <td>

                                <div class="exam-info">

                                    <div class="exam-icon">
                                        <i class="fas fa-file-pen"></i>
                                    </div>

                                    <div>

                                        <h6 class="exam-name mb-1">

                                            {{ $exam->exam_name }}

                                        </h6>

                                        <p class="exam-id mb-0">

                                            Exam ID: #{{ str_pad($exam->id, 4, '0', STR_PAD_LEFT) }}

                                        </p>

                                    </div>

                                </div>

                            </td>

                            {{-- Class --}}
                            <td>

                                <span class="class-badge">

                                    {{ $exam->classRoom?->class_name ?? 'N/A' }}

                                </span>

                            </td>

                            {{-- Session --}}
                            <td>

                                <span class="session-text">

                                    {{ $exam->session ?? 'N/A' }}

                                </span>

                            </td>

                            {{-- Start Date --}}
                            <td>

                                <div class="date-info">

                                    <i class="fas fa-calendar-check"></i>

                                    <span>

                                        {{ $exam->start_date?->format('d M Y') ?? 'N/A' }}

                                    </span>

                                </div>

                            </td>

                            {{-- End Date --}}
                            <td>

                                <div class="date-info">

                                    <i class="fas fa-calendar-xmark"></i>

                                    <span>

                                        {{ $exam->end_date?->format('d M Y') ?? 'N/A' }}

                                    </span>

                                </div>

                            </td>

                            {{-- Status --}}
                            <td>

                                @if($exam->status == 1)

                                    <span class="status-badge status-active">

                                        <span class="status-dot"></span>
                                        Active

                                    </span>

                                @else

                                    <span class="status-badge status-inactive">

                                        <span class="status-dot"></span>
                                        Inactive

                                    </span>

                                @endif

                            </td>

                            {{-- Actions --}}
                            <td class="text-end">

                                <div class="action-buttons">

                                    {{-- Edit --}}
                                    <a href="{{ route('exams.edit', $exam->id) }}"
                                       class="action-btn edit-btn"
                                       title="Edit Exam">

                                        <i class="fas fa-pen"></i>

                                    </a>

                                    {{-- Delete --}}
                                    <button type="button"
                                            class="action-btn delete-btn"
                                            title="Delete Exam"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteExamModal"
                                            data-exam-id="{{ $exam->id }}"
                                            data-exam-name="{{ $exam->exam_name }}">

                                        <i class="fas fa-trash"></i>

                                    </button>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="8">

                                <div class="empty-state">

                                    <div class="empty-state-icon">
                                        <i class="fas fa-file-circle-xmark"></i>
                                    </div>

                                    <h5>
                                        No Exams Found
                                    </h5>

                                    <p>
                                        No exam records match your current search or filters.
                                    </p>

                                    <a href="{{ route('exams.create') }}"
                                       class="btn btn-primary">

                                        <i class="fas fa-plus me-2"></i>
                                        Create First Exam

                                    </a>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- Pagination --}}
        @if($exams->hasPages())

            <div class="table-card-footer">

                <div class="pagination-info">

                    Showing

                    <strong>
                        {{ $exams->firstItem() }}
                    </strong>

                    to

                    <strong>
                        {{ $exams->lastItem() }}
                    </strong>

                    of

                    <strong>
                        {{ $exams->total() }}
                    </strong>

                    records

                </div>

                <div>
                    {{ $exams->links() }}
                </div>

            </div>

        @endif

    </div>

</div>

{{-- Delete Confirmation Modal --}}
<div class="modal fade"
     id="deleteExamModal"
     tabindex="-1"
     aria-labelledby="deleteExamModalLabel"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content delete-modal-content">

            <div class="modal-body text-center">

                <div class="delete-modal-icon">
                    <i class="fas fa-trash-can"></i>
                </div>

                <h4 id="deleteExamModalLabel"
                    class="delete-modal-title">

                    Delete Exam?

                </h4>

                <p class="delete-modal-text">

                    Are you sure you want to delete

                    <strong id="deleteExamName">
                        this exam
                    </strong>?

                    This action cannot be undone.

                </p>

                <form id="deleteExamForm"
                      method="POST">

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
                            Delete Exam

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
        align-items: center;
        justify-content: space-between;
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

    .add-exam-btn {
        min-height: 44px;
        border-radius: 10px;
        padding-left: 18px;
        padding-right: 18px;
        font-weight: 600;
    }

    .stat-card {
        min-height: 145px;
        padding: 22px;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        box-shadow: 0 5px 20px rgba(15, 23, 42, 0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        transition: 0.25s ease;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 28px rgba(15, 23, 42, 0.08);
    }

    .stat-label {
        color: #6b7280;
        font-size: 13px;
        font-weight: 600;
    }

    .stat-value {
        color: #111827;
        font-size: 30px;
        font-weight: 750;
    }

    .stat-description {
        color: #94a3b8;
        font-size: 12px;
    }

    .stat-icon {
        width: 58px;
        height: 58px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 23px;
        flex-shrink: 0;
    }

    .total-icon {
        background: #eef2ff;
        color: #4f46e5;
    }

    .active-icon {
        background: #ecfdf5;
        color: #059669;
    }

    .inactive-icon {
        background: #fef2f2;
        color: #dc2626;
    }

    .upcoming-icon {
        background: #fff7ed;
        color: #ea580c;
    }

    .filter-card {
        padding: 22px;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        box-shadow: 0 5px 20px rgba(15, 23, 42, 0.05);
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
        min-height: 45px;
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

    .filter-actions {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .filter-actions .btn {
        min-height: 45px;
        flex: 1;
        white-space: nowrap;
    }

    .table-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(15, 23, 42, 0.05);
    }

    .table-card-header {
        padding: 20px 22px;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
        background: #fbfcff;
    }

    .table-card-title {
        color: #111827;
        font-size: 18px;
        font-weight: 700;
    }

    .table-card-description {
        color: #6b7280;
        font-size: 13px;
    }

    .record-count {
        background: #eef2ff;
        color: #4f46e5;
        padding: 7px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
    }

    .table {
        min-width: 1100px;
    }

    .table thead th {
        padding: 15px 18px;
        background: #f8fafc;
        color: #64748b;
        border-bottom: 1px solid #e5e7eb;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        white-space: nowrap;
    }

    .table tbody td {
        padding: 16px 18px;
        color: #374151;
        border-color: #eef2f7;
        font-size: 13px;
        vertical-align: middle;
    }

    .table tbody tr:hover {
        background: #fbfcff;
    }

    .serial-number {
        width: 32px;
        height: 32px;
        border-radius: 9px;
        background: #f1f5f9;
        color: #475569;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 700;
    }

    .exam-info {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 220px;
    }

    .exam-icon {
        width: 40px;
        height: 40px;
        border-radius: 11px;
        background: #eef2ff;
        color: #4f46e5;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .exam-name {
        color: #1f2937;
        font-size: 14px;
        font-weight: 700;
    }

    .exam-id {
        color: #94a3b8;
        font-size: 11px;
    }

    .class-badge {
        display: inline-flex;
        padding: 7px 11px;
        border-radius: 8px;
        background: #f1f5f9;
        color: #475569;
        font-size: 12px;
        font-weight: 650;
        white-space: nowrap;
    }

    .session-text {
        color: #475569;
        font-weight: 600;
        white-space: nowrap;
    }

    .date-info {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #475569;
        white-space: nowrap;
    }

    .date-info i {
        color: #94a3b8;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 11px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
    }

    .status-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
    }

    .status-active {
        background: #ecfdf5;
        color: #047857;
    }

    .status-active .status-dot {
        background: #10b981;
    }

    .status-inactive {
        background: #fef2f2;
        color: #b91c1c;
    }

    .status-inactive .status-dot {
        background: #ef4444;
    }

    .action-buttons {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 8px;
    }

    .action-btn {
        width: 36px;
        height: 36px;
        border-radius: 9px;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: 0.2s ease;
    }

    .edit-btn {
        background: #eef2ff;
        color: #4f46e5;
    }

    .edit-btn:hover {
        background: #4f46e5;
        color: #ffffff;
    }

    .delete-btn {
        background: #fef2f2;
        color: #dc2626;
    }

    .delete-btn:hover {
        background: #dc2626;
        color: #ffffff;
    }

    .empty-state {
        padding: 60px 20px;
        text-align: center;
    }

    .empty-state-icon {
        width: 72px;
        height: 72px;
        border-radius: 20px;
        background: #f1f5f9;
        color: #94a3b8;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 29px;
        margin: 0 auto 18px;
    }

    .empty-state h5 {
        color: #1f2937;
        font-weight: 700;
    }

    .empty-state p {
        color: #6b7280;
        max-width: 420px;
        margin: 0 auto 20px;
    }

    .table-card-footer {
        padding: 15px 20px;
        border-top: 1px solid #e5e7eb;
        background: #fbfcff;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
    }

    .pagination-info {
        color: #6b7280;
        font-size: 13px;
    }

    .delete-modal-content {
        border: none;
        border-radius: 18px;
        box-shadow: 0 20px 50px rgba(15, 23, 42, 0.18);
    }

    .delete-modal-content .modal-body {
        padding: 34px 28px;
    }

    .delete-modal-icon {
        width: 68px;
        height: 68px;
        border-radius: 20px;
        background: #fef2f2;
        color: #dc2626;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
        margin: 0 auto 18px;
    }

    .delete-modal-title {
        color: #111827;
        font-size: 22px;
        font-weight: 750;
    }

    .delete-modal-text {
        color: #6b7280;
        font-size: 14px;
        line-height: 1.7;
        margin: 12px auto 24px;
        max-width: 390px;
    }

    .delete-modal-actions {
        display: flex;
        justify-content: center;
        gap: 12px;
    }

    .delete-modal-actions .btn {
        min-width: 130px;
    }

    @media (max-width: 767px) {

        .container-fluid {
            padding-left: 12px;
            padding-right: 12px;
        }

        .page-header {
            align-items: stretch;
        }

        .page-title {
            font-size: 25px;
        }

        .page-header .btn {
            width: 100%;
        }

        .filter-actions {
            flex-direction: column;
        }

        .filter-actions .btn {
            width: 100%;
        }

        .table-card-header {
            align-items: flex-start;
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

        const deleteModal = document.getElementById('deleteExamModal');
        const deleteForm = document.getElementById('deleteExamForm');
        const deleteExamName = document.getElementById('deleteExamName');

        deleteModal.addEventListener('show.bs.modal', function (event) {

            const button = event.relatedTarget;

            const examId = button.getAttribute('data-exam-id');
            const examName = button.getAttribute('data-exam-name');

            deleteExamName.textContent = examName;

            deleteForm.action = "{{ url('exams') }}/" + examId;

        });

    });

</script>

@endsection