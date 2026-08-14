<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Teacher Results
        </h2>
    </x-slot>

    <div class="py-8">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="result-header">

                <div>
                    <h2>Student Results</h2>

                    <p>
                        Class:
                        <strong>
                            {{ $teacher->classRoom?->class_name ?? 'Assigned Class' }}
                        </strong>
                    </p>
                </div>

                <a href="{{ route('dashboard') }}"
                   class="back-btn">

                    <i class="fa-solid fa-arrow-left"></i>
                    Back to Dashboard

                </a>

            </div>


            <div class="filter-card">

                <div class="section-heading">

                    <div class="heading-icon">
                        <i class="fa-solid fa-filter"></i>
                    </div>

                    <div>
                        <h3>Select Exam</h3>
                        <p>Load students whose marks have been entered</p>
                    </div>

                </div>


                <form method="GET"
                      action="{{ route('teacher.results.index') }}">

                    <div class="filter-grid">

                        <div class="form-group">

                            <label>
                                Exam
                            </label>

                            <select name="exam_id"
                                    required>

                                <option value="">
                                    Select Exam
                                </option>

                                @foreach($exams as $exam)

                                    <option value="{{ $exam->id }}"
                                        {{ request('exam_id') == $exam->id ? 'selected' : '' }}>

                                        {{ $exam->exam_name }}
                                        - {{ $exam->session }}

                                    </option>

                                @endforeach

                            </select>

                        </div>


                        <div class="form-group">

                            <label>
                                Search Student
                            </label>

                            <input type="text"
                                   name="search"
                                   value="{{ request('search') }}"
                                   placeholder="Name or Student ID">

                        </div>


                        <div class="filter-button-wrap">

                            <button type="submit"
                                    class="load-btn">

                                <i class="fa-solid fa-magnifying-glass"></i>
                                Load Results

                            </button>

                        </div>

                    </div>

                </form>

            </div>


            @if($selectedExamId)

                <div class="result-card">

                    <div class="result-card-heading">

                        <div>
                            <h3>Result List</h3>

                            <p>
                                View and print student result cards
                            </p>
                        </div>

                        @if($students)

                            <span class="student-count">
                                {{ $students->total() }} Students
                            </span>

                        @endif

                    </div>


                    @if($students && $students->count())

                        <div class="result-table-wrapper">

                            <table class="result-table">

                                <thead>

                                    <tr>
                                        <th>#</th>
                                        <th>Student</th>
                                        <th>Student ID</th>
                                        <th>Total Marks</th>
                                        <th>Obtained</th>
                                        <th>Percentage</th>
                                        <th>Grade</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>

                                </thead>


                                <tbody>

                                @foreach($students as $student)

                                    @php
                                        $summary = $student->result_summary;
                                    @endphp

                                    <tr>

                                        <td data-label="#">
                                            {{ $loop->iteration + ($students->currentPage() - 1) * $students->perPage() }}
                                        </td>


                                        <td data-label="Student">

                                            <div class="student-box">

                                                <div class="student-avatar">

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

                                                <div>

                                                    <strong>
                                                        {{ $student->name }}
                                                    </strong>

                                                    <span>
                                                        {{ $teacher->classRoom?->class_name ?? '' }}
                                                    </span>

                                                </div>

                                            </div>

                                        </td>


                                        <td data-label="Student ID">
                                            {{ $student->student_id }}
                                        </td>


                                        <td data-label="Total Marks">
                                            {{ $summary['total_marks'] }}
                                        </td>


                                        <td data-label="Obtained">
                                            {{ $summary['obtained_marks'] }}
                                        </td>


                                        <td data-label="Percentage">

                                            <strong>
                                                {{ $summary['percentage'] }}%
                                            </strong>

                                        </td>


                                        <td data-label="Grade">

                                            <span class="grade-badge">
                                                {{ $summary['grade'] }}
                                            </span>

                                        </td>


                                        <td data-label="Status">

                                            @if($summary['result_status'] === 'Pass')

                                                <span class="status-badge pass-status">
                                                    Pass
                                                </span>

                                            @else

                                                <span class="status-badge fail-status">
                                                    Fail
                                                </span>

                                            @endif

                                        </td>


                                        <td data-label="Action">

                                            <a href="{{ route(
                                                    'teacher.results.show',
                                                    [
                                                        'exam' => $selectedExamId,
                                                        'student' => $student->id
                                                    ]
                                                ) }}"
                                               class="view-btn">

                                                <i class="fa-solid fa-eye"></i>
                                                View Result

                                            </a>

                                        </td>

                                    </tr>

                                @endforeach

                                </tbody>

                            </table>

                        </div>


                        <div class="pagination-area">
                            {{ $students->links() }}
                        </div>


                    @else

                        <div class="empty-state">

                            <i class="fa-solid fa-chart-column"></i>

                            <h3>No Results Found</h3>

                            <p>
                                No student marks were found for this exam.
                            </p>

                        </div>

                    @endif

                </div>


            @else

                <div class="welcome-state">

                    <div class="welcome-icon">
                        <i class="fa-solid fa-chart-simple"></i>
                    </div>

                    <h3>
                        Ready to View Results
                    </h3>

                    <p>
                        Select an exam above to load your class results.
                    </p>

                </div>

            @endif

        </div>

    </div>


    <style>

        body {
            background: #f8fafc;
        }

        .result-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 24px;
        }

        .result-header h2 {
            margin: 0 0 5px;
            color: #0f172a;
            font-size: 26px;
            font-weight: 750;
        }

        .result-header p {
            margin: 0;
            color: #64748b;
            font-size: 14px;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 10px 16px;
            border-radius: 11px;
            background: #e2e8f0;
            color: #334155;
            text-decoration: none;
            font-size: 13px;
            font-weight: 650;
            transition: .2s;
        }

        .back-btn:hover {
            background: #cbd5e1;
            color: #0f172a;
        }

        .filter-card,
        .result-card,
        .welcome-state {
            background: #ffffff;
            border: 1px solid #e8edf4;
            box-shadow: 0 8px 25px rgba(15, 23, 42, .05);
        }

        .filter-card {
            padding: 24px;
            border-radius: 20px;
            margin-bottom: 20px;
        }

        .section-heading {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 21px;
        }

        .heading-icon {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            background: #fff1f2;
            color: #be123c;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 18px;
        }

        .section-heading h3 {
            margin: 0 0 3px;
            color: #0f172a;
            font-size: 17px;
            font-weight: 700;
        }

        .section-heading p {
            margin: 0;
            color: #94a3b8;
            font-size: 12px;
        }

        .filter-grid {
            display: grid;
            grid-template-columns: 1fr 1fr auto;
            gap: 18px;
            align-items: end;
        }

        .form-group label {
            display: block;
            margin-bottom: 7px;
            color: #334155;
            font-size: 13px;
            font-weight: 650;
        }

        .form-group select,
        .form-group input {
            width: 100%;
            height: 45px;
            padding: 8px 11px;
            border: 1px solid #cbd5e1;
            border-radius: 11px;
            background: #fff;
            color: #0f172a;
            outline: none;
            font-size: 13px;
        }

        .form-group select:focus,
        .form-group input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .10);
        }

        .load-btn {
            height: 45px;
            padding: 0 18px;
            border: none;
            border-radius: 11px;
            background: #2563eb;
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 13px;
            font-weight: 650;
            cursor: pointer;
            transition: .2s;
        }

        .load-btn:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
        }

        .result-card {
            border-radius: 20px;
            overflow: hidden;
        }

        .result-card-heading {
            padding: 22px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            border-bottom: 1px solid #eef2f7;
        }

        .result-card-heading h3 {
            margin: 0 0 4px;
            color: #0f172a;
            font-size: 18px;
            font-weight: 700;
        }

        .result-card-heading p {
            margin: 0;
            color: #94a3b8;
            font-size: 12px;
        }

        .student-count {
            padding: 6px 11px;
            border-radius: 20px;
            background: #eff6ff;
            color: #2563eb;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        .result-table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        .result-table {
            width: 100%;
            border-collapse: collapse;
        }

        .result-table thead {
            background: #f8fafc;
        }

        .result-table th {
            padding: 13px 14px;
            text-align: left;
            color: #64748b;
            font-size: 11px;
            font-weight: 700;
            border-bottom: 1px solid #e8edf4;
            white-space: nowrap;
        }

        .result-table td {
            padding: 14px;
            color: #334155;
            font-size: 12px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        .student-box {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 160px;
        }

        .student-avatar {
            width: 39px;
            height: 39px;
            border-radius: 11px;
            overflow: hidden;
            background: #dbeafe;
            color: #2563eb;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: 700;
            flex-shrink: 0;
        }

        .student-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .student-box strong,
        .student-box span {
            display: block;
        }

        .student-box strong {
            color: #0f172a;
            font-size: 12px;
        }

        .student-box span {
            margin-top: 2px;
            color: #94a3b8;
            font-size: 10px;
        }

        .grade-badge {
            display: inline-block;
            min-width: 35px;
            padding: 5px 8px;
            border-radius: 9px;
            background: #f3e8ff;
            color: #7e22ce;
            text-align: center;
            font-size: 11px;
            font-weight: 700;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
        }

        .pass-status {
            background: #dcfce7;
            color: #15803d;
        }

        .fail-status {
            background: #fee2e2;
            color: #b91c1c;
        }

        .view-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 11px;
            border-radius: 9px;
            background: #eff6ff;
            color: #2563eb;
            text-decoration: none;
            font-size: 11px;
            font-weight: 650;
            white-space: nowrap;
        }

        .view-btn:hover {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .pagination-area {
            padding: 18px 22px;
            border-top: 1px solid #eef2f7;
        }

        .welcome-state,
        .empty-state {
            text-align: center;
        }

        .welcome-state {
            padding: 60px 20px;
            border-radius: 20px;
        }

        .welcome-icon {
            width: 68px;
            height: 68px;
            margin: 0 auto 15px;
            border-radius: 19px;
            background: #fff1f2;
            color: #be123c;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 28px;
        }

        .welcome-state h3,
        .empty-state h3 {
            margin: 0 0 7px;
            color: #0f172a;
            font-size: 17px;
            font-weight: 700;
        }

        .welcome-state p,
        .empty-state p {
            margin: 0;
            color: #94a3b8;
            font-size: 12px;
        }

        .empty-state {
            padding: 50px 20px;
        }

        .empty-state i {
            margin-bottom: 12px;
            color: #94a3b8;
            font-size: 30px;
        }

        @media (max-width: 900px) {

            .filter-grid {
                grid-template-columns: 1fr 1fr;
            }

            .filter-button-wrap {
                grid-column: 1 / -1;
            }

            .load-btn {
                width: 100%;
            }

        }

        @media (max-width: 650px) {

            .result-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .back-btn {
                width: 100%;
            }

            .result-header h2 {
                font-size: 22px;
            }

            .filter-card {
                padding: 18px;
            }

            .filter-grid {
                grid-template-columns: 1fr;
            }

            .filter-button-wrap {
                grid-column: auto;
            }

            .result-card-heading {
                align-items: flex-start;
                padding: 18px;
            }

            .result-table-wrapper {
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

            .result-table tbody {
                padding: 12px;
            }

            .result-table tbody tr {
                margin-bottom: 14px;
                padding: 7px 0;
                border: 1px solid #e8edf4;
                border-radius: 14px;
                background: white;
                overflow: hidden;
            }

            .result-table td {
                position: relative;
                padding: 10px 12px 10px 42%;
                min-height: 42px;
            }

            .result-table td::before {
                content: attr(data-label);
                position: absolute;
                left: 12px;
                top: 11px;
                width: 34%;
                color: #64748b;
                font-size: 10px;
                font-weight: 700;
            }

            .student-box {
                min-width: 0;
            }

            .student-avatar {
                display: none;
            }

            .view-btn {
                width: 100%;
                justify-content: center;
            }

        }

    </style>

</x-app-layout>