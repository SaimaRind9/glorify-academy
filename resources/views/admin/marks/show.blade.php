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
                Marks Details
            </h2>

            <p class="page-description mb-0">
                View complete examination marks and result information.
            </p>

        </div>

        <div class="header-actions">

            <a href="{{ route('marks.edit', $mark->id) }}"
               class="btn btn-warning edit-btn">

                <i class="fas fa-pen me-2"></i>
                Edit Marks

            </a>

            <a href="{{ route('marks.index') }}"
               class="btn btn-outline-secondary back-btn">

                <i class="fas fa-arrow-left me-2"></i>
                Back to Marks

            </a>

        </div>

    </div>


    <div class="row g-4">

        {{-- Student Information --}}
        <div class="col-xl-4 col-lg-5">

            <div class="profile-card">

                <div class="profile-card-header">

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


                <div class="profile-card-body">

                    <div class="profile-detail">

                        <div class="detail-icon">

                            <i class="fas fa-school"></i>

                        </div>

                        <div>

                            <span class="detail-label">
                                Class
                            </span>

                            <strong class="detail-value">

                                {{ optional($mark->classRoom)->class_name ?? 'N/A' }}

                            </strong>

                        </div>

                    </div>


                    <div class="profile-detail">

                        <div class="detail-icon">

                            <i class="fas fa-book-open"></i>

                        </div>

                        <div>

                            <span class="detail-label">
                                Subject
                            </span>

                            <strong class="detail-value">

                                {{ optional($mark->subject)->subject_name ?? 'N/A' }}

                            </strong>

                        </div>

                    </div>


                    <div class="profile-detail">

                        <div class="detail-icon">

                            <i class="fas fa-file-lines"></i>

                        </div>

                        <div>

                            <span class="detail-label">
                                Exam
                            </span>

                            <strong class="detail-value">

                                {{ optional($mark->exam)->exam_name ?? 'N/A' }}

                            </strong>

                        </div>

                    </div>


                    <div class="profile-detail">

                        <div class="detail-icon">

                            <i class="fas fa-calendar-days"></i>

                        </div>

                        <div>

                            <span class="detail-label">
                                Academic Session
                            </span>

                            <strong class="detail-value">

                                {{ optional($mark->exam)->session ?? 'N/A' }}

                            </strong>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Marks Information --}}
        <div class="col-xl-8 col-lg-7">

            <div class="details-card">

                <div class="details-card-header">

                    <div class="header-icon">

                        <i class="fas fa-chart-column"></i>

                    </div>

                    <div>

                        <h5 class="mb-1">
                            Examination Performance
                        </h5>

                        <p class="mb-0">
                            Marks, grade, percentage and result summary.
                        </p>

                    </div>

                </div>


                <div class="details-card-body">

                    <div class="row g-4">

                        {{-- Total Marks --}}
                        <div class="col-xl-4 col-md-6">

                            <div class="result-card">

                                <div class="result-card-icon total-icon">

                                    <i class="fas fa-bullseye"></i>

                                </div>

                                <div>

                                    <p class="result-label mb-1">
                                        Total Marks
                                    </p>

                                    <h3 class="result-value mb-0">

                                        {{ number_format((float) $mark->total_marks, 2) }}

                                    </h3>

                                </div>

                            </div>

                        </div>


                        {{-- Obtained Marks --}}
                        <div class="col-xl-4 col-md-6">

                            <div class="result-card">

                                <div class="result-card-icon obtained-icon">

                                    <i class="fas fa-star"></i>

                                </div>

                                <div>

                                    <p class="result-label mb-1">
                                        Obtained Marks
                                    </p>

                                    <h3 class="result-value mb-0">

                                        @if($mark->is_absent)

                                            Absent

                                        @elseif($mark->obtained_marks !== null)

                                            {{ number_format((float) $mark->obtained_marks, 2) }}

                                        @else

                                            Pending

                                        @endif

                                    </h3>

                                </div>

                            </div>

                        </div>


                        {{-- Passing Marks --}}
                        <div class="col-xl-4 col-md-6">

                            <div class="result-card">

                                <div class="result-card-icon passing-icon">

                                    <i class="fas fa-flag-checkered"></i>

                                </div>

                                <div>

                                    <p class="result-label mb-1">
                                        Passing Marks
                                    </p>

                                    <h3 class="result-value mb-0">

                                        {{ number_format((float) $mark->passing_marks, 2) }}

                                    </h3>

                                </div>

                            </div>

                        </div>


                        {{-- Percentage --}}
                        <div class="col-xl-4 col-md-6">

                            <div class="result-card">

                                <div class="result-card-icon percentage-icon">

                                    <i class="fas fa-percent"></i>

                                </div>

                                <div>

                                    <p class="result-label mb-1">
                                        Percentage
                                    </p>

                                    <h3 class="result-value mb-0">

                                        @if(!$mark->is_absent && $mark->obtained_marks !== null)

                                            {{ number_format((float) $mark->percentage, 2) }}%

                                        @else

                                            —

                                        @endif

                                    </h3>

                                </div>

                            </div>

                        </div>


                        {{-- Grade --}}
                        <div class="col-xl-4 col-md-6">

                            <div class="result-card">

                                <div class="result-card-icon grade-icon">

                                    <i class="fas fa-award"></i>

                                </div>

                                <div>

                                    <p class="result-label mb-1">
                                        Grade
                                    </p>

                                    <h3 class="result-value mb-0">

                                        {{ $mark->grade ?? '—' }}

                                    </h3>

                                </div>

                            </div>

                        </div>


                        {{-- Result --}}
                        <div class="col-xl-4 col-md-6">

                            <div class="result-card">

                                <div class="result-card-icon status-icon">

                                    <i class="fas fa-square-poll-vertical"></i>

                                </div>

                                <div>

                                    <p class="result-label mb-1">
                                        Result
                                    </p>

                                    <div>

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

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- Additional Information --}}
                    <div class="additional-section mt-4">

                        <div class="section-heading mb-4">

                            <div class="section-icon">

                                <i class="fas fa-circle-info"></i>

                            </div>

                            <div>

                                <h6 class="mb-1">
                                    Additional Information
                                </h6>

                                <p class="mb-0">
                                    Record status, attendance and remarks.
                                </p>

                            </div>

                        </div>


                        <div class="row g-4">

                            {{-- Attendance --}}
                            <div class="col-md-4">

                                <div class="information-box">

                                    <span class="information-label">
                                        Attendance Status
                                    </span>

                                    <div class="information-value">

                                        @if($mark->is_absent)

                                            <span class="status-pill absent-pill">

                                                <i class="fas fa-user-xmark me-1"></i>
                                                Absent

                                            </span>

                                        @else

                                            <span class="status-pill present-pill">

                                                <i class="fas fa-user-check me-1"></i>
                                                Present

                                            </span>

                                        @endif

                                    </div>

                                </div>

                            </div>


                            {{-- Record Status --}}
                            <div class="col-md-4">

                                <div class="information-box">

                                    <span class="information-label">
                                        Record Status
                                    </span>

                                    <div class="information-value">

                                        @if($mark->status)

                                            <span class="status-pill active-pill">

                                                <i class="fas fa-circle-check me-1"></i>
                                                Active

                                            </span>

                                        @else

                                            <span class="status-pill inactive-pill">

                                                <i class="fas fa-circle-minus me-1"></i>
                                                Inactive

                                            </span>

                                        @endif

                                    </div>

                                </div>

                            </div>


                            {{-- Entry Date --}}
                            <div class="col-md-4">

                                <div class="information-box">

                                    <span class="information-label">
                                        Entry Date
                                    </span>

                                    <strong class="information-text">

                                        {{ optional($mark->created_at)->format('d M Y') ?? 'N/A' }}

                                    </strong>

                                </div>

                            </div>


                            {{-- Remarks --}}
                            <div class="col-12">

                                <div class="remarks-box">

                                    <div class="remarks-heading">

                                        <i class="fas fa-message me-2"></i>
                                        Remarks

                                    </div>

                                    <p class="remarks-text mb-0">

                                        {{ $mark->remarks ?: 'No remarks have been added for this marks record.' }}

                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

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
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .edit-btn,
    .back-btn {
        min-height: 44px;
        border-radius: 10px;
        font-weight: 650;
    }

    .profile-card,
    .details-card {
        height: 100%;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 6px 24px rgba(15, 23, 42, 0.06);
    }

    .profile-card-header {
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
        justify-content: center;
        align-items: center;
        font-size: 31px;
        font-weight: 750;
        box-shadow: 0 10px 24px rgba(79, 70, 229, 0.22);
    }

    .student-name {
        color: #111827;
        font-size: 22px;
        font-weight: 750;
    }

    .student-id {
        color: #6b7280;
        font-size: 13px;
    }

    .profile-card-body {
        padding: 24px;
    }

    .profile-detail {
        display: flex;
        align-items: center;
        gap: 13px;
        padding: 15px 0;
        border-bottom: 1px solid #eef2f7;
    }

    .profile-detail:last-child {
        border-bottom: none;
    }

    .detail-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: #eef2ff;
        color: #4f46e5;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .detail-label {
        display: block;
        color: #8490a2;
        font-size: 11px;
        font-weight: 650;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        margin-bottom: 3px;
    }

    .detail-value {
        display: block;
        color: #1f2937;
        font-size: 14px;
        font-weight: 700;
    }

    .details-card-header {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 22px 24px;
        border-bottom: 1px solid #e5e7eb;
        background: #fbfcff;
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

    .details-card-header h5 {
        color: #1f2937;
        font-size: 18px;
        font-weight: 700;
    }

    .details-card-header p {
        color: #6b7280;
        font-size: 13px;
    }

    .details-card-body {
        padding: 25px 24px;
    }

    .result-card {
        height: 100%;
        padding: 20px;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        background: #ffffff;
        display: flex;
        align-items: center;
        gap: 14px;
        transition: 0.2s ease;
    }

    .result-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 22px rgba(15, 23, 42, 0.07);
    }

    .result-card-icon {
        width: 48px;
        height: 48px;
        border-radius: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .total-icon {
        background: #eef2ff;
        color: #4f46e5;
    }

    .obtained-icon {
        background: #fff7ed;
        color: #ea580c;
    }

    .passing-icon {
        background: #ecfdf5;
        color: #059669;
    }

    .percentage-icon {
        background: #eff6ff;
        color: #2563eb;
    }

    .grade-icon {
        background: #f5f3ff;
        color: #7c3aed;
    }

    .status-icon {
        background: #f8fafc;
        color: #475569;
    }

    .result-label {
        color: #6b7280;
        font-size: 12px;
        font-weight: 650;
    }

    .result-value {
        color: #111827;
        font-size: 21px;
        font-weight: 750;
    }

    .result-badge,
    .status-pill {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 8px 11px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 750;
    }

    .result-pass,
    .present-pill,
    .active-pill {
        background: #dcfce7;
        color: #15803d;
    }

    .result-fail {
        background: #fee2e2;
        color: #b91c1c;
    }

    .result-absent,
    .absent-pill {
        background: #ffedd5;
        color: #c2410c;
    }

    .result-pending,
    .inactive-pill {
        background: #f1f5f9;
        color: #64748b;
    }

    .additional-section {
        padding: 22px;
        border: 1px solid #e5e7eb;
        border-radius: 15px;
        background: #f8fafc;
    }

    .section-heading {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .section-icon {
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

    .section-heading h6 {
        color: #1f2937;
        font-size: 15px;
        font-weight: 700;
    }

    .section-heading p {
        color: #6b7280;
        font-size: 12px;
    }

    .information-box {
        height: 100%;
        padding: 16px;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
    }

    .information-label {
        display: block;
        color: #8490a2;
        font-size: 11px;
        font-weight: 650;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        margin-bottom: 9px;
    }

    .information-value {
        min-height: 30px;
        display: flex;
        align-items: center;
    }

    .information-text {
        color: #1f2937;
        font-size: 14px;
        font-weight: 700;
    }

    .remarks-box {
        padding: 18px;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        background: #ffffff;
    }

    .remarks-heading {
        color: #374151;
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 9px;
    }

    .remarks-text {
        color: #6b7280;
        font-size: 14px;
        line-height: 1.7;
    }

    @media (max-width: 767px) {

        .container-fluid {
            padding-left: 12px;
            padding-right: 12px;
        }

        .page-title {
            font-size: 25px;
        }

        .page-header,
        .header-actions {
            align-items: stretch;
        }

        .header-actions {
            width: 100%;
            flex-direction: column;
        }

        .header-actions .btn {
            width: 100%;
        }

        .profile-card-header,
        .profile-card-body,
        .details-card-header,
        .details-card-body {
            padding-left: 17px;
            padding-right: 17px;
        }

        .additional-section {
            padding: 16px;
        }

    }

</style>

@endsection