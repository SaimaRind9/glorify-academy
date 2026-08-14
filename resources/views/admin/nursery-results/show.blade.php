@extends('layouts.admin')

@section('title', 'Nursery Result Card')

@section('content')

@php
    $firstActivity = $activities->first();

    $exam = $firstActivity?->exam;
    $classRoom = $firstActivity?->classRoom;

    $remarks = $activities
        ->pluck('remarks')
        ->filter()
        ->first();

    $starMap = [
        'Excellent' => '★★★★★',
        'Very Good' => '★★★★☆',
        'Good' => '★★★☆☆',
        'Satisfactory' => '★★☆☆☆',
        'Needs Improvement' => '★☆☆☆☆',
    ];

    $performanceClass = match($overall) {
        'Excellent' => 'performance-excellent',
        'Very Good' => 'performance-very-good',
        'Good' => 'performance-good',
        'Satisfactory' => 'performance-satisfactory',
        default => 'performance-improvement',
    };

    $fatherName =
        $student->father_name
        ?? $student->parent_name
        ?? $student->guardian_name
        ?? 'N/A';

    $rollNumber =
        $student->roll_number
        ?? $student->roll_no
        ?? 'N/A';

    $sessionName =
        $exam->session
        ?? $exam->academic_session
        ?? $exam->session_name
        ?? date('Y');

    $examName =
        $exam->exam_name
        ?? $exam->name
        ?? 'Assessment';

    $className =
        $classRoom->class_name
        ?? 'Nursery';
@endphp

