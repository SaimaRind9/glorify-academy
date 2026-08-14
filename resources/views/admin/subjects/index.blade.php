@extends('layouts.admin')

@section('content')

<div class="container-fluid py-4">

    {{-- Page Header --}}
    <div class="page-header mb-4">
        <div>
            <p class="page-subtitle mb-1">Academic Management</p>

            <h2 class="page-title mb-2">
                Subjects
            </h2>

            <p class="page-description mb-0">
                Manage all academy subjects from one place.
            </p>
        </div>

        <a href="{{ route('subjects.create') }}" class="add-subject-btn">
            <i class="fa-solid fa-plus"></i>
            Add Subject
        </a>
    </div>


    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show custom-alert" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i>
            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>
        </div>
    @endif


    {{-- Error Message --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show custom-alert" role="alert">
            <i class="fa-solid fa-circle-exclamation me-2"></i>
            {{ session('error') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>
        </div>
    @endif


    {{-- Statistics --}}
    <div class="row g-4 mb-4">

        <div class="col-lg-4 col-md-6">
            <div class="stat-card">

                <div class="stat-icon total-icon">
                    <i class="fa-solid fa-book"></i>
                </div>

                <div>
                    <p>Total Subjects</p>
                    <h3>{{ $totalSubjects }}</h3>
                </div>

            </div>
        </div>


        <div class="col-lg-4 col-md-6">
            <div class="stat-card">

                <div class="stat-icon active-icon">
                    <i class="fa-solid fa-circle-check"></i>
                </div>

                <div>
                    <p>Active Subjects</p>
                    <h3>{{ $activeSubjects }}</h3>
                </div>

            </div>
        </div>


        <div class="col-lg-4 col-md-6">
            <div class="stat-card">

                <div class="stat-icon inactive-icon">
                    <i class="fa-solid fa-circle-xmark"></i>
                </div>

                <div>
                    <p>Inactive Subjects</p>
                    <h3>{{ $inactiveSubjects }}</h3>
                </div>

            </div>
        </div>

    </div>


    {{-- Filters --}}
    <div class="dashboard-card mb-4">

        <div class="card-heading">
            <div>
                <h5>Search & Filter</h5>
                <p>Find subjects by name, code or status</p>
            </div>

            <div class="heading-icon">
                <i class="fa-solid fa-filter"></i>
            </div>
        </div>


        <form method="GET"
              action="{{ route('subjects.index') }}"
              class="row g-3">

            <div class="col-lg-6">
                <label class="form-label">Search Subject</label>

                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>

                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           class="form-control"
                           placeholder="Enter subject name or code">
                </div>
            </div>


            <div class="col-lg-3">
                <label class="form-label">Status</label>

                <select name="status" class="form-select">

                    <option value="">All Status</option>

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


            <div class="col-lg-3 d-flex align-items-end gap-2">

                <button type="submit" class="filter-btn">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    Search
                </button>

                <a href="{{ route('subjects.index') }}" class="reset-btn">
                    <i class="fa-solid fa-rotate-left"></i>
                </a>

            </div>

        </form>

    </div>


    {{-- Subjects Table --}}
    <div class="dashboard-card">

        <div class="card-heading">
            <div>
                <h5>Subject List</h5>
                <p>All subjects currently available in the academy</p>
            </div>

            <div class="heading-icon">
                <i class="fa-solid fa-list"></i>
            </div>
        </div>


        <div class="table-responsive">

            <table class="table subject-table align-middle">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Subject</th>
                        <th>Code</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($subjects as $subject)

                        <tr>

                            <td>
                                {{ $subjects->firstItem() + $loop->index }}
                            </td>


                            <td>
                                <div class="subject-info">

                                    <div class="subject-icon">
                                        <i class="fa-solid fa-book-open"></i>
                                    </div>

                                    <div>
                                        <h6>{{ $subject->subject_name }}</h6>
                                        <small>Academy Subject</small>
                                    </div>

                                </div>
                            </td>


                            <td>
                                <span class="subject-code">
                                    {{ $subject->subject_code }}
                                </span>
                            </td>


                            <td>
                                <span class="description-text">
                                    {{ $subject->description ?: 'No description added.' }}
                                </span>
                            </td>


                            <td>
                                @if($subject->status)

                                    <span class="status-badge active-status">
                                        <i class="fa-solid fa-circle"></i>
                                        Active
                                    </span>

                                @else

                                    <span class="status-badge inactive-status">
                                        <i class="fa-solid fa-circle"></i>
                                        Inactive
                                    </span>

                                @endif
                            </td>


                            <td>
                                <div class="action-buttons">

                                    <a href="{{ route('subjects.edit', $subject) }}"
                                       class="action-btn edit-btn"
                                       title="Edit Subject">

                                        <i class="fa-solid fa-pen"></i>

                                    </a>


                                    <form method="POST"
                                          action="{{ route('subjects.destroy', $subject) }}"
                                          onsubmit="return confirm('Are you sure you want to delete this subject?');">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="action-btn delete-btn"
                                                title="Delete Subject">

                                            <i class="fa-solid fa-trash"></i>

                                        </button>

                                    </form>

                                </div>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6">

                                <div class="empty-state">

                                    <div class="empty-icon">
                                        <i class="fa-solid fa-book-open"></i>
                                    </div>

                                    <h4>No Subjects Found</h4>

                                    <p>
                                        Add the first subject to start academic management.
                                    </p>

                                    <a href="{{ route('subjects.create') }}"
                                       class="add-subject-btn empty-btn">

                                        <i class="fa-solid fa-plus"></i>
                                        Add First Subject

                                    </a>

                                </div>

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        @if($subjects->hasPages())
            <div class="pagination-wrapper">
                {{ $subjects->links() }}
            </div>
        @endif

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

    .add-subject-btn {
        background: white;
        color: #2563eb;
        border: none;
        border-radius: 12px;
        padding: 12px 19px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 700;
        white-space: nowrap;
        box-shadow: 0 8px 20px rgba(15, 23, 42, 0.14);
        transition: all 0.25s ease;
    }

    .add-subject-btn:hover {
        color: #1d4ed8;
        transform: translateY(-3px);
    }

    .custom-alert {
        border: none;
        border-radius: 14px;
        font-size: 14px;
    }

    .stat-card {
        background: white;
        border: 1px solid #edf0f5;
        border-radius: 18px;
        padding: 22px;
        display: flex;
        align-items: center;
        gap: 16px;
        height: 100%;
        box-shadow: 0 8px 25px rgba(15, 23, 42, 0.06);
        transition: all 0.25s ease;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 14px 30px rgba(15, 23, 42, 0.10);
    }

    .stat-card p {
        margin: 0 0 4px;
        color: #64748b;
        font-size: 13px;
    }

    .stat-card h3 {
        margin: 0;
        color: #0f172a;
        font-size: 28px;
        font-weight: 750;
    }

    .stat-icon {
        width: 58px;
        height: 58px;
        border-radius: 16px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 24px;
    }

    .total-icon {
        background: #dbeafe;
        color: #2563eb;
    }

    .active-icon {
        background: #d1fae5;
        color: #059669;
    }

    .inactive-icon {
        background: #fee2e2;
        color: #dc2626;
    }

    .dashboard-card {
        background: white;
        border-radius: 18px;
        padding: 24px;
        border: 1px solid #edf0f5;
        box-shadow: 0 8px 25px rgba(15, 23, 42, 0.06);
    }

    .card-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .card-heading h5 {
        margin: 0 0 4px;
        color: #0f172a;
        font-size: 18px;
        font-weight: 700;
    }

    .card-heading p {
        margin: 0;
        color: #94a3b8;
        font-size: 13px;
    }

    .heading-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: #eff6ff;
        color: #2563eb;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 18px;
    }

    .form-label {
        color: #334155;
        font-size: 13px;
        font-weight: 600;
    }

    .form-control,
    .form-select,
    .input-group-text {
        border-color: #e2e8f0;
        min-height: 44px;
        font-size: 13px;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #60a5fa;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.10);
    }

    .input-group-text {
        background: #f8fafc;
        color: #64748b;
    }

    .filter-btn,
    .reset-btn {
        height: 44px;
        border: none;
        border-radius: 11px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 650;
        transition: all 0.25s ease;
    }

    .filter-btn {
        flex: 1;
        background: #2563eb;
        color: white;
    }

    .filter-btn:hover {
        background: #1d4ed8;
    }

    .reset-btn {
        width: 44px;
        background: #f1f5f9;
        color: #64748b;
    }

    .reset-btn:hover {
        color: #2563eb;
        background: #e2e8f0;
    }

    .subject-table {
        margin: 0;
    }

    .subject-table thead th {
        background: #f8fafc;
        color: #475569;
        border-bottom: 1px solid #e2e8f0;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        padding: 15px;
        white-space: nowrap;
    }

    .subject-table tbody td {
        padding: 16px 15px;
        border-bottom: 1px solid #f1f5f9;
        color: #475569;
        font-size: 13px;
    }

    .subject-info {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 180px;
    }

    .subject-icon {
        width: 43px;
        height: 43px;
        border-radius: 12px;
        background: #eff6ff;
        color: #2563eb;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 17px;
        flex-shrink: 0;
    }

    .subject-info h6 {
        margin: 0 0 3px;
        color: #0f172a;
        font-size: 14px;
        font-weight: 700;
    }

    .subject-info small {
        color: #94a3b8;
        font-size: 11px;
    }

    .subject-code {
        display: inline-block;
        background: #f1f5f9;
        color: #334155;
        border-radius: 8px;
        padding: 6px 10px;
        font-size: 12px;
        font-weight: 700;
    }

    .description-text {
        display: block;
        max-width: 300px;
        color: #64748b;
        line-height: 1.5;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: 30px;
        padding: 6px 10px;
        font-size: 11px;
        font-weight: 700;
    }

    .status-badge i {
        font-size: 7px;
    }

    .active-status {
        background: #dcfce7;
        color: #15803d;
    }

    .inactive-status {
        background: #fee2e2;
        color: #b91c1c;
    }

    .action-buttons {
        display: flex;
        justify-content: center;
        gap: 8px;
    }

    .action-buttons form {
        margin: 0;
    }

    .action-btn {
        width: 36px;
        height: 36px;
        border: none;
        border-radius: 10px;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        text-decoration: none;
        font-size: 13px;
        transition: all 0.25s ease;
    }

    .edit-btn {
        background: #dbeafe;
        color: #2563eb;
    }

    .edit-btn:hover {
        background: #2563eb;
        color: white;
    }

    .delete-btn {
        background: #fee2e2;
        color: #dc2626;
    }

    .delete-btn:hover {
        background: #dc2626;
        color: white;
    }

    .empty-state {
        text-align: center;
        padding: 55px 20px;
    }

    .empty-icon {
        width: 75px;
        height: 75px;
        border-radius: 20px;
        background: #eff6ff;
        color: #2563eb;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 32px;
        margin: 0 auto 18px;
    }

    .empty-state h4 {
        color: #0f172a;
        font-weight: 700;
    }

    .empty-state p {
        color: #94a3b8;
        font-size: 13px;
        margin-bottom: 20px;
    }

    .empty-btn {
        background: #2563eb;
        color: white;
    }

    .empty-btn:hover {
        background: #1d4ed8;
        color: white;
    }

    .pagination-wrapper {
        margin-top: 24px;
        display: flex;
        justify-content: flex-end;
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

        .add-subject-btn {
            width: 100%;
        }

        .card-heading {
            align-items: flex-start;
        }

        .dashboard-card {
            padding: 18px;
        }

        .description-text {
            min-width: 200px;
        }
    }

</style>

@endsection