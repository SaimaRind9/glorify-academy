@extends('layouts.admin')

@section('content')

<div class="container-fluid py-4">

    {{-- Page Header --}}
    <div class="page-header mb-4">
        <div>
            <p class="page-subtitle mb-1">Academic Management</p>

            <h2 class="page-title mb-2">
                Class Subject Assignments
            </h2>

            <p class="page-description mb-0">
                Assign subjects to classes and manage assessment settings.
            </p>
        </div>

        <div class="page-header-action">
            <a href="{{ route('class-subjects.create') }}"
               class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>
                Assign Subject
            </a>
        </div>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4"
             role="alert">
            <i class="fas fa-check-circle me-2"></i>
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
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close">
            </button>
        </div>
    @endif

    {{-- Summary Cards --}}
    <div class="row g-4 mb-4">

        <div class="col-xl-3 col-md-6">
            <div class="summary-card">
                <div class="summary-card-icon bg-primary-subtle text-primary">
                    <i class="fas fa-book-open"></i>
                </div>

                <div>
                    <p class="summary-card-label mb-1">
                        Total Assignments
                    </p>

                    <h3 class="summary-card-value mb-0">
                        {{ $classSubjects->total() }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="summary-card">
                <div class="summary-card-icon bg-success-subtle text-success">
                    <i class="fas fa-check-circle"></i>
                </div>

                <div>
                    <p class="summary-card-label mb-1">
                        Active
                    </p>

                    <h3 class="summary-card-value mb-0">
                        {{ $classSubjects->getCollection()->where('status', 1)->count() }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="summary-card">
                <div class="summary-card-icon bg-warning-subtle text-warning">
                    <i class="fas fa-pen-to-square"></i>
                </div>

                <div>
                    <p class="summary-card-label mb-1">
                        Marks Based
                    </p>

                    <h3 class="summary-card-value mb-0">
                        {{ $classSubjects->getCollection()->where('subject_type', 'Marks')->count() }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="summary-card">
                <div class="summary-card-icon bg-info-subtle text-info">
                    <i class="fas fa-puzzle-piece"></i>
                </div>

                <div>
                    <p class="summary-card-label mb-1">
                        Activities
                    </p>

                    <h3 class="summary-card-value mb-0">
                        {{ $classSubjects->getCollection()->where('subject_type', 'Activity')->count() }}
                    </h3>
                </div>
            </div>
        </div>

    </div>

    {{-- Filter Section --}}
    <div class="filter-card mb-4">

        <form method="GET"
              action="{{ route('class-subjects.index') }}">

            <div class="row g-3 align-items-end">

                <div class="col-xl-4 col-lg-4 col-md-6">
                    <label for="search"
                           class="form-label">
                        Search
                    </label>

                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>

                        <input type="text"
                               id="search"
                               name="search"
                               class="form-control"
                               value="{{ request('search') }}"
                               placeholder="Search class, subject or code">
                    </div>
                </div>

                <div class="col-xl-2 col-lg-2 col-md-6">
                    <label for="class_room_id"
                           class="form-label">
                        Class
                    </label>

                    <select id="class_room_id"
                            name="class_room_id"
                            class="form-select">

                        <option value="">
                            All Classes
                        </option>

                        @foreach($classes as $class)
                            <option value="{{ $class->id }}"
                                {{ request('class_room_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->name }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="col-xl-2 col-lg-2 col-md-6">
                    <label for="subject_type"
                           class="form-label">
                        Subject Type
                    </label>

                    <select id="subject_type"
                            name="subject_type"
                            class="form-select">

                        <option value="">
                            All Types
                        </option>

                        <option value="Marks"
                            {{ request('subject_type') === 'Marks' ? 'selected' : '' }}>
                            Marks
                        </option>

                        <option value="Grade"
                            {{ request('subject_type') === 'Grade' ? 'selected' : '' }}>
                            Grade
                        </option>

                        <option value="Activity"
                            {{ request('subject_type') === 'Activity' ? 'selected' : '' }}>
                            Activity
                        </option>

                    </select>
                </div>

                <div class="col-xl-2 col-lg-2 col-md-6">
                    <label for="status"
                           class="form-label">
                        Status
                    </label>

                    <select id="status"
                            name="status"
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

                <div class="col-xl-2 col-lg-2 col-md-12">
                    <div class="d-flex gap-2">

                        <button type="submit"
                                class="btn btn-primary flex-fill">
                            <i class="fas fa-filter me-1"></i>
                            Filter
                        </button>

                        <a href="{{ route('class-subjects.index') }}"
                           class="btn btn-outline-secondary"
                           title="Reset Filters">
                            <i class="fas fa-rotate-left"></i>
                        </a>

                    </div>
                </div>

            </div>

        </form>

    </div>

    {{-- Assignment Table --}}
    <div class="content-card">

        <div class="content-card-header">
            <div>
                <h5 class="content-card-title mb-1">
                    Assigned Subjects
                </h5>

                <p class="content-card-description mb-0">
                    Showing {{ $classSubjects->firstItem() ?? 0 }}
                    to {{ $classSubjects->lastItem() ?? 0 }}
                    of {{ $classSubjects->total() }} assignments
                </p>
            </div>
        </div>

        <div class="table-responsive">

            <table class="table align-middle mb-0">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Class</th>
                        <th>Subject</th>
                        <th>Code</th>
                        <th>Type</th>
                        <th>Full Marks</th>
                        <th>Pass Marks</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($classSubjects as $classSubject)

                        <tr>

                            <td>
                                {{ $classSubjects->firstItem() + $loop->index }}
                            </td>

                            <td>
                                <div class="fw-semibold">
                                   {{ $classSubject->classRoom?->class_name ?? 'N/A' }}
                                </div>
                            </td>

                            <td>
                                <div class="subject-info">
                                    <div class="subject-icon">
                                        <i class="fas fa-book"></i>
                                    </div>

                                    <div>
                                        <div class="fw-semibold">
                                           {{ $classSubject->subject?->subject_name ?? 'N/A' }}
                                        </div>

                                        <small class="text-muted">
                                            Class subject
                                        </small>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <span class="code-badge">
                                   {{ $classSubject->subject?->subject_code ?? 'N/A' }}
                                </span>
                            </td>

                            <td>
                                @if($classSubject->subject_type === 'Marks')
                                    <span class="type-badge type-marks">
                                        <i class="fas fa-pen-to-square me-1"></i>
                                        Marks
                                    </span>

                                @elseif($classSubject->subject_type === 'Grade')
                                    <span class="type-badge type-grade">
                                        <i class="fas fa-ranking-star me-1"></i>
                                        Grade
                                    </span>

                                @else
                                    <span class="type-badge type-activity">
                                        <i class="fas fa-puzzle-piece me-1"></i>
                                        Activity
                                    </span>
                                @endif
                            </td>

                            <td>
                                @if($classSubject->subject_type === 'Marks')
                                    <span class="marks-value">
                                        {{ $classSubject->full_marks }}
                                    </span>
                                @else
                                    <span class="text-muted">
                                        —
                                    </span>
                                @endif
                            </td>

                            <td>
                                @if($classSubject->subject_type === 'Marks')
                                    <span class="marks-value">
                                        {{ $classSubject->pass_marks }}
                                    </span>
                                @else
                                    <span class="text-muted">
                                        —
                                    </span>
                                @endif
                            </td>

                            <td>
                               @if($classSubject->status == 1)
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

                            <td class="text-end">

                                <div class="action-buttons">

                                    <a href="{{ route('class-subjects.edit', $classSubject->id) }}"
                                       class="btn-action btn-edit"
                                       title="Edit Assignment">
                                        <i class="fas fa-pen"></i>
                                    </a>

                                    <form action="{{ route('class-subjects.destroy', $classSubject->id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this class subject assignment?');">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn-action btn-delete"
                                                title="Delete Assignment">
                                            <i class="fas fa-trash"></i>
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="9"
                                class="text-center py-5">

                                <div class="empty-state">

                                    <div class="empty-state-icon">
                                        <i class="fas fa-book-open"></i>
                                    </div>

                                    <h5 class="mt-3 mb-2">
                                        No assignments found
                                    </h5>

                                    <p class="text-muted mb-3">
                                        No class subject assignments match your current filters.
                                    </p>

                                    <a href="{{ route('class-subjects.create') }}"
                                       class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>
                                        Assign First Subject
                                    </a>

                                </div>

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        @if($classSubjects->hasPages())
            <div class="content-card-footer">
                {{ $classSubjects->links() }}
            </div>
        @endif

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

    .summary-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        height: 100%;
        box-shadow: 0 4px 18px rgba(15, 23, 42, 0.05);
    }

    .summary-card-icon {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 21px;
        flex-shrink: 0;
    }

    .summary-card-label {
        color: #6b7280;
        font-size: 14px;
        font-weight: 500;
    }

    .summary-card-value {
        color: #111827;
        font-size: 26px;
        font-weight: 700;
    }

    .filter-card,
    .content-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        box-shadow: 0 4px 18px rgba(15, 23, 42, 0.05);
    }

    .filter-card {
        padding: 22px;
    }

    .content-card {
        overflow: hidden;
    }

    .content-card-header,
    .content-card-footer {
        padding: 20px 22px;
    }

    .content-card-header {
        border-bottom: 1px solid #e5e7eb;
    }

    .content-card-footer {
        border-top: 1px solid #e5e7eb;
    }

    .content-card-title {
        color: #1f2937;
        font-size: 18px;
        font-weight: 700;
    }

    .content-card-description {
        color: #6b7280;
        font-size: 14px;
    }

    .form-label {
        color: #374151;
        font-size: 14px;
        font-weight: 600;
    }

    .form-control,
    .form-select,
    .input-group-text {
        min-height: 44px;
        border-color: #d1d5db;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.12);
    }

    .table thead th {
        background: #f8fafc;
        color: #475569;
        border-bottom: 1px solid #e5e7eb;
        padding: 15px 16px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.45px;
        white-space: nowrap;
    }

    .table tbody td {
        color: #374151;
        border-color: #eef2f7;
        padding: 15px 16px;
        vertical-align: middle;
    }

    .table tbody tr:hover {
        background: #fafbff;
    }

    .subject-info {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 180px;
    }

    .subject-icon {
        width: 40px;
        height: 40px;
        border-radius: 11px;
        background: #eef2ff;
        color: #4f46e5;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-shrink: 0;
    }

    .code-badge {
        display: inline-flex;
        align-items: center;
        background: #f3f4f6;
        color: #374151;
        border-radius: 8px;
        padding: 6px 9px;
        font-size: 12px;
        font-weight: 700;
    }

    .type-badge,
    .status-badge {
        display: inline-flex;
        align-items: center;
        border-radius: 999px;
        padding: 7px 11px;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
    }

    .type-marks {
        background: #fef3c7;
        color: #92400e;
    }

    .type-grade {
        background: #ede9fe;
        color: #5b21b6;
    }

    .type-activity {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .status-active {
        background: #dcfce7;
        color: #166534;
    }

    .status-inactive {
        background: #fee2e2;
        color: #991b1b;
    }

    .status-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: currentColor;
        margin-right: 7px;
    }

    .marks-value {
        color: #111827;
        font-weight: 700;
    }

    .action-buttons {
        display: inline-flex;
        gap: 7px;
    }

    .btn-action {
        width: 36px;
        height: 36px;
        border: none;
        border-radius: 9px;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        text-decoration: none;
        transition: 0.2s ease;
    }

    .btn-edit {
        background: #eef2ff;
        color: #4338ca;
    }

    .btn-edit:hover {
        background: #4338ca;
        color: #ffffff;
    }

    .btn-delete {
        background: #fee2e2;
        color: #dc2626;
    }

    .btn-delete:hover {
        background: #dc2626;
        color: #ffffff;
    }

    .empty-state {
        max-width: 430px;
        margin: auto;
    }

    .empty-state-icon {
        width: 72px;
        height: 72px;
        margin: auto;
        border-radius: 20px;
        background: #eef2ff;
        color: #4f46e5;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
    }

    @media (max-width: 767px) {

        .container-fluid {
            padding-left: 12px;
            padding-right: 12px;
        }

        .page-header {
            align-items: stretch;
        }

        .page-header-action,
        .page-header-action .btn {
            width: 100%;
        }

        .page-title {
            font-size: 25px;
        }

        .filter-card {
            padding: 16px;
        }

        .content-card-header {
            padding: 17px;
        }

    }

</style>

@endsection