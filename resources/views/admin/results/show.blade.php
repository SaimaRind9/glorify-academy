@extends('layouts.admin')

@section('content')

@php
    $studentName = $student->name ?? 'Student';

    $studentInitials = collect(
        preg_split('/\s+/', trim($studentName))
    )
    ->filter()
    ->take(2)
    ->map(function ($word) {
        return strtoupper(substr($word, 0, 1));
    })
    ->implode('');

    $examName = $exam->exam_name
        ?? $exam->name
        ?? 'Examination';

    $className = $classRoom->class_name
        ?? $student->classRoom->class_name
        ?? 'Not Assigned';

    $fatherName = $student->father_name
        ?? $student->guardian_name
        ?? 'Not Available';

    $sessionName = $exam->academic_session
        ?? $exam->session
        ?? date('Y');

    $resultStatus = $summary['result_status'] ?? 'Pending';

    $percentage = (float) ($summary['percentage'] ?? 0);

    $grade = $summary['grade'] ?? 'N/A';

    $photoPath = $student->photo
        ?? $student->image
        ?? $student->profile_photo
        ?? null;

    $positionText = 'N/A';

    if ($position) {
        $lastDigit = $position % 10;
        $lastTwoDigits = $position % 100;

        if ($lastTwoDigits >= 11 && $lastTwoDigits <= 13) {
            $suffix = 'th';
        } elseif ($lastDigit === 1) {
            $suffix = 'st';
        } elseif ($lastDigit === 2) {
            $suffix = 'nd';
        } elseif ($lastDigit === 3) {
            $suffix = 'rd';
        } else {
            $suffix = 'th';
        }

        $positionText = $position . $suffix;
    }
@endphp