<div class="container-fluid nursery-result-page">

    {{-- Screen Actions --}}
    <div class="result-actions no-print">

        <div>
            <h1 class="page-title">
                Nursery Activity Result Card
            </h1>

            <p class="page-subtitle">
                View and print the student's activity-based assessment.
            </p>
        </div>

        <div class="action-buttons">

            <a
                href="{{ route('nursery-assessments.index') }}"
                class="btn btn-outline-secondary"
            >
                <i class="fas fa-arrow-left me-1"></i>
                Back
            </a>

            <a
                href="{{ route('nursery-assessments.create', [
                    'exam_id' => $firstActivity->exam_id,
                    'class_room_id' => $firstActivity->class_room_id
                ]) }}"
                class="btn btn-outline-primary"
            >
                <i class="fas fa-edit me-1"></i>
                Edit
            </a>

            <button
                type="button"
                class="btn btn-primary"
                onclick="window.print()"
            >
                <i class="fas fa-print me-1"></i>
                Print Result
            </button>

        </div>

    </div>


    {{-- Result Card --}}
    <div class="result-card">

        {{-- Decorative Top Border --}}
        <div class="top-decoration">
            <span></span>
            <span></span>
            <span></span>
        </div>


        {{-- Academy Header --}}
        <header class="academy-header">

            <div class="logo-box">

                <img
                    src="{{ asset('images/logo.png') }}"
                    alt="Glorify Academy Logo"
                    class="academy-logo"
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                >

                <div class="logo-fallback">
                    GA
                </div>

            </div>

            <div class="academy-heading">

                <h1>
                    GLORIFY ACADEMY
                </h1>

                <p class="academy-tagline">
                    Learn, Grow and Shine
                </p>

                <div class="report-title">
                    Nursery Activity Assessment Report
                </div>

            </div>

            <div class="report-session">

                <span class="session-label">
                    Academic Session
                </span>

                <strong>
                    {{ $sessionName }}
                </strong>

            </div>

        </header>


        {{-- Student Information --}}
        <section class="student-information">

            <div class="section-heading">
                <span class="heading-icon">
                    <i class="fas fa-user-graduate"></i>
                </span>

                Student Information
            </div>

            <div class="student-info-grid">

                <div class="info-item info-wide">
                    <span class="info-label">
                        Student Name
                    </span>

                    <span class="info-value">
                        {{ $student->name }}
                    </span>
                </div>

                <div class="info-item">
                    <span class="info-label">
                        Student ID
                    </span>

                    <span class="info-value">
                        {{ $student->student_id ?? 'N/A' }}
                    </span>
                </div>

                <div class="info-item">
                    <span class="info-label">
                        Roll Number
                    </span>

                    <span class="info-value">
                        {{ $rollNumber }}
                    </span>
                </div>

                <div class="info-item info-wide">
                    <span class="info-label">
                        Father / Guardian
                    </span>

                    <span class="info-value">
                        {{ $fatherName }}
                    </span>
                </div>

                <div class="info-item">
                    <span class="info-label">
                        Class
                    </span>

                    <span class="info-value">
                        {{ $className }}
                    </span>
                </div>

                <div class="info-item">
                    <span class="info-label">
                        Examination
                    </span>

                    <span class="info-value">
                        {{ $examName }}
                    </span>
                </div>

            </div>

        </section>


        {{-- Assessment Table --}}
        <section class="assessment-section">

            <div class="section-heading">
                <span class="heading-icon">
                    <i class="fas fa-star"></i>
                </span>

                Activity Performance
            </div>

            <div class="assessment-table-wrapper">

                <table class="assessment-table">

                    <thead>
                        <tr>
                            <th class="serial-column">
                                S.No.
                            </th>

                            <th>
                                Activity
                            </th>

                            <th>
                                Performance Level
                            </th>

                            <th>
                                Star Rating
                            </th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($activities as $activity)

                            <tr>

                                <td class="serial-cell">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="activity-name">

                                    <span class="activity-icon">

                                        @switch(strtolower($activity->activityType->activity_name ?? ''))

                                            @case('english')
                                                <i class="fas fa-language"></i>
                                                @break

                                            @case('math')
                                                <i class="fas fa-calculator"></i>
                                                @break

                                            @case('drawing')
                                                <i class="fas fa-palette"></i>
                                                @break

                                            @case('writing')
                                                <i class="fas fa-pencil-alt"></i>
                                                @break

                                            @case('reading')
                                                <i class="fas fa-book-open"></i>
                                                @break

                                            @case('behaviour')
                                                <i class="fas fa-smile"></i>
                                                @break

                                            @case('confidence')
                                                <i class="fas fa-award"></i>
                                                @break

                                            @case('participation')
                                                <i class="fas fa-hands-helping"></i>
                                                @break

                                            @case('cleanliness')
                                                <i class="fas fa-sparkles"></i>
                                                @break

                                            @default
                                                <i class="fas fa-circle"></i>

                                        @endswitch

                                    </span>

                                    {{ $activity->activityType->activity_name ?? 'Activity' }}

                                </td>

                                <td>

                                    <span class="assessment-badge assessment-{{ \Illuminate\Support\Str::slug($activity->assessment) }}">

                                        {{ $activity->assessment }}

                                    </span>

                                </td>

                                <td class="stars-cell">

                                    {{ $starMap[$activity->assessment] ?? '☆☆☆☆☆' }}

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </section>


        {{-- Performance Summary --}}
        <section class="summary-section">

            <div class="overall-performance {{ $performanceClass }}">

                <div class="performance-icon">
                    <i class="fas fa-trophy"></i>
                </div>

                <div class="performance-content">

                    <span class="performance-label">
                        Overall Performance
                    </span>

                    <strong class="performance-value">
                        {{ $overall }}
                    </strong>

                    <span class="performance-stars">
                        {{ $stars }}
                    </span>

                </div>

            </div>


            <div class="assessment-key">

                <h4>
                    Assessment Key
                </h4>

                <div class="key-grid">

                    <div class="key-item">
                        <span class="key-stars">★★★★★</span>
                        <span>Excellent</span>
                    </div>

                    <div class="key-item">
                        <span class="key-stars">★★★★☆</span>
                        <span>Very Good</span>
                    </div>

                    <div class="key-item">
                        <span class="key-stars">★★★☆☆</span>
                        <span>Good</span>
                    </div>

                    <div class="key-item">
                        <span class="key-stars">★★☆☆☆</span>
                        <span>Satisfactory</span>
                    </div>

                    <div class="key-item">
                        <span class="key-stars">★☆☆☆☆</span>
                        <span>Needs Improvement</span>
                    </div>

                </div>

            </div>

        </section>


        {{-- Teacher Remarks --}}
        <section class="remarks-section">

            <div class="section-heading">
                <span class="heading-icon">
                    <i class="fas fa-comment-dots"></i>
                </span>

                Teacher's Remarks
            </div>

            <div class="remarks-box">

                @if($remarks)

                    {{ $remarks }}

                @else

                    {{ $student->name }} has shown positive participation in classroom activities.
                    Continued encouragement at home will support further development.

                @endif

            </div>

        </section>


        {{-- Appreciation Message --}}
        <section class="appreciation-message">

            <div class="appreciation-icon">
                <i class="fas fa-seedling"></i>
            </div>

            <div>
                <strong>
                    Keep Learning and Keep Growing!
                </strong>

                <p>
                    Every child develops at their own pace. We appreciate the student's
                    effort, confidence and participation throughout the term.
                </p>
            </div>

        </section>


        {{-- Signatures --}}
        <footer class="signature-section">

            <div class="signature-item">
                <div class="signature-line"></div>

                <span>
                    Class Teacher
                </span>
            </div>

            <div class="signature-item">
                <div class="signature-line"></div>

                <span>
                    Parent / Guardian
                </span>
            </div>

            <div class="signature-item">
                <div class="signature-line"></div>

                <span>
                    Principal
                </span>
            </div>

        </footer>


        {{-- Footer --}}
        <div class="report-footer">

            <span>
                Glorify Academy
            </span>

            <span>
                Nursery Activity Assessment
            </span>

            <span>
                Generated: {{ now()->format('d M Y') }}
            </span>

        </div>

    </div>

