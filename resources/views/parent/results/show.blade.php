<x-app-layout>

    <x-slot name="header">

        <div class="result-header">

            <div>

                <h2>
                    Student Result
                </h2>

                <p>
                    {{ $exam->exam_name }}
                    ·
                    {{ $exam->session }}
                </p>

            </div>


            <div class="header-actions">

                <a
                    href="{{ route('parent.results.index') }}"
                    class="back-btn"
                >
                    <i class="fa-solid fa-arrow-left"></i>
                    Back
                </a>


                <button
                    type="button"
                    onclick="window.print()"
                    class="print-btn"
                >
                    <i class="fa-solid fa-print"></i>
                    Print Result
                </button>

            </div>

        </div>

    </x-slot>


    <div class="result-page">

        <div class="result-container">


            <div class="result-sheet">


                {{-- Academy Header --}}

                <div class="academy-header">

                    <div class="academy-logo">

                        <i class="fa-solid fa-graduation-cap"></i>

                    </div>


                    <div>

                        <h1>
                            THE GLORIFY ACADEMY
                        </h1>

                        <p>
                            Student Academic Result Card
                        </p>

                    </div>

                </div>



                {{-- Exam Heading --}}

                <div class="exam-heading">

                    <h2>
                        {{ $exam->exam_name }}
                    </h2>

                    <span>
                        Academic Session:
                        {{ $exam->session }}
                    </span>

                </div>



                {{-- Student Information --}}

                <div class="student-section">


                    <div class="student-photo">

                        @if($student->photo)

                            <img
                                src="{{ asset('storage/' . $student->photo) }}"
                                alt="{{ $student->name }}"
                            >

                        @else

                            <span>
                                {{ strtoupper(substr($student->name, 0, 1)) }}
                            </span>

                        @endif

                    </div>


                    <div class="student-details">


                        <div class="detail-item">

                            <span>
                                Student Name
                            </span>

                            <strong>
                                {{ $student->name }}
                            </strong>

                        </div>


                        <div class="detail-item">

                            <span>
                                Student ID
                            </span>

                            <strong>
                                {{ $student->student_id }}
                            </strong>

                        </div>


                        <div class="detail-item">

                            <span>
                                Class
                            </span>

                            <strong>
                                {{ $student->classRoom?->class_name ?? 'N/A' }}
                            </strong>

                        </div>


                        <div class="detail-item">

                            <span>
                                Gender
                            </span>

                            <strong>
                                {{ $student->gender ?? 'N/A' }}
                            </strong>

                        </div>


                        <div class="detail-item">

                            <span>
                                Exam
                            </span>

                            <strong>
                                {{ $exam->exam_name }}
                            </strong>

                        </div>


                        <div class="detail-item">

                            <span>
                                Session
                            </span>

                            <strong>
                                {{ $exam->session }}
                            </strong>

                        </div>


                    </div>

                </div>



                {{-- Subject Marks --}}

                <div class="section-title">
                    Subject Wise Performance
                </div>


                <div class="table-wrapper">

                    <table class="result-table">

                        <thead>

                            <tr>
                                <th>#</th>
                                <th>Subject</th>
                                <th>Total Marks</th>
                                <th>Pass Marks</th>
                                <th>Obtained</th>
                                <th>Percentage</th>
                                <th>Grade</th>
                                <th>Status</th>
                            </tr>

                        </thead>


                        <tbody>

                            @foreach($marks as $mark)

                                <tr>

                                    <td data-label="#">
                                        {{ $loop->iteration }}
                                    </td>


                                    <td
                                        data-label="Subject"
                                        class="subject-name"
                                    >
                                        {{ $mark->subject?->subject_name ?? 'N/A' }}
                                    </td>


                                    <td data-label="Total Marks">
                                        {{ $mark->total_marks }}
                                    </td>


                                    <td data-label="Pass Marks">
                                        {{ $mark->passing_marks }}
                                    </td>


                                    <td data-label="Obtained">

                                        @if($mark->is_absent)

                                            <span class="absent-text">
                                                Absent
                                            </span>

                                        @else

                                            {{ $mark->obtained_marks ?? '-' }}

                                        @endif

                                    </td>


                                    <td data-label="Percentage">

                                        @if($mark->is_absent)

                                            0%

                                        @else

                                            {{ $mark->percentage }}%

                                        @endif

                                    </td>


                                    <td data-label="Grade">

                                        <span class="grade-badge">
                                            {{ $mark->grade ?? '-' }}
                                        </span>

                                    </td>


                                    <td data-label="Status">

                                        @if($mark->result_status === 'Pass')

                                            <span class="status-badge pass-status">
                                                Pass
                                            </span>

                                        @elseif($mark->result_status === 'Fail')

                                            <span class="status-badge fail-status">
                                                Fail
                                            </span>

                                        @elseif($mark->result_status === 'Absent')

                                            <span class="status-badge absent-status">
                                                Absent
                                            </span>

                                        @else

                                            <span class="status-badge pending-status">
                                                Pending
                                            </span>

                                        @endif

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>



                {{-- Summary --}}

                <div class="summary-grid">


                    <div class="summary-box">

                        <span>
                            Total Marks
                        </span>

                        <strong>
                            {{ $summary['total_marks'] }}
                        </strong>

                    </div>


                    <div class="summary-box">

                        <span>
                            Obtained Marks
                        </span>

                        <strong>
                            {{ $summary['obtained_marks'] }}
                        </strong>

                    </div>


                    <div class="summary-box">

                        <span>
                            Percentage
                        </span>

                        <strong>
                            {{ $summary['percentage'] }}%
                        </strong>

                    </div>


                    <div class="summary-box">

                        <span>
                            Grade
                        </span>

                        <strong>
                            {{ $summary['grade'] }}
                        </strong>

                    </div>


                    <div class="summary-box">

                        <span>
                            Result
                        </span>

                        <strong
                            class="{{ $summary['result_status'] === 'Pass'
                                ? 'summary-pass'
                                : 'summary-fail' }}"
                        >
                            {{ $summary['result_status'] }}
                        </strong>

                    </div>


                    <div class="summary-box">

                        <span>
                            Subjects
                        </span>

                        <strong>
                            {{ $summary['total_subjects'] }}
                        </strong>

                    </div>


                </div>



                {{-- Performance Summary --}}

                <div class="performance-grid">


                    <div>

                        <span>
                            Passed
                        </span>

                        <strong class="text-pass">
                            {{ $summary['passed_subjects'] }}
                        </strong>

                    </div>


                    <div>

                        <span>
                            Failed
                        </span>

                        <strong class="text-fail">
                            {{ $summary['failed_subjects'] }}
                        </strong>

                    </div>


                    <div>

                        <span>
                            Absent
                        </span>

                        <strong class="text-absent">
                            {{ $summary['absent_subjects'] }}
                        </strong>

                    </div>


                </div>



                {{-- Parent Message --}}

                <div class="remarks-section">

                    <div class="section-title">
                        Performance Note
                    </div>


                    <div class="remarks-box">

                        @if($summary['result_status'] === 'Pass')

                            Congratulations! Your child has successfully
                            passed this examination.

                        @else

                            Your child needs additional attention and
                            regular academic practice.

                        @endif

                    </div>

                </div>



                {{-- Signatures --}}

                <div class="signature-area">

                    <div>

                        <div class="signature-line"></div>

                        <span>
                            Class Teacher
                        </span>

                    </div>


                    <div>

                        <div class="signature-line"></div>

                        <span>
                            Principal / Administrator
                        </span>

                    </div>

                </div>



                <div class="result-footer">

                    Generated by The Glorify Academy Management System

                </div>


            </div>

        </div>

    </div>



    <style>

        :root {
            --page-bg: #f4f7fb;
            --card-bg: #ffffff;
            --secondary-bg: #f8fafc;

            --text-primary: #0f172a;
            --text-secondary: #64748b;
            --text-muted: #94a3b8;

            --border: #e2e8f0;

            --primary: #2563eb;

            --shadow:
                0 10px 30px rgba(15,23,42,.06);
        }


        html.dark-mode {
            --page-bg: #090e1a;
            --card-bg: #111827;
            --secondary-bg: #172033;

            --text-primary: #f8fafc;
            --text-secondary: #a7b2c5;
            --text-muted: #75829a;

            --border: #253047;

            --primary: #60a5fa;

            --shadow:
                0 12px 35px rgba(0,0,0,.28);
        }


        body {
            background: var(--page-bg);
        }


        .result-header {
            width: 100%;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 20px;
        }


        .result-header h2 {
            margin: 0 0 4px;

            color: var(--text-primary);

            font-size: 21px;
            font-weight: 750;
        }


        .result-header p {
            margin: 0;

            color: var(--text-secondary);

            font-size: 12px;
        }


        .header-actions {
            display: flex;
            gap: 9px;
        }


        .back-btn,
        .print-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 7px;

            padding: 10px 15px;

            border-radius: 11px;

            text-decoration: none;

            font-size: 12px;
            font-weight: 700;

            cursor: pointer;
        }


        .back-btn {
            background: var(--secondary-bg);
            color: var(--text-secondary);
        }


        .print-btn {
            border: none;

            background: #2563eb;
            color: white;
        }


        .result-page {
            min-height: calc(100vh - 70px);

            padding: 30px 20px 50px;

            background:
                radial-gradient(
                    circle at 10% 10%,
                    rgba(37,99,235,.05),
                    transparent 30%
                ),
                var(--page-bg);
        }


        .result-container {
            width: 100%;
            max-width: 1100px;

            margin: auto;
        }


        .result-sheet {
            padding: 30px;

            border: 1px solid var(--border);
            border-radius: 20px;

            background: var(--card-bg);

            box-shadow: var(--shadow);

            transition:
                background .3s ease,
                border-color .3s ease;
        }



        /* Academy Header */

        .academy-header {
            padding-bottom: 18px;

            border-bottom: 3px solid #2563eb;

            display: flex;
            align-items: center;
            justify-content: center;

            gap: 14px;

            text-align: center;
        }


        .academy-logo {
            width: 62px;
            height: 62px;

            border-radius: 17px;

            background: #eff6ff;
            color: #2563eb;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 27px;
        }


        html.dark-mode .academy-logo {
            background: rgba(37,99,235,.16);
            color: #60a5fa;
        }


        .academy-header h1 {
            margin: 0 0 3px;

            color: var(--text-primary);

            font-size: 24px;
            font-weight: 900;
        }


        .academy-header p {
            margin: 0;

            color: var(--text-secondary);

            font-size: 11px;
        }



        /* Exam Heading */

        .exam-heading {
            padding: 17px 0;

            text-align: center;
        }


        .exam-heading h2 {
            margin: 0 0 4px;

            color: var(--text-primary);

            font-size: 20px;
            font-weight: 750;
        }


        .exam-heading span {
            color: var(--text-secondary);

            font-size: 11px;
        }



        /* Student */

        .student-section {
            margin-bottom: 22px;

            padding: 18px;

            border-radius: 15px;

            background: var(--secondary-bg);

            display: grid;

            grid-template-columns: auto 1fr;

            gap: 18px;

            align-items: center;
        }


        .student-photo {
            width: 80px;
            height: 80px;

            border-radius: 16px;

            overflow: hidden;

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #60a5fa
                );

            color: white;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 28px;
            font-weight: 800;
        }


        .student-photo img {
            width: 100%;
            height: 100%;

            object-fit: cover;
        }


        .student-details {
            display: grid;

            grid-template-columns:
                repeat(3, minmax(0, 1fr));

            gap: 14px;
        }


        .detail-item span,
        .detail-item strong {
            display: block;
        }


        .detail-item span {
            margin-bottom: 3px;

            color: var(--text-muted);

            font-size: 9px;

            text-transform: uppercase;

            letter-spacing: .4px;
        }


        .detail-item strong {
            color: var(--text-primary);

            font-size: 12px;
        }



        /* Table */

        .section-title {
            margin-top: 18px;

            padding: 8px 11px;

            border-radius: 7px 7px 0 0;

            background: #172554;
            color: white;

            font-size: 11px;
            font-weight: 750;
        }


        .table-wrapper {
            overflow-x: auto;
        }


        .result-table {
            width: 100%;

            border-collapse: collapse;
        }


        .result-table th {
            padding: 10px 11px;

            border: 1px solid var(--border);

            background: var(--secondary-bg);
            color: var(--text-secondary);

            text-align: left;

            font-size: 9px;
            font-weight: 750;

            white-space: nowrap;
        }


        .result-table td {
            padding: 10px 11px;

            border: 1px solid var(--border);

            color: var(--text-primary);

            font-size: 10px;
        }


        .subject-name {
            font-weight: 700;
        }



        /* Badges */

        .grade-badge {
            display: inline-block;

            min-width: 32px;

            padding: 4px 7px;

            border-radius: 8px;

            background: #f3e8ff;
            color: #7e22ce;

            text-align: center;

            font-size: 9px;
            font-weight: 750;
        }


        html.dark-mode .grade-badge {
            background: rgba(147,51,234,.15);
            color: #c084fc;
        }


        .status-badge {
            display: inline-block;

            padding: 4px 8px;

            border-radius: 20px;

            font-size: 9px;
            font-weight: 750;
        }


        .pass-status {
            background: #dcfce7;
            color: #15803d;
        }


        .fail-status {
            background: #fee2e2;
            color: #b91c1c;
        }


        .absent-status {
            background: #ffedd5;
            color: #c2410c;
        }


        .pending-status {
            background: #f1f5f9;
            color: #64748b;
        }


        html.dark-mode .pass-status {
            background: rgba(34,197,94,.14);
            color: #4ade80;
        }


        html.dark-mode .fail-status {
            background: rgba(239,68,68,.14);
            color: #f87171;
        }


        html.dark-mode .absent-status {
            background: rgba(249,115,22,.14);
            color: #fb923c;
        }


        html.dark-mode .pending-status {
            background: #172033;
            color: #94a3b8;
        }


        .absent-text {
            color: #c2410c;
            font-weight: 700;
        }



        /* Summary */

        .summary-grid {
            margin-top: 20px;

            display: grid;

            grid-template-columns:
                repeat(6, minmax(0, 1fr));

            gap: 10px;
        }


        .summary-box {
            padding: 13px 9px;

            border: 1px solid var(--border);
            border-radius: 11px;

            background: var(--secondary-bg);

            text-align: center;
        }


        .summary-box span,
        .summary-box strong {
            display: block;
        }


        .summary-box span {
            margin-bottom: 4px;

            color: var(--text-muted);

            font-size: 8px;

            text-transform: uppercase;
        }


        .summary-box strong {
            color: var(--text-primary);

            font-size: 15px;
            font-weight: 800;
        }


        .summary-pass {
            color: #15803d !important;
        }


        .summary-fail {
            color: #b91c1c !important;
        }


        html.dark-mode .summary-pass {
            color: #4ade80 !important;
        }


        html.dark-mode .summary-fail {
            color: #f87171 !important;
        }



        /* Performance */

        .performance-grid {
            margin-top: 12px;

            display: grid;

            grid-template-columns:
                repeat(3, minmax(0, 1fr));

            gap: 10px;
        }


        .performance-grid > div {
            padding: 11px;

            border: 1px solid var(--border);
            border-radius: 10px;

            background: var(--secondary-bg);

            text-align: center;
        }


        .performance-grid span,
        .performance-grid strong {
            display: block;
        }


        .performance-grid span {
            margin-bottom: 3px;

            color: var(--text-muted);

            font-size: 8px;
        }


        .performance-grid strong {
            font-size: 13px;
        }


        .text-pass {
            color: #15803d;
        }


        .text-fail {
            color: #b91c1c;
        }


        .text-absent {
            color: #c2410c;
        }


        html.dark-mode .text-pass {
            color: #4ade80;
        }


        html.dark-mode .text-fail {
            color: #f87171;
        }


        html.dark-mode .text-absent {
            color: #fb923c;
        }



        /* Remarks */

        .remarks-box {
            padding: 15px;

            border: 1px solid var(--border);
            border-top: none;

            border-radius: 0 0 8px 8px;

            color: var(--text-secondary);

            font-size: 11px;
            line-height: 1.6;
        }



        /* Signatures */

        .signature-area {
            margin-top: 60px;

            display: grid;

            grid-template-columns:
                repeat(2, minmax(0, 1fr));

            gap: 100px;

            text-align: center;
        }


        .signature-line {
            border-top:
                1px solid var(--text-secondary);
        }


        .signature-area span {
            display: block;

            margin-top: 5px;

            color: var(--text-secondary);

            font-size: 9px;
        }



        /* Footer */

        .result-footer {
            margin-top: 28px;

            padding-top: 11px;

            border-top:
                1px solid var(--border);

            color: var(--text-muted);

            text-align: center;

            font-size: 8px;
        }



        /* Responsive */

        @media (max-width: 850px) {

            .student-details {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }

            .summary-grid {
                grid-template-columns:
                    repeat(3, minmax(0, 1fr));
            }

        }


        @media (max-width: 600px) {

            .result-header {
                flex-direction: column;
                align-items: stretch;
            }

            .header-actions {
                width: 100%;
            }

            .back-btn,
            .print-btn {
                flex: 1;
            }

            .result-page {
                padding: 20px 12px 35px;
            }

            .result-sheet {
                padding: 17px;

                border-radius: 15px;
            }

            .academy-header {
                flex-direction: column;
            }

            .academy-header h1 {
                font-size: 20px;
            }

            .student-section {
                grid-template-columns: 1fr;

                text-align: center;
            }

            .student-photo {
                margin: auto;
            }

            .student-details {
                grid-template-columns: 1fr 1fr;

                text-align: left;
            }

            .summary-grid {
                grid-template-columns: 1fr 1fr;
            }

            .performance-grid {
                grid-template-columns: 1fr;
            }

            .signature-area {
                gap: 35px;
            }

            .table-wrapper {
                overflow: visible;
            }

            .result-table,
            .result-table tbody,
            .result-table tr,
            .result-table td {
                display: block;

                width: 100%;
            }

            .result-table thead {
                display: none;
            }

            .result-table tr {
                margin-bottom: 12px;

                overflow: hidden;

                border:
                    1px solid var(--border);

                border-radius: 12px;
            }

            .result-table td {
                position: relative;

                min-height: 37px;

                padding:
                    9px 10px
                    9px 43%;

                border-width:
                    0 0 1px;
            }

            .result-table td:last-child {
                border-bottom: 0;
            }

            .result-table td::before {
                content:
                    attr(data-label);

                position: absolute;

                top: 9px;
                left: 10px;

                width: 35%;

                color: var(--text-muted);

                font-size: 8px;
                font-weight: 750;
            }

        }



        /* Print */

        @media print {

            @page {
                size: A4 portrait;
                margin: 8mm;
            }

            body {
                margin: 0 !important;

                background: white !important;

                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            body * {
                visibility: hidden;
            }

            .result-sheet,
            .result-sheet * {
                visibility: visible;
            }

            .result-sheet {
                position: absolute;

                top: 0;
                left: 0;

                width: 100%;

                padding: 5mm;

                border: none;
                border-radius: 0;

                background: white !important;

                box-shadow: none;
            }

            .academy-header h1,
            .exam-heading h2,
            .detail-item strong,
            .result-table td,
            .summary-box strong {
                color: #000 !important;
            }

            .student-section,
            .summary-box,
            .performance-grid > div,
            .result-table th {
                background: #fff !important;
            }

            .student-section {
                margin-bottom: 10px;
                padding: 10px;
            }

            .student-photo {
                width: 60px;
                height: 60px;
            }

            .result-table th,
            .result-table td {
                padding: 6px;
                font-size: 8px;
            }

            .summary-grid {
                margin-top: 10px;
                gap: 5px;
            }

            .summary-box {
                padding: 7px 4px;
            }

            .summary-box strong {
                font-size: 11px;
            }

            .signature-area {
                margin-top: 38px;
            }

        }

    </style>

</x-app-layout>