<style>
    .result-page-wrapper {
        min-height: 100vh;
        padding: 24px;
        background: #f4f7fb;
    }

    .result-action-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-bottom: 20px;
    }

    .result-action-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .page-heading-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #ffffff;
        background: linear-gradient(135deg, #7c3aed, #4f46e5);
        box-shadow: 0 8px 20px rgba(79, 70, 229, 0.25);
        font-size: 20px;
    }

    .page-heading-text h2 {
        margin: 0 0 4px;
        color: #172033;
        font-size: 24px;
        font-weight: 800;
    }

    .page-heading-text p {
        margin: 0;
        color: #7a8499;
        font-size: 13px;
    }

    .result-action-buttons {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .result-btn {
        height: 44px;
        padding: 0 17px;
        border: none;
        border-radius: 11px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: 0.22s ease;
    }

    .result-btn-back {
        color: #475569;
        background: #ffffff;
        border: 1px solid #dfe5ee;
    }

    .result-btn-back:hover {
        color: #273449;
        background: #f8fafc;
        transform: translateY(-1px);
    }

    .result-btn-print {
        color: #ffffff;
        background: linear-gradient(135deg, #7c3aed, #4f46e5);
        box-shadow: 0 8px 20px rgba(79, 70, 229, 0.22);
    }

    .result-btn-print:hover {
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 10px 24px rgba(79, 70, 229, 0.3);
    }

    .report-card-shell {
        max-width: 1100px;
        margin: 0 auto;
        padding: 16px;
        border-radius: 24px;
        background: #e9edf5;
    }

    .report-card {
        position: relative;
        overflow: hidden;
        padding: 34px;
        border: 2px solid #40268c;
        border-radius: 18px;
        background: #ffffff;
        box-shadow: 0 16px 40px rgba(20, 27, 45, 0.09);
    }

    .report-card::before {
        content: "";
        position: absolute;
        top: -80px;
        right: -80px;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: rgba(124, 58, 237, 0.06);
    }

    .report-card::after {
        content: "";
        position: absolute;
        bottom: -100px;
        left: -100px;
        width: 260px;
        height: 260px;
        border-radius: 50%;
        background: rgba(79, 70, 229, 0.05);
    }

    .report-content {
        position: relative;
        z-index: 2;
    }

    .academy-header {
        display: grid;
        grid-template-columns: 110px 1fr 110px;
        align-items: center;
        gap: 20px;
        padding-bottom: 24px;
        border-bottom: 3px double #5b21b6;
    }

    .academy-logo-box {
        width: 100px;
        height: 100px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        color: #ffffff;
        background: linear-gradient(135deg, #7c3aed, #4f46e5);
        box-shadow: 0 8px 20px rgba(79, 70, 229, 0.18);
        font-size: 38px;
    }

    .academy-logo-box img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: 8px;
        background: #ffffff;
    }

    .academy-main-title {
        text-align: center;
    }

    .academy-main-title h1 {
        margin: 0;
        color: #4c1d95;
        font-family: Georgia, 'Times New Roman', serif;
        font-size: 34px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 1.2px;
    }

    .academy-main-title .academy-subtitle {
        margin-top: 7px;
        color: #687286;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: 0.3px;
    }

    .report-title {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-top: 12px;
        padding: 8px 20px;
        border-radius: 30px;
        color: #ffffff;
        background: linear-gradient(135deg, #7c3aed, #4f46e5);
        font-size: 14px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .student-photo-box {
        width: 100px;
        height: 110px;
        border: 3px solid #ede9fe;
        border-radius: 16px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        background: linear-gradient(135deg, #8b5cf6, #4f46e5);
        font-size: 28px;
        font-weight: 800;
    }

    .student-photo-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .result-meta-strip {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin: 22px 0;
        padding: 13px 18px;
        border-radius: 12px;
        color: #4c1d95;
        background: #f5f3ff;
        border: 1px solid #ddd6fe;
        font-size: 13px;
        font-weight: 700;
    }

    .result-meta-strip span {
        display: inline-flex;
        align-items: center;
        gap: 7px;
    }

    .student-details-card {
        margin-bottom: 24px;
        padding: 20px;
        border: 1px solid #e4e8f0;
        border-radius: 16px;
        background: #fbfcfe;
    }

    .section-heading {
        display: flex;
        align-items: center;
        gap: 9px;
        margin-bottom: 17px;
        color: #312e81;
        font-size: 16px;
        font-weight: 800;
    }

    .section-heading i {
        color: #7c3aed;
    }

    .student-details-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 14px;
    }

    .detail-item {
        padding: 13px 14px;
        border-radius: 11px;
        background: #ffffff;
        border: 1px solid #e8ebf1;
    }

    .detail-label {
        display: block;
        margin-bottom: 5px;
        color: #8b95a7;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.6px;
    }

    .detail-value {
        color: #253047;
        font-size: 13px;
        font-weight: 800;
        word-break: break-word;
    }

    .marks-section {
        margin-top: 22px;
    }

    .marks-table-wrapper {
        overflow-x: auto;
        border: 1px solid #dfe4ed;
        border-radius: 14px;
    }

    .marks-table {
        width: 100%;
        min-width: 820px;
        border-collapse: collapse;
        margin: 0;
    }

    .marks-table thead th {
        padding: 14px 12px;
        color: #ffffff;
        background: linear-gradient(135deg, #6d28d9, #4f46e5);
        text-align: center;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }

    .marks-table thead th:first-child {
        text-align: left;
    }

    .marks-table tbody td {
        padding: 14px 12px;
        border-bottom: 1px solid #e8ebf1;
        color: #3f495d;
        text-align: center;
        font-size: 13px;
    }

    .marks-table tbody td:first-child {
        text-align: left;
        font-weight: 800;
        color: #253047;
    }

    .marks-table tbody tr:nth-child(even) {
        background: #fafbff;
    }

    .marks-table tbody tr:last-child td {
        border-bottom: none;
    }

    .subject-name {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .subject-icon {
        width: 34px;
        height: 34px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        color: #6d28d9;
        background: #ede9fe;
    }

    .mark-number {
        font-weight: 800;
        color: #172033;
    }

    .absent-text {
        color: #dc2626;
        font-weight: 900;
    }

    .subject-grade {
        min-width: 38px;
        padding: 6px 9px;
        border-radius: 8px;
        display: inline-flex;
        justify-content: center;
        color: #5b21b6;
        background: #ede9fe;
        font-size: 12px;
        font-weight: 900;
    }

    .subject-status {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 800;
    }

    .subject-pass {
        color: #047857;
        background: #d1fae5;
    }

    .subject-fail {
        color: #b91c1c;
        background: #fee2e2;
    }

    .summary-section {
        display: grid;
        grid-template-columns: 1.4fr 0.8fr;
        gap: 20px;
        margin-top: 24px;
    }

    .summary-card {
        padding: 20px;
        border: 1px solid #e2e7f0;
        border-radius: 16px;
        background: #ffffff;
    }

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 12px;
    }

    .summary-item {
        padding: 15px;
        border-radius: 12px;
        background: #f8f9fc;
        border: 1px solid #e8ebf1;
        text-align: center;
    }

    .summary-item-label {
        display: block;
        margin-bottom: 7px;
        color: #808a9d;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .summary-item-value {
        color: #242d40;
        font-size: 18px;
        font-weight: 900;
    }

    .summary-item-value.purple {
        color: #6d28d9;
    }

    .summary-item-value.green {
        color: #059669;
    }

    .summary-item-value.red {
        color: #dc2626;
    }

    .result-overview-card {
        position: relative;
        overflow: hidden;
        padding: 22px;
        border-radius: 16px;
        color: #ffffff;
        background:
            {{ $resultStatus === 'Pass'
                ? 'linear-gradient(135deg, #059669, #10b981)'
                : 'linear-gradient(135deg, #dc2626, #ef4444)' }};
    }

    .result-overview-card::after {
        content: "";
        position: absolute;
        right: -30px;
        bottom: -30px;
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.13);
    }

    .overview-label {
        position: relative;
        z-index: 2;
        margin-bottom: 8px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        opacity: 0.9;
    }

    .overview-status {
        position: relative;
        z-index: 2;
        margin-bottom: 14px;
        font-size: 30px;
        font-weight: 900;
    }

    .overview-details {
        position: relative;
        z-index: 2;
        display: flex;
        justify-content: space-between;
        gap: 10px;
        padding-top: 13px;
        border-top: 1px solid rgba(255, 255, 255, 0.25);
    }

    .overview-details div {
        flex: 1;
    }

    .overview-details span {
        display: block;
    }

    .overview-small-label {
        margin-bottom: 3px;
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        opacity: 0.8;
    }

    .overview-small-value {
        font-size: 16px;
        font-weight: 900;
    }

    .remarks-box {
        margin-top: 22px;
        padding: 18px;
        border-left: 5px solid #7c3aed;
        border-radius: 12px;
        background: #f8f7ff;
    }

    .remarks-title {
        margin-bottom: 7px;
        color: #4c1d95;
        font-size: 12px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .remarks-text {
        margin: 0;
        color: #596277;
        font-size: 13px;
        line-height: 1.7;
    }

    .signature-section {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 40px;
        margin-top: 60px;
        padding-top: 18px;
    }

    .signature-box {
        text-align: center;
    }

    .signature-line {
        width: 100%;
        border-top: 1px solid #495267;
        margin-bottom: 9px;
    }

    .signature-title {
        color: #333d51;
        font-size: 12px;
        font-weight: 800;
    }

    .report-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-top: 35px;
        padding-top: 16px;
        border-top: 1px dashed #cdd3de;
        color: #8a93a5;
        font-size: 10px;
    }

    .report-footer strong {
        color: #5b6476;
    }

    @media (max-width: 991px) {
        .student-details-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .summary-section {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 767px) {
        .result-page-wrapper {
            padding: 12px;
        }

        .result-action-bar {
            align-items: flex-start;
            flex-direction: column;
        }

        .result-action-buttons {
            width: 100%;
        }

        .result-btn {
            flex: 1;
        }

        .report-card-shell {
            padding: 8px;
        }

        .report-card {
            padding: 20px 14px;
        }

        .academy-header {
            grid-template-columns: 1fr;
            justify-items: center;
        }

        .academy-main-title h1 {
            font-size: 27px;
        }

        .student-details-grid {
            grid-template-columns: 1fr;
        }

        .summary-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .signature-section {
            grid-template-columns: 1fr;
            gap: 50px;
        }

        .result-meta-strip {
            align-items: flex-start;
            flex-direction: column;
        }

        .report-footer {
            align-items: flex-start;
            flex-direction: column;
        }
    }

    @media print {
        @page {
            size: A4;
            margin: 8mm;
        }

        body {
            background: #ffffff !important;
        }

        body * {
            visibility: hidden;
        }

        .report-card,
        .report-card * {
            visibility: visible;
        }

        .result-page-wrapper {
            min-height: auto;
            padding: 0 !important;
            background: #ffffff !important;
        }

        .result-action-bar,
        .sidebar,
        .navbar,
        .topbar,
        header,
        footer {
            display: none !important;
        }

        .report-card-shell {
            max-width: none;
            margin: 0;
            padding: 0;
            background: transparent;
        }

        .report-card {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            padding: 18px;
            border: 2px solid #40268c;
            border-radius: 0;
            box-shadow: none;
        }

        .academy-header {
            grid-template-columns: 90px 1fr 90px;
            gap: 12px;
            padding-bottom: 15px;
        }

        .academy-logo-box {
            width: 80px;
            height: 80px;
        }

        .student-photo-box {
            width: 80px;
            height: 88px;
        }

        .academy-main-title h1 {
            font-size: 27px;
        }

        .result-meta-strip {
            margin: 14px 0;
            padding: 9px 12px;
        }

        .student-details-card {
            margin-bottom: 15px;
            padding: 13px;
        }

        .student-details-grid {
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 8px;
        }

        .detail-item {
            padding: 8px;
        }

        .marks-table thead th,
        .marks-table tbody td {
            padding: 8px 7px;
            font-size: 10px;
        }

        .summary-section {
            grid-template-columns: 1.4fr 0.8fr;
            gap: 12px;
            margin-top: 15px;
        }

        .summary-card,
        .result-overview-card {
            padding: 13px;
        }

        .summary-item {
            padding: 9px;
        }

        .signature-section {
            margin-top: 38px;
        }

        .remarks-box {
            margin-top: 14px;
            padding: 11px;
        }

        .report-footer {
            margin-top: 22px;
        }

        .marks-table-wrapper {
            overflow: visible;
        }

        .marks-table {
            min-width: 0;
        }
    }
</style>

<div class="result-page-wrapper">

    {{-- Action Bar --}}
    <div class="result-action-bar">
        <div class="result-action-left">
            <div class="page-heading-icon">
                <i class="fa-solid fa-file-lines"></i>
            </div>

            <div class="page-heading-text">
                <h2>Student Result Card</h2>
                <p>
                    View and print the complete academic result report.
                </p>
            </div>
        </div>

        <div class="result-action-buttons">
            <a
                href="{{ route('results.index', [
                    'exam_id' => $exam->id,
                    'class_room_id' => $classRoom->id ?? null
                ]) }}"
                class="result-btn result-btn-back"
            >
                <i class="fa-solid fa-arrow-left"></i>
                Back
            </a>

            <button
                type="button"
                class="result-btn result-btn-print"
                onclick="window.print()"
            >
                <i class="fa-solid fa-print"></i>
                Print Result
            </button>
        </div>
    </div>

    <div class="report-card-shell">
        <div class="report-card">
            <div class="report-content">

                {{-- Academy Header --}}
                <div class="academy-header">

                    <div class="academy-logo-box">
                        @if(file_exists(public_path('images/logo.jpeg')))
                            <img
                                src="{{ asset('images/logo.jpeg') }}"
                                alt="The Glorify Academy Logo"
                            >
                        @else
                            <i class="fa-solid fa-graduation-cap"></i>
                        @endif
                    </div>

                    <div class="academy-main-title">
                        <h1>The Glorify Academy</h1>

                        <div class="academy-subtitle">
                            Excellence in Education, Character and Growth
                        </div>

                        <div class="report-title">
                            <i class="fa-solid fa-award"></i>
                            Academic Result Card
                        </div>
                    </div>

                    <div class="student-photo-box">
                        @if($photoPath)
                            <img
                                src="{{ asset('storage/' . $photoPath) }}"
                                alt="{{ $studentName }}"
                            >
                        @else
                            {{ $studentInitials ?: 'ST' }}
                        @endif
                    </div>

                </div>

                {{-- Meta Strip --}}
                <div class="result-meta-strip">
                    <span>
                        <i class="fa-solid fa-pen-to-square"></i>
                        Exam: {{ $examName }}
                    </span>

                    <span>
                        <i class="fa-solid fa-school"></i>
                        Class: {{ $className }}
                    </span>

                    <span>
                        <i class="fa-solid fa-calendar-days"></i>
                        Session: {{ $sessionName }}
                    </span>
                </div>

                {{-- Student Details --}}
                <div class="student-details-card">
                    <div class="section-heading">
                        <i class="fa-solid fa-user-graduate"></i>
                        Student Information
                    </div>

                    <div class="student-details-grid">

                        <div class="detail-item">
                            <span class="detail-label">Student Name</span>
                            <span class="detail-value">
                                {{ $studentName }}
                            </span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">Student ID</span>
                            <span class="detail-value">
                                {{ $student->student_id ?? 'N/A' }}
                            </span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">Father Name</span>
                            <span class="detail-value">
                                {{ $fatherName }}
                            </span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">Class</span>
                            <span class="detail-value">
                                {{ $className }}
                            </span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">Gender</span>
                            <span class="detail-value">
                                {{ $student->gender ?? 'N/A' }}
                            </span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">Exam</span>
                            <span class="detail-value">
                                {{ $examName }}
                            </span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">Academic Session</span>
                            <span class="detail-value">
                                {{ $sessionName }}
                            </span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">Position</span>
                            <span class="detail-value">
                                {{ $positionText }}
                            </span>
                        </div>

                    </div>
                </div>

                {{-- Marks Table --}}
                <div class="marks-section">
                    <div class="section-heading">
                        <i class="fa-solid fa-chart-column"></i>
                        Subject Wise Performance
                    </div>

                    <div class="marks-table-wrapper">
                        <table class="marks-table">
                            <thead>
                                <tr>
                                    <th>Subject</th>
                                    <th>Total Marks</th>
                                    <th>Passing Marks</th>
                                    <th>Obtained Marks</th>
                                    <th>Percentage</th>
                                    <th>Grade</th>
                                    <th>Result</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($marks as $mark)

                                    @php
                                        $subjectPercentage =
                                            $mark->total_marks > 0
                                            ? (
                                                (
                                                    $mark->obtained_marks
                                                    ?? 0
                                                )
                                                /
                                                $mark->total_marks
                                            ) * 100
                                            : 0;

                                        $subjectResult =
                                            $mark->is_absent
                                            ? 'Fail'
                                            : ($mark->result_status
                                                ?? 'Pending');
                                    @endphp

                                    <tr>
                                        <td>
                                            <div class="subject-name">
                                                <div class="subject-icon">
                                                    <i
                                                        class="fa-solid
                                                        fa-book-open"
                                                    ></i>
                                                </div>

                                                <span>
                                                    {{
                                                        $mark->subject
                                                            ->subject_name
                                                        ?? 'Subject'
                                                    }}
                                                </span>
                                            </div>
                                        </td>

                                        <td>
                                            <span class="mark-number">
                                                {{
                                                    number_format(
                                                        $mark->total_marks,
                                                        2
                                                    )
                                                }}
                                            </span>
                                        </td>

                                        <td>
                                            {{
                                                number_format(
                                                    $mark->passing_marks,
                                                    2
                                                )
                                            }}
                                        </td>

                                        <td>
                                            @if($mark->is_absent)
                                                <span class="absent-text">
                                                    Absent
                                                </span>
                                            @else
                                                <span class="mark-number">
                                                    {{
                                                        number_format(
                                                            $mark
                                                                ->obtained_marks,
                                                            2
                                                        )
                                                    }}
                                                </span>
                                            @endif
                                        </td>

                                        <td>
                                            @if($mark->is_absent)
                                                0.00%
                                            @else
                                                {{
                                                    number_format(
                                                        $subjectPercentage,
                                                        2
                                                    )
                                                }}%
                                            @endif
                                        </td>

                                        <td>
                                            <span class="subject-grade">
                                                {{
                                                    $mark->is_absent
                                                    ? 'F'
                                                    : ($mark->grade ?? 'N/A')
                                                }}
                                            </span>
                                        </td>

                                        <td>
                                            @if($subjectResult === 'Pass')
                                                <span
                                                    class="subject-status
                                                    subject-pass"
                                                >
                                                    <i
                                                        class="fa-solid
                                                        fa-circle-check"
                                                    ></i>
                                                    Pass
                                                </span>
                                            @else
                                                <span
                                                    class="subject-status
                                                    subject-fail"
                                                >
                                                    <i
                                                        class="fa-solid
                                                        fa-circle-xmark"
                                                    ></i>
                                                    Fail
                                                </span>
                                            @endif
                                        </td>

                                        <td>
                                            {{
                                                $mark->remarks
                                                ?: (
                                                    $mark->is_absent
                                                    ? 'Absent'
                                                    : '-'
                                                )
                                            }}
                                        </td>
                                    </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Result Summary --}}
                <div class="summary-section">

                    <div class="summary-card">
                        <div class="section-heading">
                            <i class="fa-solid fa-square-poll-vertical"></i>
                            Result Summary
                        </div>

                        <div class="summary-grid">

                            <div class="summary-item">
                                <span class="summary-item-label">
                                    Total Subjects
                                </span>

                                <span class="summary-item-value">
                                    {{
                                        $summary['total_subjects']
                                        ?? 0
                                    }}
                                </span>
                            </div>

                            <div class="summary-item">
                                <span class="summary-item-label">
                                    Total Marks
                                </span>

                                <span class="summary-item-value">
                                    {{
                                        number_format(
                                            $summary['total_marks'] ?? 0,
                                            2
                                        )
                                    }}
                                </span>
                            </div>

                            <div class="summary-item">
                                <span class="summary-item-label">
                                    Obtained Marks
                                </span>

                                <span
                                    class="summary-item-value purple"
                                >
                                    {{
                                        number_format(
                                            $summary['obtained_marks'] ?? 0,
                                            2
                                        )
                                    }}
                                </span>
                            </div>

                            <div class="summary-item">
                                <span class="summary-item-label">
                                    Percentage
                                </span>

                                <span
                                    class="summary-item-value purple"
                                >
                                    {{
                                        number_format(
                                            $percentage,
                                            2
                                        )
                                    }}%
                                </span>
                            </div>

                            <div class="summary-item">
                                <span class="summary-item-label">
                                    Passed Subjects
                                </span>

                                <span
                                    class="summary-item-value green"
                                >
                                    {{
                                        $summary['passed_subjects']
                                        ?? 0
                                    }}
                                </span>
                            </div>

                            <div class="summary-item">
                                <span class="summary-item-label">
                                    Failed / Absent
                                </span>

                                <span
                                    class="summary-item-value red"
                                >
                                    {{
                                        (
                                            $summary['failed_subjects']
                                            ?? 0
                                        )
                                        +
                                        (
                                            $summary['absent_subjects']
                                            ?? 0
                                        )
                                    }}
                                </span>
                            </div>

                        </div>
                    </div>

                    <div class="result-overview-card">
                        <div class="overview-label">
                            Overall Result
                        </div>

                        <div class="overview-status">
                            {{ strtoupper($resultStatus) }}
                        </div>

                        <div class="overview-details">

                            <div>
                                <span class="overview-small-label">
                                    Grade
                                </span>

                                <span class="overview-small-value">
                                    {{ $grade }}
                                </span>
                            </div>

                            <div>
                                <span class="overview-small-label">
                                    Percentage
                                </span>

                                <span class="overview-small-value">
                                    {{
                                        number_format(
                                            $percentage,
                                            2
                                        )
                                    }}%
                                </span>
                            </div>

                            <div>
                                <span class="overview-small-label">
                                    Position
                                </span>

                                <span class="overview-small-value">
                                    {{ $positionText }}
                                </span>
                            </div>

                        </div>
                    </div>

                </div>

                {{-- Remarks --}}
                <div class="remarks-box">
                    <div class="remarks-title">
                        Teacher's Remarks
                    </div>

                    <p class="remarks-text">
                        @if($resultStatus === 'Pass' && $percentage >= 80)
                            Excellent performance. Keep working hard and
                            continue achieving outstanding academic success.
                        @elseif($resultStatus === 'Pass' && $percentage >= 60)
                            Good performance. With consistent effort, the
                            student can achieve even better results.
                        @elseif($resultStatus === 'Pass')
                            Satisfactory performance. More practice and
                            regular study are recommended.
                        @else
                            The student needs additional attention, regular
                            practice and improvement in weak subjects.
                        @endif
                    </p>
                </div>

                {{-- Signatures --}}
                <div class="signature-section">

                    <div class="signature-box">
                        <div class="signature-line"></div>
                        <div class="signature-title">
                            Class Teacher
                        </div>
                    </div>

                    <div class="signature-box">
                        <div class="signature-line"></div>
                        <div class="signature-title">
                            Parent / Guardian
                        </div>
                    </div>

                    <div class="signature-box">
                        <div class="signature-line"></div>
                        <div class="signature-title">
                            Principal
                        </div>
                    </div>

                </div>

                {{-- Footer --}}
                <div class="report-footer">
                    <span>
                        <strong>Glorify Academy</strong>
                        — Academic Result Management System
                    </span>

                    <span>
                        Generated on:
                        {{ now()->format('d M Y, h:i A') }}
                    </span>
                </div>

            </div>
        </div>
    </div>

</div>

@endsection