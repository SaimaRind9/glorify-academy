<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Student Result
        </h2>
    </x-slot>

    <div class="py-8">

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="result-page-header no-print">

                <div>
                    <h2>Student Result Card</h2>

                    <p>
                        {{ $exam->exam_name }}
                        -
                        {{ $exam->session }}
                    </p>
                </div>

                <div class="header-actions">

                    <a href="{{ route(
                            'teacher.results.index',
                            ['exam_id' => $exam->id]
                        ) }}"
                       class="back-btn">

                        <i class="fa-solid fa-arrow-left"></i>
                        Back

                    </a>

                    <button type="button"
                            onclick="window.print()"
                            class="print-btn">

                        <i class="fa-solid fa-print"></i>
                        Print Result

                    </button>

                </div>

            </div>


            <div class="result-sheet">

                {{-- Academy Header --}}
                <div class="academy-header">

                    <div class="academy-logo">

                        <i class="fa-solid fa-graduation-cap"></i>

                    </div>

                    <div class="academy-info">

                        <h1>
                            THE GLORIFY ACADEMY
                        </h1>

                        <p>
                            Student Academic Result Card
                        </p>

                    </div>

                </div>


                <div class="exam-title">

                    <h2>
                        {{ $exam->exam_name }}
                    </h2>

                    <span>
                        Academic Session:
                        {{ $exam->session }}
                    </span>

                </div>


                {{-- Student Info --}}
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
                                Father Name
                            </span>

                            <strong>
                                {{ $student->father_name ?? 'N/A' }}
                            </strong>

                        </div>


                        <div class="detail-item">

                            <span>
                                Class
                            </span>

                            <strong>
                                {{ $teacher->classRoom?->class_name ?? 'N/A' }}
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


                {{-- Marks Table --}}
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


                                <td data-label="Subject"
                                    class="subject-name">

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

                        <strong class="{{ $summary['result_status'] === 'Pass'
                            ? 'summary-pass'
                            : 'summary-fail' }}">

                            {{ $summary['result_status'] }}

                        </strong>

                    </div>


                    <div class="summary-box">

                        <span>
                            Position
                        </span>

                        <strong>
                            {{ $position ?? 'N/A' }}
                        </strong>

                    </div>

                </div>


                {{-- Extra Summary --}}
                <div class="performance-summary">

                    <div>

                        <span>
                            Total Subjects
                        </span>

                        <strong>
                            {{ $summary['total_subjects'] }}
                        </strong>

                    </div>


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


                {{-- Remarks --}}
                <div class="remarks-section">

                    <div class="section-title">
                        Teacher Remarks
                    </div>

                    <div class="remarks-box">

                        @if($summary['result_status'] === 'Pass')

                            Congratulations! Keep up the good work.

                        @else

                            More effort and regular practice are recommended.

                        @endif

                    </div>

                </div>


                {{-- Signatures --}}
                <div class="signature-area">

                    <div class="signature-box">

                        <div class="signature-line"></div>

                        <span>
                            Class Teacher
                        </span>

                    </div>


                    <div class="signature-box">

                        <div class="signature-line"></div>

                        <span>
                            Principal / Administrator
                        </span>

                    </div>

                </div>


                <div class="result-footer">

                    <p>
                        Generated by The Glorify Academy Management System
                    </p>

                </div>

            </div>

        </div>

    </div>


    <style>

        body {
            background: #f8fafc;
        }


        .result-page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 24px;
        }


        .result-page-header h2 {
            margin: 0 0 5px;
            color: #0f172a;
            font-size: 26px;
            font-weight: 750;
        }


        .result-page-header p {
            margin: 0;
            color: #64748b;
            font-size: 14px;
        }


        .header-actions {
            display: flex;
            gap: 10px;
        }


        .back-btn,
        .print-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 10px 16px;
            border-radius: 11px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 650;
            transition: .2s;
        }


        .back-btn {
            background: #e2e8f0;
            color: #334155;
        }


        .back-btn:hover {
            background: #cbd5e1;
            color: #0f172a;
        }


        .print-btn {
            border: none;
            background: #2563eb;
            color: #ffffff;
            cursor: pointer;
        }


        .print-btn:hover {
            background: #1d4ed8;
        }


        .result-sheet {
            padding: 30px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, .06);
        }


        .academy-header {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            padding-bottom: 20px;
            border-bottom: 3px solid #2563eb;
            text-align: center;
        }


        .academy-logo {
            width: 65px;
            height: 65px;
            border-radius: 18px;
            background: #eff6ff;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
        }


        .academy-info h1 {
            margin: 0 0 4px;
            color: #172554;
            font-size: 25px;
            font-weight: 900;
            letter-spacing: .5px;
        }


        .academy-info p {
            margin: 0;
            color: #64748b;
            font-size: 12px;
        }


        .exam-title {
            padding: 18px 0;
            text-align: center;
        }


        .exam-title h2 {
            margin: 0 0 5px;
            color: #0f172a;
            font-size: 20px;
            font-weight: 750;
        }


        .exam-title span {
            color: #64748b;
            font-size: 12px;
        }


        .student-section {
            display: grid;
            grid-template-columns: auto 1fr;
            gap: 20px;
            align-items: center;
            margin-bottom: 25px;
            padding: 20px;
            background: #f8fafc;
            border-radius: 15px;
        }


        .student-photo {
            width: 85px;
            height: 85px;
            border-radius: 16px;
            overflow: hidden;
            background: #dbeafe;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            font-weight: 800;
        }


        .student-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }


        .student-details {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 15px;
        }


        .detail-item span,
        .detail-item strong {
            display: block;
        }


        .detail-item span {
            margin-bottom: 4px;
            color: #94a3b8;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: .4px;
        }


        .detail-item strong {
            color: #0f172a;
            font-size: 13px;
        }


        .section-title {
            margin-top: 20px;
            padding: 8px 11px;
            background: #172554;
            color: #ffffff;
            font-size: 12px;
            font-weight: 750;
            border-radius: 7px 7px 0 0;
        }


        .table-wrapper {
            overflow-x: auto;
        }


        .result-table {
            width: 100%;
            border-collapse: collapse;
        }


        .result-table th {
            padding: 11px 12px;
            background: #f8fafc;
            color: #475569;
            border: 1px solid #e2e8f0;
            text-align: left;
            font-size: 10px;
            font-weight: 750;
            white-space: nowrap;
        }


        .result-table td {
            padding: 11px 12px;
            color: #334155;
            border: 1px solid #e2e8f0;
            font-size: 11px;
        }


        .subject-name {
            font-weight: 700;
            color: #0f172a !important;
        }


        .grade-badge {
            display: inline-block;
            min-width: 34px;
            padding: 4px 7px;
            border-radius: 8px;
            background: #f3e8ff;
            color: #7e22ce;
            text-align: center;
            font-size: 10px;
            font-weight: 750;
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


        .absent-text {
            color: #c2410c;
            font-weight: 700;
        }


        .summary-grid {
            display: grid;
            grid-template-columns: repeat(6, minmax(0, 1fr));
            gap: 12px;
            margin-top: 22px;
        }


        .summary-box {
            padding: 15px 12px;
            background: #f8fafc;
            border: 1px solid #e8edf4;
            border-radius: 12px;
            text-align: center;
        }


        .summary-box span,
        .summary-box strong {
            display: block;
        }


        .summary-box span {
            margin-bottom: 5px;
            color: #94a3b8;
            font-size: 9px;
            text-transform: uppercase;
        }


        .summary-box strong {
            color: #0f172a;
            font-size: 16px;
            font-weight: 800;
        }


        .summary-pass {
            color: #15803d !important;
        }


        .summary-fail {
            color: #b91c1c !important;
        }


        .performance-summary {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 12px;
            margin-top: 15px;
        }


        .performance-summary > div {
            padding: 12px;
            border: 1px solid #e8edf4;
            border-radius: 11px;
            text-align: center;
        }


        .performance-summary span,
        .performance-summary strong {
            display: block;
        }


        .performance-summary span {
            margin-bottom: 4px;
            color: #94a3b8;
            font-size: 9px;
        }


        .performance-summary strong {
            color: #0f172a;
            font-size: 14px;
        }


        .text-pass {
            color: #15803d !important;
        }


        .text-fail {
            color: #b91c1c !important;
        }


        .text-absent {
            color: #c2410c !important;
        }


        .remarks-box {
            padding: 17px;
            border: 1px solid #e2e8f0;
            border-top: none;
            border-radius: 0 0 8px 8px;
            color: #475569;
            font-size: 12px;
            line-height: 1.6;
        }


        .signature-area {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 100px;
            margin-top: 65px;
        }


        .signature-box {
            text-align: center;
        }


        .signature-line {
            border-top: 1px solid #334155;
        }


        .signature-box span {
            display: block;
            margin-top: 6px;
            color: #475569;
            font-size: 10px;
            font-weight: 650;
        }


        .result-footer {
            margin-top: 30px;
            padding-top: 12px;
            border-top: 1px solid #e2e8f0;
            text-align: center;
        }


        .result-footer p {
            margin: 0;
            color: #94a3b8;
            font-size: 9px;
        }


        @media (max-width: 900px) {

            .student-details {
                grid-template-columns: repeat(2, 1fr);
            }

            .summary-grid {
                grid-template-columns: repeat(3, 1fr);
            }

        }


        @media (max-width: 650px) {

            .result-page-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .header-actions {
                width: 100%;
            }

            .back-btn,
            .print-btn {
                flex: 1;
            }

            .result-sheet {
                padding: 18px;
            }

            .academy-header {
                flex-direction: column;
            }

            .academy-info h1 {
                font-size: 20px;
            }

            .student-section {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .student-photo {
                margin: 0 auto;
            }

            .student-details {
                grid-template-columns: 1fr 1fr;
                text-align: left;
            }

            .summary-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .performance-summary {
                grid-template-columns: repeat(2, 1fr);
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
                border: 1px solid #e2e8f0;
                border-radius: 12px;
                overflow: hidden;
            }

            .result-table td {
                position: relative;
                padding: 9px 10px 9px 43%;
                border-width: 0 0 1px;
                min-height: 38px;
            }

            .result-table td:last-child {
                border-bottom: 0;
            }

            .result-table td::before {
                content: attr(data-label);
                position: absolute;
                left: 10px;
                top: 9px;
                width: 35%;
                color: #64748b;
                font-size: 9px;
                font-weight: 750;
            }

        }


        @media print {

            @page {
                size: A4 portrait;
                margin: 8mm;
            }

            body {
                background: #ffffff !important;
                margin: 0 !important;
                padding: 0 !important;
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

            .no-print {
                display: none !important;
            }

            .result-sheet {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                padding: 5mm;
                border: none;
                border-radius: 0;
                box-shadow: none;
            }

            .academy-header {
                padding-bottom: 10px;
            }

            .academy-logo {
                width: 50px;
                height: 50px;
                font-size: 22px;
            }

            .academy-info h1 {
                font-size: 19px;
            }

            .student-section {
                margin-bottom: 12px;
                padding: 12px;
            }

            .student-photo {
                width: 65px;
                height: 65px;
            }

            .result-table th,
            .result-table td {
                padding: 6px 7px;
                font-size: 8px;
            }

            .summary-grid {
                gap: 6px;
                margin-top: 12px;
            }

            .summary-box {
                padding: 8px 5px;
            }

            .summary-box strong {
                font-size: 12px;
            }

            .signature-area {
                margin-top: 40px;
            }

        }

    </style>

</x-app-layout>