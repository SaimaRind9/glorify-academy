@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">

        <div>
            <h2 class="fw-bold mb-1">Attendance Management</h2>

            <p class="text-muted mb-0">
                View and update students' attendance records by class and date.
            </p>
        </div>

        <div class="attendance-date-badge">

            <i class="fa-solid fa-calendar-day me-2"></i>

            {{ \Carbon\Carbon::parse($selectedDate)->format('d F Y') }}

        </div>

    </div>


    {{-- Success Message --}}
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show shadow-sm"
             role="alert">

            <i class="fa-solid fa-circle-check me-2"></i>

            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- Validation Errors --}}
    @if($errors->any())

        <div class="alert alert-danger alert-dismissible fade show shadow-sm"
             role="alert">

            <i class="fa-solid fa-triangle-exclamation me-2"></i>

            {{ $errors->first() }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- Statistics Cards --}}
    <div class="row g-3 mb-4">

        {{-- Total Students --}}
        <div class="col-xl col-lg-4 col-md-6">

            <div class="card attendance-stat-card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex align-items-center justify-content-between">

                        <div>
                            <p class="text-muted mb-1">Total Students</p>

                            <h3 class="fw-bold mb-0">
                                {{ $totalStudents }}
                            </h3>
                        </div>

                        <div class="stat-icon total-icon">

                            <i class="fa-solid fa-users"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Present --}}
        <div class="col-xl col-lg-4 col-md-6">

            <div class="card attendance-stat-card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex align-items-center justify-content-between">

                        <div>
                            <p class="text-muted mb-1">Present</p>

                            <h3 class="fw-bold text-success mb-0">
                                {{ $presentCount }}
                            </h3>
                        </div>

                        <div class="stat-icon present-icon">

                            <i class="fa-solid fa-user-check"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Absent --}}
        <div class="col-xl col-lg-4 col-md-6">

            <div class="card attendance-stat-card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex align-items-center justify-content-between">

                        <div>
                            <p class="text-muted mb-1">Absent</p>

                            <h3 class="fw-bold text-danger mb-0">
                                {{ $absentCount }}
                            </h3>
                        </div>

                        <div class="stat-icon absent-icon">

                            <i class="fa-solid fa-user-xmark"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Leave --}}
        <div class="col-xl col-lg-4 col-md-6">

            <div class="card attendance-stat-card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex align-items-center justify-content-between">

                        <div>
                            <p class="text-muted mb-1">Leave</p>

                            <h3 class="fw-bold text-warning mb-0">
                                {{ $leaveCount }}
                            </h3>
                        </div>

                        <div class="stat-icon leave-icon">

                            <i class="fa-solid fa-calendar-minus"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Not Marked --}}
        <div class="col-xl col-lg-4 col-md-6">

            <div class="card attendance-stat-card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex align-items-center justify-content-between">

                        <div>
                            <p class="text-muted mb-1">Not Marked</p>

                            <h3 class="fw-bold text-secondary mb-0">
                                {{ $notMarkedCount }}
                            </h3>
                        </div>

                        <div class="stat-icon unmarked-icon">

                            <i class="fa-solid fa-circle-question"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Filters --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-header bg-white border-0 pt-4 px-4">

            <div class="d-flex align-items-center gap-2">

                <div class="filter-title-icon">

                    <i class="fa-solid fa-filter"></i>

                </div>

                <div>
                    <h5 class="fw-bold mb-0">Attendance Filters</h5>

                    <small class="text-muted">
                        Select a class and date to view attendance.
                    </small>
                </div>

            </div>

        </div>


        <div class="card-body px-4 pb-4">

            <form method="GET"
                  action="{{ route('admin.attendance.index') }}">

                <div class="row g-3 align-items-end">

                    {{-- Date --}}
                    <div class="col-lg-4 col-md-6">

                        <label for="date"
                               class="form-label fw-semibold">

                            Attendance Date

                        </label>

                        <div class="input-group">

                            <span class="input-group-text bg-white">

                                <i class="fa-solid fa-calendar-days"></i>

                            </span>

                            <input type="date"
                                   id="date"
                                   name="date"
                                   class="form-control"
                                   value="{{ $selectedDate }}">

                        </div>

                    </div>


                    {{-- Class --}}
                    <div class="col-lg-4 col-md-6">

                        <label for="class_room_id"
                               class="form-label fw-semibold">

                            Select Class

                        </label>

                        <div class="input-group">

                            <span class="input-group-text bg-white">

                                <i class="fa-solid fa-school"></i>

                            </span>

                            <select name="class_room_id"
                                    id="class_room_id"
                                    class="form-select">

                                <option value="">
                                    All Classes
                                </option>

                                @foreach($classes as $class)

                                    <option value="{{ $class->id }}"
                                        {{ (string) $selectedClass === (string) $class->id ? 'selected' : '' }}>

                                        {{ $class->class_name }}

                                    </option>

                                @endforeach

                            </select>

                        </div>

                    </div>


                    {{-- Buttons --}}
                    <div class="col-lg-4 col-md-12">

                        <div class="d-flex gap-2">

                            <button type="submit"
                                    class="btn btn-primary px-4 flex-grow-1">

                                <i class="fa-solid fa-magnifying-glass me-2"></i>

                                View Attendance

                            </button>

                            <a href="{{ route('admin.attendance.index') }}"
                               class="btn btn-outline-secondary px-3"
                               title="Reset Filters">

                                <i class="fa-solid fa-rotate-left"></i>

                            </a>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- Attendance Table --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white border-0 py-3 px-4">

            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

                <div>

                    <h5 class="fw-bold mb-1">
                        Students Attendance
                    </h5>

                    <p class="text-muted small mb-0">

                        Attendance records for

                        <strong>
                            {{ \Carbon\Carbon::parse($selectedDate)->format('d F Y') }}
                        </strong>

                    </p>

                </div>

                <span class="badge bg-light text-dark border px-3 py-2">

                    <i class="fa-solid fa-list me-1"></i>

                    {{ $students->count() }} Records

                </span>

            </div>

        </div>


        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0 attendance-table">

                    <thead class="table-light">

                        <tr>

                            <th class="ps-4">#</th>

                            <th>Student</th>

                            <th>Student ID</th>

                            <th>Class</th>

                            <th>Date</th>

                            <th>Current Status</th>

                            <th class="text-center pe-4">
                                Update Attendance
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($students as $student)

                            @php
                                $attendance = $student->attendances->first();
                            @endphp

                            <tr>

                                {{-- Serial Number --}}
                                <td class="ps-4 text-muted fw-semibold">

                                    {{ $loop->iteration }}

                                </td>


                                {{-- Student --}}
                                <td>

                                    <div class="d-flex align-items-center gap-3">

                                        @if($student->photo)

                                            <img src="{{ asset('storage/' . $student->photo) }}"
                                                 alt="{{ $student->name }}"
                                                 width="48"
                                                 height="48"
                                                 class="rounded-circle object-fit-cover border">

                                        @else

                                            <div class="student-avatar">

                                                {{ strtoupper(substr($student->name, 0, 1)) }}

                                            </div>

                                        @endif


                                        <div>

                                            <h6 class="fw-semibold mb-1">

                                                {{ $student->name }}

                                            </h6>

                                            <small class="text-muted">

                                                {{ $student->father_name ?? 'Father name not provided' }}

                                            </small>

                                        </div>

                                    </div>

                                </td>


                                {{-- Student ID --}}
                                <td>

                                    <span class="fw-semibold">

                                        {{ $student->student_id }}

                                    </span>

                                </td>


                                {{-- Class --}}
                                <td>

                                    @if($student->classRoom)

                                        <span class="badge class-badge">

                                            <i class="fa-solid fa-school me-1"></i>

                                            {{ $student->classRoom->class_name }}

                                        </span>

                                    @else

                                        <span class="badge bg-light text-muted border">

                                            Not Assigned

                                        </span>

                                    @endif

                                </td>


                                {{-- Date --}}
                                <td>

                                    <div class="fw-semibold">

                                        {{ \Carbon\Carbon::parse($selectedDate)->format('d M Y') }}

                                    </div>

                                    <small class="text-muted">

                                        {{ \Carbon\Carbon::parse($selectedDate)->format('l') }}

                                    </small>

                                </td>


                                {{-- Current Status --}}
                                <td>

                                    @if(!$attendance)

                                        <span class="attendance-status status-not-marked">

                                            <i class="fa-solid fa-circle-question me-1"></i>

                                            Not Marked

                                        </span>

                                    @elseif($attendance->status === 'Present')

                                        <span class="attendance-status status-present">

                                            <i class="fa-solid fa-circle-check me-1"></i>

                                            Present

                                        </span>

                                    @elseif($attendance->status === 'Absent')

                                        <span class="attendance-status status-absent">

                                            <i class="fa-solid fa-circle-xmark me-1"></i>

                                            Absent

                                        </span>

                                    @elseif($attendance->status === 'Leave')

                                        <span class="attendance-status status-leave">

                                            <i class="fa-solid fa-clock me-1"></i>

                                            Leave

                                        </span>

                                    @else

                                        <span class="attendance-status status-not-marked">

                                            {{ $attendance->status }}

                                        </span>

                                    @endif

                                </td>


                                {{-- Update --}}
                                <td class="text-center pe-4">

                                    @if($attendance)

                                        <form method="POST"
                                              action="{{ route('admin.attendance.update', $attendance->id) }}"
                                              class="attendance-update-form">

                                            @csrf
                                            @method('PUT')

                                            <div class="d-flex justify-content-center align-items-center gap-2">

                                                <select name="status"
                                                        class="form-select form-select-sm status-select"
                                                        required>

                                                    <option value="Present"
                                                        {{ $attendance->status === 'Present' ? 'selected' : '' }}>

                                                        Present

                                                    </option>

                                                    <option value="Absent"
                                                        {{ $attendance->status === 'Absent' ? 'selected' : '' }}>

                                                        Absent

                                                    </option>

                                                    <option value="Leave"
                                                        {{ $attendance->status === 'Leave' ? 'selected' : '' }}>

                                                        Leave

                                                    </option>

                                                </select>

                                                <button type="submit"
                                                        class="btn btn-sm btn-primary update-button"
                                                        title="Update Attendance">

                                                    <i class="fa-solid fa-floppy-disk"></i>

                                                    <span class="d-none d-xl-inline ms-1">
                                                        Update
                                                    </span>

                                                </button>

                                            </div>

                                        </form>

                                    @else

                                        <span class="text-muted small">

                                            <i class="fa-solid fa-lock me-1"></i>

                                            No record available

                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7"
                                    class="text-center py-5">

                                    <div class="empty-state">

                                        <div class="empty-state-icon">

                                            <i class="fa-solid fa-calendar-xmark"></i>

                                        </div>

                                        <h5 class="fw-bold">
                                            No Students Found
                                        </h5>

                                        <p class="text-muted mb-0">

                                            No students were found for the selected
                                            class and date.

                                        </p>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    {{-- Information Note --}}
    <div class="attendance-note mt-4">

        <div class="note-icon">

            <i class="fa-solid fa-circle-info"></i>

        </div>

        <div>

            <h6 class="fw-bold mb-1">
                Attendance Editing Information
            </h6>

            <p class="mb-0">

                Admin can update attendance records that have already been
                marked by the assigned teacher. Students showing
                <strong>Not Marked</strong> do not have an attendance record
                for the selected date.

            </p>

        </div>

    </div>

