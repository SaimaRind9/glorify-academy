@extends('layouts.admin')

@section('content')
@php
    $displayedStudents = $students ? $students->count() : 0;

    $passedStudents = $students
        ? $students->getCollection()->filter(function ($student) {
            return ($student->result_summary['result_status'] ?? '') === 'Pass';
        })->count()
        : 0;

    $failedStudents = $students
        ? $students->getCollection()->filter(function ($student) {
            return ($student->result_summary['result_status'] ?? '') === 'Fail';
        })->count()
        : 0;

    $passPercentage = $displayedStudents > 0
        ? round(($passedStudents / $displayedStudents) * 100, 1)
        : 0;
@endphp

<style>
    .results-page {
        padding: 24px;
        min-height: 100vh;
        background: #f4f7fb;
    }

    .results-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 24px;
    }

    .results-header-left {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .results-header-icon {
        width: 55px;
        height: 55px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        color: #ffffff;
        font-size: 24px;
        background: linear-gradient(135deg, #7c3aed, #4f46e5);
        box-shadow: 0 10px 25px rgba(79, 70, 229, 0.25);
    }

    .results-header h2 {
        margin: 0 0 5px;
        color: #172033;
        font-size: 27px;
        font-weight: 800;
    }

    .results-header p {
        margin: 0;
        color: #7a8499;
        font-size: 14px;
    }

    .header-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 16px;
        border-radius: 12px;
        color: #5b21b6;
        background: #ede9fe;
        font-size: 13px;
        font-weight: 700;
    }

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 24px;
    }

    .summary-card {
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 20px;
        border: 1px solid #e8edf5;
        border-radius: 18px;
        background: #ffffff;
        box-shadow: 0 8px 25px rgba(17, 24, 39, 0.05);
        transition: 0.25s ease;
    }

    .summary-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(17, 24, 39, 0.09);
    }

    .summary-card::after {
        content: "";
        position: absolute;
        top: -30px;
        right: -30px;
        width: 90px;
        height: 90px;
        border-radius: 50%;
        background: currentColor;
        opacity: 0.06;
    }

    .summary-icon {
        width: 52px;
        height: 52px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 21px;
    }

    .summary-purple {
        color: #6d28d9;
    }

    .summary-purple .summary-icon {
        color: #6d28d9;
        background: #ede9fe;
    }

    .summary-green {
        color: #059669;
    }

    .summary-green .summary-icon {
        color: #059669;
        background: #d1fae5;
    }

    .summary-red {
        color: #dc2626;
    }

    .summary-red .summary-icon {
        color: #dc2626;
        background: #fee2e2;
    }

    .summary-blue {
        color: #2563eb;
    }

    .summary-blue .summary-icon {
        color: #2563eb;
        background: #dbeafe;
    }

    .summary-content h3 {
        margin: 0 0 4px;
        color: #172033;
        font-size: 25px;
        font-weight: 800;
    }

    .summary-content p {
        margin: 0;
        color: #7a8499;
        font-size: 13px;
        font-weight: 600;
    }

    .filter-card {
        margin-bottom: 24px;
        padding: 22px;
        border: 1px solid #e8edf5;
        border-radius: 18px;
        background: #ffffff;
        box-shadow: 0 8px 25px rgba(17, 24, 39, 0.05);
    }

    .filter-title {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 18px;
        color: #172033;
        font-size: 16px;
        font-weight: 800;
    }

    .filter-title i {
        color: #6d28d9;
    }

    .filter-form {
        display: grid;
        grid-template-columns: 1fr 1fr 1.3fr auto;
        align-items: end;
        gap: 15px;
    }

    .form-group {
        min-width: 0;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #404a60;
        font-size: 13px;
        font-weight: 700;
    }

    .required-star {
        color: #dc2626;
    }

    .form-control-custom {
        width: 100%;
        height: 46px;
        padding: 0 14px;
        border: 1px solid #dce3ed;
        border-radius: 11px;
        outline: none;
        color: #30394d;
        background: #ffffff;
        font-size: 14px;
        transition: 0.2s ease;
    }

    .form-control-custom:focus {
        border-color: #7c3aed;
        box-shadow: 0 0 0 4px rgba(124, 58, 237, 0.1);
    }

    .filter-actions {
        display: flex;
        gap: 10px;
    }

    .btn-filter,
    .btn-reset {
        height: 46px;
        border: none;
        border-radius: 11px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 0 18px;
        text-decoration: none;
        white-space: nowrap;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: 0.22s ease;
    }

    .btn-filter {
        color: #ffffff;
        background: linear-gradient(135deg, #7c3aed, #4f46e5);
        box-shadow: 0 8px 18px rgba(79, 70, 229, 0.2);
    }

    .btn-filter:hover {
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 10px 22px rgba(79, 70, 229, 0.28);
    }

    .btn-reset {
        color: #5f687a;
        background: #eef1f6;
    }

    .btn-reset:hover {
        color: #374151;
        background: #e3e7ed;
    }

    .results-table-card {
        overflow: hidden;
        border: 1px solid #e8edf5;
        border-radius: 18px;
        background: #ffffff;
        box-shadow: 0 8px 25px rgba(17, 24, 39, 0.05);
    }

    .table-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        padding: 20px 22px;
        border-bottom: 1px solid #edf0f5;
    }

    .table-card-header h3 {
        margin: 0 0 4px;
        color: #172033;
        font-size: 17px;
        font-weight: 800;
    }

    .table-card-header p {
        margin: 0;
        color: #8a93a5;
        font-size: 13px;
    }

    .record-count {
        padding: 8px 13px;
        border-radius: 9px;
        color: #5b21b6;
        background: #f3e8ff;
        font-size: 12px;
        font-weight: 800;
    }

    .table-responsive-custom {
        overflow-x: auto;
    }

    .results-table {
        width: 100%;
        min-width: 1050px;
        margin: 0;
        border-collapse: collapse;
    }

    .results-table thead th {
        padding: 15px 16px;
        border-bottom: 1px solid #e9edf3;
        color: #687286;
        background: #f8f9fc;
        text-align: left;
        white-space: nowrap;
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }

    .results-table tbody td {
        padding: 16px;
        border-bottom: 1px solid #eff2f6;
        color: #404a60;
        vertical-align: middle;
        font-size: 13px;
    }

    .results-table tbody tr {
        transition: 0.2s ease;
    }

    .results-table tbody tr:hover {
        background: #faf9ff;
    }

    .results-table tbody tr:last-child td {
        border-bottom: none;
    }

    .student-info {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 190px;
    }

    .student-avatar {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        color: #ffffff;
        background: linear-gradient(135deg, #8b5cf6, #4f46e5);
        font-size: 15px;
        font-weight: 800;
        text-transform: uppercase;
    }

    .student-name {
        margin-bottom: 3px;
        color: #222b3d;
        font-size: 14px;
        font-weight: 800;
    }

    .student-subtext {
        color: #929aac;
        font-size: 11px;
    }

    .student-id {
        display: inline-flex;
        padding: 6px 10px;
        border-radius: 8px;
        color: #334155;
        background: #f1f5f9;
        font-size: 12px;
        font-weight: 700;
    }

    .subject-count {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #4f46e5;
        font-weight: 800;
    }

    .percentage-value {
        color: #172033;
        font-size: 14px;
        font-weight: 800;
    }

    .progress-track {
        width: 85px;
        height: 6px;
        margin-top: 6px;
        overflow: hidden;
        border-radius: 10px;
        background: #e9edf4;
    }

    .progress-fill {
        height: 100%;
        border-radius: 10px;
        background: linear-gradient(90deg, #7c3aed, #4f46e5);
    }

    .grade-badge {
        min-width: 40px;
        height: 34px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0 10px;
        color: #5b21b6;
        background: #ede9fe;
        font-size: 13px;
        font-weight: 900;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 11px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 800;
    }

    .status-pass {
        color: #047857;
        background: #d1fae5;
    }

    .status-fail {
        color: #b91c1c;
        background: #fee2e2;
    }

    .status-pending {
        color: #a16207;
        background: #fef3c7;
    }

    .btn-view-result {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 9px 13px;
        border-radius: 9px;
        color: #ffffff;
        background: linear-gradient(135deg, #7c3aed, #4f46e5);
        text-decoration: none;
        white-space: nowrap;
        font-size: 12px;
        font-weight: 800;
        transition: 0.22s ease;
    }

    .btn-view-result:hover {
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 7px 16px rgba(79, 70, 229, 0.23);
    }

    .empty-state {
        padding: 65px 20px;
        text-align: center;
    }

    .empty-state-icon {
        width: 78px;
        height: 78px;
        margin: 0 auto 17px;
        border-radius: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6d28d9;
        background: #ede9fe;
        font-size: 31px;
    }

    .empty-state h4 {
        margin: 0 0 7px;
        color: #253047;
        font-size: 18px;
        font-weight: 800;
    }

    .empty-state p {
        max-width: 430px;
        margin: 0 auto;
        color: #8a93a5;
        font-size: 13px;
        line-height: 1.7;
    }

    .pagination-wrapper {
        padding: 18px 22px;
        border-top: 1px solid #edf0f5;
    }

    .pagination-wrapper nav {
        margin: 0;
    }

    @media (max-width: 1199px) {
        .summary-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .filter-form {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .filter-actions {
            grid-column: span 2;
        }
    }

    @media (max-width: 767px) {
        .results-page {
            padding: 15px;
        }

        .results-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .results-header h2 {
            font-size: 23px;
        }

        .header-badge {
            width: 100%;
            justify-content: center;
        }

        .summary-grid {
            grid-template-columns: 1fr;
            gap: 13px;
        }

        .filter-form {
            grid-template-columns: 1fr;
        }

        .filter-actions {
            grid-column: auto;
            flex-direction: column;
        }

        .btn-filter,
        .btn-reset {
            width: 100%;
        }

        .table-card-header {
            align-items: flex-start;
            flex-direction: column;
        }
    }
</style>

<div class="results-page">

    {{-- Page Header --}}
    <div class="results-header">
        <div class="results-header-left">
            <div class="results-header-icon">
                <i class="fa-solid fa-file-lines"></i>
            </div>

            <div>
                <h2>Result Management</h2>
                <p>
                    Select an exam and class to view students'
                    academic results.
                </p>
            </div>
        </div>

        <div class="header-badge">
            <i class="fa-solid fa-graduation-cap"></i>
            Student Report Cards
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="summary-grid">

        <div class="summary-card summary-purple">
            <div class="summary-icon">
                <i class="fa-solid fa-users"></i>
            </div>

            <div class="summary-content">
                <h3>{{ $displayedStudents }}</h3>
                <p>Displayed Students</p>
            </div>
        </div>

        <div class="summary-card summary-green">
            <div class="summary-icon">
                <i class="fa-solid fa-circle-check"></i>
            </div>

            <div class="summary-content">
                <h3>{{ $passedStudents }}</h3>
                <p>Passed Students</p>
            </div>
        </div>

        <div class="summary-card summary-red">
            <div class="summary-icon">
                <i class="fa-solid fa-circle-xmark"></i>
            </div>

            <div class="summary-content">
                <h3>{{ $failedStudents }}</h3>
                <p>Failed Students</p>
            </div>
        </div>

        <div class="summary-card summary-blue">
            <div class="summary-icon">
                <i class="fa-solid fa-chart-line"></i>
            </div>

            <div class="summary-content">
                <h3>{{ number_format($passPercentage, 1) }}%</h3>
                <p>Displayed Pass Rate</p>
            </div>
        </div>

    </div>

    {{-- Filters --}}
    <div class="filter-card">
        <div class="filter-title">
            <i class="fa-solid fa-filter"></i>
            Search and Filter Results
        </div>

        <form
            action="{{ route('results.index') }}"
            method="GET"
            class="filter-form"
        >
            <div class="form-group">
                <label for="exam_id">
                    Select Exam
                    <span class="required-star">*</span>
                </label>

                <select
                    name="exam_id"
                    id="exam_id"
                    class="form-control-custom"
                    required
                >
                    <option value="">Choose Exam</option>

                    @foreach($exams as $exam)
                        <option
                            value="{{ $exam->id }}"
                            {{ (string) $selectedExamId === (string) $exam->id
                                ? 'selected'
                                : '' }}
                        >
                            {{ $exam->exam_name ?? $exam->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="class_room_id">
                    Select Class
                </label>

                <select
                    name="class_room_id"
                    id="class_room_id"
                    class="form-control-custom"
                >
                    <option value="">All Classes</option>

                    @foreach($classes as $class)
                        <option
                            value="{{ $class->id }}"
                            {{ (string) $selectedClassId === (string) $class->id
                                ? 'selected'
                                : '' }}
                        >
                            {{ $class->class_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="search">
                    Search Student
                </label>

                <input
                    type="text"
                    name="search"
                    id="search"
                    class="form-control-custom"
                    value="{{ request('search') }}"
                    placeholder="Enter student name or ID"
                >
            </div>

            <div class="filter-actions">
                <button type="submit" class="btn-filter">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    View Results
                </button>

                <a
                    href="{{ route('results.index') }}"
                    class="btn-reset"
                >
                    <i class="fa-solid fa-rotate-left"></i>
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- Results Table --}}
    <div class="results-table-card">

        <div class="table-card-header">
            <div>
                <h3>Students Result List</h3>

                <p>
                    @if($selectedExamId)
                        Students having marks in the selected exam.
                    @else
                        Select an exam to display students.
                    @endif
                </p>
            </div>

            @if($students)
                <div class="record-count">
                    {{ $students->total() }}
                    {{ Str::plural('Record', $students->total()) }}
                </div>
            @endif
        </div>

        @if(!$selectedExamId)

            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fa-solid fa-file-circle-question"></i>
                </div>

                <h4>Select an Exam</h4>

                <p>
                    Please select an exam from the filter section to view
                    student results and generate report cards.
                </p>
            </div>

        @elseif($students && $students->count() > 0)

            <div class="table-responsive-custom">
                <table class="results-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Student</th>
                            <th>Student ID</th>
                            <th>Class</th>
                            <th>Subjects</th>
                            <th>Obtained / Total</th>
                            <th>Percentage</th>
                            <th>Grade</th>
                            <th>Result</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($students as $student)

                            @php
                                $summary = $student->result_summary;

                                $percentage = (float) (
                                    $summary['percentage'] ?? 0
                                );

                                $resultStatus =
                                    $summary['result_status'] ?? 'Pending';

                                $studentInitials = collect(
                                    preg_split(
                                        '/\s+/',
                                        trim($student->name)
                                    )
                                )
                                ->filter()
                                ->take(2)
                                ->map(function ($word) {
                                    return strtoupper(
                                        substr($word, 0, 1)
                                    );
                                })
                                ->implode('');
                            @endphp

                            <tr>
                                <td>
                                    {{ $students->firstItem() + $loop->index }}
                                </td>

                                <td>
                                    <div class="student-info">
                                        <div class="student-avatar">
                                            {{ $studentInitials ?: 'ST' }}
                                        </div>

                                        <div>
                                            <div class="student-name">
                                                {{ $student->name }}
                                            </div>

                                            <div class="student-subtext">
                                                Result report available
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <span class="student-id">
                                        {{ $student->student_id }}
                                    </span>
                                </td>

                                <td>
                                    {{ $student->classRoom->class_name
                                        ?? 'Not Assigned' }}
                                </td>

                                <td>
                                    <span class="subject-count">
                                        <i class="fa-solid fa-book-open"></i>

                                        {{ $summary['total_subjects'] ?? 0 }}
                                    </span>
                                </td>

                                <td>
                                    <strong>
                                        {{ number_format(
                                            $summary['obtained_marks'] ?? 0,
                                            2
                                        ) }}
                                    </strong>

                                    <span style="color: #9aa2b2;">
                                        /
                                        {{ number_format(
                                            $summary['total_marks'] ?? 0,
                                            2
                                        ) }}
                                    </span>
                                </td>

                                <td>
                                    <div class="percentage-value">
                                        {{ number_format($percentage, 2) }}%
                                    </div>

                                    <div class="progress-track">
                                        <div
                                            class="progress-fill"
                                            style="width:
                                                {{ min(
                                                    max($percentage, 0),
                                                    100
                                                ) }}%;"
                                        ></div>
                                    </div>
                                </td>

                                <td>
                                    <span class="grade-badge">
                                        {{ $summary['grade'] ?? 'N/A' }}
                                    </span>
                                </td>

                                <td>
                                    @if($resultStatus === 'Pass')
                                        <span
                                            class="status-badge status-pass"
                                        >
                                            <i
                                                class="fa-solid
                                                fa-circle-check"
                                            ></i>
                                            Pass
                                        </span>

                                    @elseif($resultStatus === 'Fail')
                                        <span
                                            class="status-badge status-fail"
                                        >
                                            <i
                                                class="fa-solid
                                                fa-circle-xmark"
                                            ></i>
                                            Fail
                                        </span>

                                    @else
                                        <span
                                            class="status-badge
                                            status-pending"
                                        >
                                            <i
                                                class="fa-solid
                                                fa-clock"
                                            ></i>
                                            Pending
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <a
                                        href="{{ route(
                                            'results.show',
                                            [
                                                'exam' => $selectedExamId,
                                                'student' => $student->id,
                                            ]
                                        ) }}"
                                        class="btn-view-result"
                                    >
                                        <i class="fa-solid fa-eye"></i>
                                        View Result
                                    </a>
                                </td>
                            </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($students->hasPages())
                <div class="pagination-wrapper">
                    {{ $students->links() }}
                </div>
            @endif

        @else

            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fa-solid fa-folder-open"></i>
                </div>

                <h4>No Results Found</h4>

                <p>
                    No students with marks were found for the selected exam,
                    class or search keyword. Check the filters or enter marks
                    first.
                </p>
            </div>

        @endif

    </div>
</div>

@endsection