</div>

@endsection


@push('styles')

<style>
    :root {
        --primary: #174ea6;
        --primary-dark: #103875;
        --secondary: #f4b400;
        --accent: #20a464;
        --light-blue: #eef5ff;
        --light-yellow: #fff8df;
        --text-dark: #1f2937;
        --text-muted: #667085;
        --border-color: #dbe3ed;
    }

    .nursery-result-page {
        padding-bottom: 40px;
    }

    .result-actions {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 24px;
    }

    .page-title {
        margin: 0 0 5px;
        color: var(--text-dark);
        font-size: 28px;
        font-weight: 800;
    }

    .page-subtitle {
        margin: 0;
        color: var(--text-muted);
    }

    .action-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .result-card {
        width: 100%;
        max-width: 950px;
        margin: 0 auto;
        padding: 34px 42px 24px;
        position: relative;
        overflow: hidden;
        color: var(--text-dark);
        background: #ffffff;
        border: 1px solid #dfe6ef;
        border-radius: 18px;
        box-shadow: 0 14px 45px rgba(17, 40, 78, 0.12);
    }

    .result-card::before {
        content: "";
        position: absolute;
        top: -90px;
        right: -90px;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: rgba(244, 180, 0, 0.09);
    }

    .result-card::after {
        content: "";
        position: absolute;
        bottom: -110px;
        left: -100px;
        width: 250px;
        height: 250px;
        border-radius: 50%;
        background: rgba(23, 78, 166, 0.06);
    }

    .top-decoration {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        display: grid;
        grid-template-columns: 2fr 1fr 2fr;
        height: 8px;
    }

    .top-decoration span:nth-child(1) {
        background: var(--primary);
    }

    .top-decoration span:nth-child(2) {
        background: var(--secondary);
    }

    .top-decoration span:nth-child(3) {
        background: var(--accent);
    }

    .academy-header {
        position: relative;
        z-index: 1;
        display: grid;
        grid-template-columns: 110px 1fr 150px;
        align-items: center;
        gap: 20px;
        padding-bottom: 24px;
        border-bottom: 2px solid var(--primary);
    }

    .logo-box {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .academy-logo,
    .logo-fallback {
        width: 92px;
        height: 92px;
        object-fit: contain;
    }

    .logo-fallback {
        display: none;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: white;
        background: var(--primary);
        font-size: 31px;
        font-weight: 900;
        border: 6px solid var(--light-blue);
    }

    .academy-heading {
        text-align: center;
    }

    .academy-heading h1 {
        margin: 0;
        color: var(--primary-dark);
        font-size: 34px;
        font-weight: 900;
        letter-spacing: 1.3px;
    }

    .academy-tagline {
        margin: 4px 0 10px;
        color: var(--text-muted);
        font-size: 14px;
        letter-spacing: 1px;
    }

    .report-title {
        display: inline-block;
        padding: 7px 22px;
        color: white;
        background: var(--primary);
        border-radius: 50px;
        font-size: 15px;
        font-weight: 700;
        letter-spacing: 0.4px;
    }

    .report-session {
        padding: 13px 10px;
        text-align: center;
        background: var(--light-yellow);
        border: 1px solid #f4d975;
        border-radius: 12px;
    }

    .session-label {
        display: block;
        margin-bottom: 4px;
        color: var(--text-muted);
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .report-session strong {
        color: #8a6400;
        font-size: 16px;
    }

    .student-information,
    .assessment-section,
    .remarks-section {
        position: relative;
        z-index: 1;
        margin-top: 24px;
    }

    .section-heading {
        display: flex;
        align-items: center;
        gap: 9px;
        margin-bottom: 13px;
        color: var(--primary-dark);
        font-size: 17px;
        font-weight: 800;
    }

    .heading-icon {
        width: 31px;
        height: 31px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: white;
        background: var(--primary);
        border-radius: 50%;
        font-size: 13px;
    }

    .student-info-grid {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        overflow: hidden;
    }

    .info-item {
        min-height: 70px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 12px 16px;
        background: #ffffff;
        border-right: 1px solid var(--border-color);
        border-bottom: 1px solid var(--border-color);
    }

    .info-item:nth-child(3n) {
        border-right: none;
    }

    .info-item:nth-last-child(-n+3) {
        border-bottom: none;
    }

    .info-label {
        margin-bottom: 5px;
        color: var(--text-muted);
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }

    .info-value {
        color: var(--text-dark);
        font-size: 15px;
        font-weight: 700;
    }

    .assessment-table-wrapper {
        overflow: hidden;
        border: 1px solid var(--border-color);
        border-radius: 12px;
    }

    .assessment-table {
        width: 100%;
        border-collapse: collapse;
    }

    .assessment-table thead th {
        padding: 13px 15px;
        color: white;
        background: var(--primary);
        font-size: 12px;
        text-align: left;
        text-transform: uppercase;
        letter-spacing: 0.45px;
    }

    .assessment-table thead th:nth-child(3),
    .assessment-table thead th:nth-child(4) {
        text-align: center;
    }

    .assessment-table tbody td {
        padding: 12px 15px;
        border-bottom: 1px solid var(--border-color);
        font-size: 14px;
    }

    .assessment-table tbody tr:last-child td {
        border-bottom: none;
    }

    .assessment-table tbody tr:nth-child(even) {
        background: #f9fbfd;
    }

    .serial-column {
        width: 70px;
        text-align: center !important;
    }

    .serial-cell {
        text-align: center;
        font-weight: 700;
    }

    .activity-name {
        font-weight: 700;
    }

    .activity-icon {
        width: 29px;
        height: 29px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-right: 8px;
        color: var(--primary);
        background: var(--light-blue);
        border-radius: 50%;
        font-size: 12px;
    }

    .assessment-table tbody td:nth-child(3) {
        text-align: center;
    }

    .assessment-badge {
        display: inline-block;
        min-width: 125px;
        padding: 6px 12px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 800;
    }

    .assessment-excellent {
        color: #087443;
        background: #dff7eb;
    }

    .assessment-very-good {
        color: #174ea6;
        background: #e3eeff;
    }

    .assessment-good {
        color: #8a6500;
        background: #fff2bd;
    }

    .assessment-satisfactory {
        color: #9a4f00;
        background: #ffe8cf;
    }

    .assessment-needs-improvement {
        color: #a91d31;
        background: #ffe1e5;
    }

    .stars-cell {
        color: var(--secondary);
        text-align: center;
        white-space: nowrap;
        font-size: 19px !important;
        letter-spacing: 2px;
    }

    .summary-section {
        position: relative;
        z-index: 1;
        display: grid;
        grid-template-columns: 1fr 1.3fr;
        gap: 18px;
        margin-top: 24px;
    }

    .overall-performance {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 20px;
        border-radius: 14px;
        border: 1px solid transparent;
    }

    .performance-excellent {
        background: #e8f8f0;
        border-color: #a8dfc3;
    }

    .performance-very-good {
        background: #ebf3ff;
        border-color: #b6d1f7;
    }

    .performance-good {
        background: #fff8df;
        border-color: #f1d77a;
    }

    .performance-satisfactory {
        background: #fff0df;
        border-color: #f2c697;
    }

    .performance-improvement {
        background: #ffebee;
        border-color: #efb5bd;
    }

    .performance-icon {
        width: 61px;
        height: 61px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        background: var(--secondary);
        border-radius: 50%;
        font-size: 26px;
        box-shadow: 0 7px 16px rgba(244, 180, 0, 0.25);
    }

    .performance-content {
        display: flex;
        flex-direction: column;
    }

    .performance-label {
        color: var(--text-muted);
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .performance-value {
        margin: 2px 0;
        color: var(--primary-dark);
        font-size: 24px;
    }

    .performance-stars,
    .key-stars {
        color: var(--secondary);
        letter-spacing: 2px;
    }

    .performance-stars {
        font-size: 19px;
    }

    .assessment-key {
        padding: 16px 18px;
        background: #f8fafc;
        border: 1px solid var(--border-color);
        border-radius: 14px;
    }

    .assessment-key h4 {
        margin: 0 0 10px;
        color: var(--primary-dark);
        font-size: 15px;
        font-weight: 800;
    }

    .key-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 7px 15px;
    }

    .key-item {
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--text-muted);
        font-size: 11px;
    }

    .key-stars {
        min-width: 67px;
        font-size: 12px;
        white-space: nowrap;
    }

    .remarks-box {
        min-height: 80px;
        padding: 18px;
        color: #364152;
        background: #fffdf4;
        border: 1px dashed #d8bd5b;
        border-radius: 12px;
        font-size: 14px;
        line-height: 1.7;
    }

    .appreciation-message {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 14px;
        margin-top: 20px;
        padding: 15px 18px;
        background: var(--light-blue);
        border-left: 5px solid var(--primary);
        border-radius: 10px;
    }

    .appreciation-icon {
        width: 43px;
        height: 43px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        background: var(--accent);
        border-radius: 50%;
        font-size: 19px;
    }

    .appreciation-message strong {
        display: block;
        margin-bottom: 3px;
        color: var(--primary-dark);
    }

    .appreciation-message p {
        margin: 0;
        color: var(--text-muted);
        font-size: 12px;
        line-height: 1.5;
    }

    .signature-section {
        position: relative;
        z-index: 1;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 55px;
        margin-top: 58px;
    }

    .signature-item {
        text-align: center;
    }

    .signature-line {
        border-top: 1px solid #536273;
    }

    .signature-item span {
        display: block;
        margin-top: 7px;
        color: var(--text-muted);
        font-size: 12px;
        font-weight: 700;
    }

    .report-footer {
        position: relative;
        z-index: 1;
        display: flex;
        justify-content: space-between;
        gap: 15px;
        margin-top: 30px;
        padding-top: 12px;
        color: var(--text-muted);
        border-top: 1px solid var(--border-color);
        font-size: 10px;
    }

    @media (max-width: 900px) {
        .result-actions {
            align-items: flex-start;
            flex-direction: column;
        }

        .academy-header {
            grid-template-columns: 85px 1fr;
        }

        .report-session {
            grid-column: 1 / -1;
        }

        .academy-heading h1 {
            font-size: 27px;
        }

        .student-info-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .info-item:nth-child(3n) {
            border-right: 1px solid var(--border-color);
        }

        .info-item:nth-child(2n) {
            border-right: none;
        }

        .info-item:nth-last-child(-n+3) {
            border-bottom: 1px solid var(--border-color);
        }

        .info-item:nth-last-child(-n+2) {
            border-bottom: none;
        }

        .summary-section {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 650px) {
        .result-card {
            padding: 26px 18px 20px;
        }

        .academy-header {
            display: block;
            text-align: center;
        }

        .logo-box {
            margin-bottom: 10px;
        }

        .academy-heading h1 {
            font-size: 24px;
        }

        .report-session {
            margin-top: 14px;
        }

        .student-info-grid {
            grid-template-columns: 1fr;
        }

        .info-item,
        .info-item:nth-child(2n),
        .info-item:nth-child(3n) {
            border-right: none;
            border-bottom: 1px solid var(--border-color);
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .assessment-table-wrapper {
            overflow-x: auto;
        }

        .assessment-table {
            min-width: 680px;
        }

        .signature-section {
            gap: 20px;
        }

        .report-footer {
            align-items: center;
            flex-direction: column;
        }
    }

    @media print {
        @page {
            size: A4 portrait;
            margin: 8mm;
        }

        body {
            margin: 0 !important;
            padding: 0 !important;
            background: white !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        body * {
            visibility: hidden;
        }

        .result-card,
        .result-card * {
            visibility: visible;
        }

        .no-print,
        .sidebar,
        .navbar,
        .topbar,
        footer:not(.signature-section) {
            display: none !important;
        }

        .container-fluid,
        .nursery-result-page {
            width: 100% !important;
            max-width: none !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .result-card {
            position: absolute;
            top: 0;
            left: 0;
            width: 100% !important;
            max-width: none !important;
            min-height: auto;
            margin: 0 !important;
            padding: 7mm 9mm 5mm !important;
            border: 1px solid #cdd7e3 !important;
            border-radius: 0 !important;
            box-shadow: none !important;
        }

        .academy-header {
            grid-template-columns: 85px 1fr 130px;
            gap: 12px;
            padding-bottom: 13px;
        }

        .academy-logo,
        .logo-fallback {
            width: 72px;
            height: 72px;
        }

        .academy-heading h1 {
            font-size: 25px;
        }

        .academy-tagline {
            margin-bottom: 6px;
            font-size: 11px;
        }

        .report-title {
            padding: 5px 17px;
            font-size: 12px;
        }

        .student-information,
        .assessment-section,
        .remarks-section {
            margin-top: 13px;
        }

        .section-heading {
            margin-bottom: 7px;
            font-size: 14px;
        }

        .heading-icon {
            width: 24px;
            height: 24px;
            font-size: 10px;
        }

        .info-item {
            min-height: 50px;
            padding: 7px 11px;
        }

        .info-label {
            margin-bottom: 2px;
            font-size: 9px;
        }

        .info-value {
            font-size: 12px;
        }

        .assessment-table thead th {
            padding: 7px 10px;
            font-size: 9px;
        }

        .assessment-table tbody td {
            padding: 6px 10px;
            font-size: 11px;
        }

        .activity-icon {
            width: 22px;
            height: 22px;
            font-size: 9px;
        }

        .assessment-badge {
            min-width: 100px;
            padding: 4px 8px;
            font-size: 9px;
        }

        .stars-cell {
            font-size: 14px !important;
        }

        .summary-section {
            grid-template-columns: 1fr 1.25fr;
            gap: 10px;
            margin-top: 12px;
        }

        .overall-performance,
        .assessment-key {
            padding: 10px 12px;
        }

        .performance-icon {
            width: 43px;
            height: 43px;
            font-size: 18px;
        }

        .performance-value {
            font-size: 17px;
        }

        .performance-stars {
            font-size: 13px;
        }

        .assessment-key h4 {
            margin-bottom: 6px;
            font-size: 11px;
        }

        .key-grid {
            gap: 3px 10px;
        }

        .key-item {
            font-size: 8px;
        }

        .key-stars {
            min-width: 52px;
            font-size: 9px;
        }

        .remarks-box {
            min-height: 48px;
            padding: 10px 12px;
            font-size: 10px;
            line-height: 1.45;
        }

        .appreciation-message {
            margin-top: 11px;
            padding: 8px 11px;
        }

        .appreciation-icon {
            width: 34px;
            height: 34px;
            font-size: 14px;
        }

        .appreciation-message strong {
            font-size: 11px;
        }

        .appreciation-message p {
            font-size: 8px;
        }

        .signature-section {
            gap: 45px;
            margin-top: 34px;
        }

        .signature-item span {
            font-size: 9px;
        }

        .report-footer {
            margin-top: 14px;
            padding-top: 7px;
            font-size: 7px;
        }

        .result-card::before,
        .result-card::after {
            display: none;
        }
    }
</style>

@endpush