</div>


<style>

    .attendance-date-badge {
        padding: 10px 16px;
        border: 1px solid #dbeafe;
        border-radius: 10px;
        color: #1d4ed8;
        background: #eff6ff;
        font-size: 14px;
        font-weight: 600;
    }

    .attendance-stat-card {
        border-radius: 14px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .attendance-stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.09) !important;
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 20px;
    }

    .total-icon {
        color: #2563eb;
        background: #dbeafe;
    }

    .present-icon {
        color: #15803d;
        background: #dcfce7;
    }

    .absent-icon {
        color: #dc2626;
        background: #fee2e2;
    }

    .leave-icon {
        color: #c2410c;
        background: #ffedd5;
    }

    .unmarked-icon {
        color: #475569;
        background: #e2e8f0;
    }

    .filter-title-icon {
        width: 42px;
        height: 42px;
        border-radius: 11px;
        color: #2563eb;
        background: #dbeafe;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .student-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        color: #1d4ed8;
        background: #dbeafe;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 17px;
        font-weight: 700;
    }

    .class-badge {
        padding: 7px 10px;
        border: 1px solid #bae6fd;
        color: #0369a1;
        background: #e0f2fe;
        font-weight: 600;
    }

    .attendance-status {
        min-width: 105px;
        padding: 7px 11px;
        border: 1px solid transparent;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 700;
    }

    .status-present {
        border-color: #bbf7d0;
        color: #15803d;
        background: #dcfce7;
    }

    .status-absent {
        border-color: #fecaca;
        color: #b91c1c;
        background: #fee2e2;
    }

    .status-leave {
        border-color: #fed7aa;
        color: #c2410c;
        background: #ffedd5;
    }

    .status-not-marked {
        border-color: #cbd5e1;
        color: #475569;
        background: #f1f5f9;
    }

    .status-select {
        width: 115px;
        min-width: 115px;
    }

    .update-button {
        white-space: nowrap;
    }

    .attendance-table th {
        padding-top: 14px;
        padding-bottom: 14px;
        color: #64748b;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        white-space: nowrap;
    }

    .attendance-table td {
        padding-top: 15px;
        padding-bottom: 15px;
        vertical-align: middle;
    }

    .attendance-table tbody tr {
        transition: background 0.2s ease;
    }

    .attendance-table tbody tr:hover {
        background: #f8fafc;
    }

    .empty-state {
        padding: 25px;
    }

    .empty-state-icon {
        width: 70px;
        height: 70px;
        margin: 0 auto 16px;
        border-radius: 20px;
        color: #2563eb;
        background: #eff6ff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
    }

    .attendance-note {
        padding: 18px 20px;
        border: 1px solid #bfdbfe;
        border-radius: 13px;
        color: #1e3a8a;
        background: #eff6ff;
        display: flex;
        align-items: flex-start;
        gap: 14px;
    }

    .attendance-note p {
        color: #475569;
        font-size: 13px;
        line-height: 1.6;
    }

    .note-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        color: #2563eb;
        background: #dbeafe;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    @media (max-width: 767px) {

        .attendance-date-badge {
            width: 100%;
            text-align: center;
        }

        .attendance-note {
            flex-direction: column;
        }

        .attendance-update-form .d-flex {
            align-items: stretch !important;
            flex-direction: column;
        }

        .status-select {
            width: 100%;
        }

        .update-button {
            width: 100%;
        }

    }

</style>


<script>

    document.addEventListener('DOMContentLoaded', function () {

        const updateForms = document.querySelectorAll(
            '.attendance-update-form'
        );

        updateForms.forEach(function (form) {

            form.addEventListener('submit', function (event) {

                const status = form.querySelector(
                    'select[name="status"]'
                ).value;

                const confirmed = confirm(
                    'Are you sure you want to update this attendance to ' +
                    status +
                    '?'
                );

                if (!confirmed) {
                    event.preventDefault();
                }

            });

        });

    });

</script>

@endsection