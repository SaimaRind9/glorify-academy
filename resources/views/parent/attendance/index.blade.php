<x-app-layout>

    <x-slot name="header">
        <div class="attendance-page-header">

            <div>
                <h2>Student Attendance</h2>
                <p>View complete attendance history for your child</p>
            </div>

            <a href="{{ route('dashboard') }}" class="back-btn">
                <i class="fa-solid fa-arrow-left"></i>
                Dashboard
            </a>

        </div>
    </x-slot>


    <div class="attendance-page">

        <div class="attendance-container">


            {{-- Student --}}
            <div class="student-card">

                <div class="student-avatar">

                    @if($student->photo)

                        <img
                            src="{{ asset('storage/' . $student->photo) }}"
                            alt="{{ $student->name }}"
                        >

                    @else

                        {{ strtoupper(substr($student->name, 0, 1)) }}

                    @endif

                </div>

                <div>

                    <span class="student-label">
                        STUDENT
                    </span>

                    <h3>
                        {{ $student->name }}
                    </h3>

                    <p>
                        {{ $student->student_id }}
                        ·
                        {{ $student->classRoom?->class_name ?? 'No Class' }}
                    </p>

                </div>

            </div>


            {{-- Summary --}}
            <div class="summary-grid">

                <div class="summary-card">

                    <div class="summary-icon total-icon">
                        <i class="fa-solid fa-calendar-days"></i>
                    </div>

                    <div>
                        <span>Total Records</span>
                        <strong>{{ $totalAttendance }}</strong>
                        <small>Attendance entries</small>
                    </div>

                </div>


                <div class="summary-card">

                    <div class="summary-icon present-icon">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>

                    <div>
                        <span>Present</span>
                        <strong>{{ $presentCount }}</strong>
                        <small>Days attended</small>
                    </div>

                </div>


                <div class="summary-card">

                    <div class="summary-icon absent-icon">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </div>

                    <div>
                        <span>Absent</span>
                        <strong>{{ $absentCount }}</strong>
                        <small>Days absent</small>
                    </div>

                </div>


                <div class="summary-card">

                    <div class="summary-icon leave-icon">
                        <i class="fa-solid fa-clock"></i>
                    </div>

                    <div>
                        <span>Leave</span>
                        <strong>{{ $leaveCount }}</strong>
                        <small>Leave records</small>
                    </div>

                </div>

            </div>


            {{-- Percentage --}}
            <div class="percentage-card">

                <div class="percentage-circle">

                    <div class="percentage-inner">

                        <strong>
                            {{ number_format($attendancePercentage, 1) }}%
                        </strong>

                        <span>
                            Attendance
                        </span>

                    </div>

                </div>


                <div class="percentage-content">

                    <span class="section-label">
                        PERFORMANCE
                    </span>

                    <h2>
                        Attendance Percentage
                    </h2>

                    <p>
                        Overall attendance performance based on recorded days.
                    </p>


                    <div class="progress-heading">

                        <span>
                            Present Days
                        </span>

                        <strong>
                            {{ $presentCount }} / {{ $totalAttendance }}
                        </strong>

                    </div>


                    <div class="progress-bar">

                        <div
                            class="progress-fill"
                            style="width: {{ min($attendancePercentage, 100) }}%;"
                        ></div>

                    </div>

                </div>

            </div>


            {{-- Attendance History --}}
            <div class="attendance-card">

                <div class="card-heading">

                    <div>

                        <span class="section-label">
                            HISTORY
                        </span>

                        <h2>
                            Attendance Records
                        </h2>

                        <p>
                            Filter attendance by status, month or year.
                        </p>

                    </div>


                    <span class="record-count">

                        <i class="fa-solid fa-list"></i>

                        {{ $attendances->total() }}
                        Records

                    </span>

                </div>


                {{-- Filters --}}
                <form
                    method="GET"
                    action="{{ route('parent.attendance.index') }}"
                    class="filter-form"
                >

                    <div class="filter-group">

                        <label>Status</label>

                        <select name="status">

                            <option value="">
                                All Statuses
                            </option>

                            <option
                                value="Present"
                                {{ request('status') === 'Present' ? 'selected' : '' }}
                            >
                                Present
                            </option>

                            <option
                                value="Absent"
                                {{ request('status') === 'Absent' ? 'selected' : '' }}
                            >
                                Absent
                            </option>

                            <option
                                value="Leave"
                                {{ request('status') === 'Leave' ? 'selected' : '' }}
                            >
                                Leave
                            </option>

                        </select>

                    </div>


                    <div class="filter-group">

                        <label>Month</label>

                        <select name="month">

                            <option value="">
                                All Months
                            </option>

                            @foreach(range(1, 12) as $month)

                                <option
                                    value="{{ $month }}"
                                    {{ (string) request('month') === (string) $month ? 'selected' : '' }}
                                >
                                    {{ \Carbon\Carbon::create()->month($month)->format('F') }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    <div class="filter-group">

                        <label>Year</label>

                        <select name="year">

                            <option value="">
                                All Years
                            </option>

                            @foreach($years as $year)

                                <option
                                    value="{{ $year }}"
                                    {{ (string) request('year') === (string) $year ? 'selected' : '' }}
                                >
                                    {{ $year }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    <div class="filter-actions">

                        <button
                            type="submit"
                            class="filter-btn"
                        >
                            <i class="fa-solid fa-filter"></i>
                            Filter
                        </button>

                        <a
                            href="{{ route('parent.attendance.index') }}"
                            class="reset-btn"
                        >
                            <i class="fa-solid fa-rotate-left"></i>
                            Reset
                        </a>

                    </div>

                </form>


                @if($attendances->count())

                    <div class="attendance-table-wrapper">

                        <table class="attendance-table">

                            <thead>

                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Day</th>
                                    <th>Status</th>
                                    <th>Recorded Time</th>
                                </tr>

                            </thead>


                            <tbody>

                                @foreach($attendances as $attendance)

                                    <tr>

                                        <td
                                            data-label="#"
                                            class="serial-number"
                                        >
                                            {{ $loop->iteration + (($attendances->currentPage() - 1) * $attendances->perPage()) }}
                                        </td>


                                        <td data-label="Date">

                                            {{ \Carbon\Carbon::parse(
                                                $attendance->date
                                            )->format('d M Y') }}

                                        </td>


                                        <td data-label="Day">

                                            {{ \Carbon\Carbon::parse(
                                                $attendance->date
                                            )->format('l') }}

                                        </td>


                                        <td data-label="Status">

                                            <span
                                                class="status-badge
                                                @if($attendance->status === 'Present')
                                                    status-present
                                                @elseif($attendance->status === 'Absent')
                                                    status-absent
                                                @else
                                                    status-leave
                                                @endif"
                                            >
                                                {{ $attendance->status }}
                                            </span>

                                        </td>


                                        <td data-label="Recorded Time">

                                            {{ $attendance->created_at?->format('h:i A') ?? 'N/A' }}

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>


                    <div class="pagination-wrapper">
                        {{ $attendances->links() }}
                    </div>

                @else

                    <div class="empty-state">

                        <div class="empty-icon">
                            <i class="fa-solid fa-calendar-xmark"></i>
                        </div>

                        <h3>
                            No Attendance Records
                        </h3>

                        <p>
                            No attendance records match the selected filters.
                        </p>

                    </div>

                @endif

            </div>

        </div>

    </div>


    <style>

        :root {
            --att-bg: #f4f7fb;
            --att-card: #ffffff;
            --att-secondary: #f8fafc;
            --att-text: #0f172a;
            --att-muted: #64748b;
            --att-soft: #94a3b8;
            --att-border: #e2e8f0;
            --att-primary: #2563eb;
            --att-shadow:
                0 8px 25px rgba(15, 23, 42, .05);
        }

        html.dark-mode {
            --att-bg: #090e1a;
            --att-card: #111827;
            --att-secondary: #172033;
            --att-text: #f8fafc;
            --att-muted: #a7b2c5;
            --att-soft: #75829a;
            --att-border: #253047;
            --att-primary: #60a5fa;
            --att-shadow:
                0 10px 30px rgba(0, 0, 0, .25);
        }

        body {
            background: var(--att-bg);
        }

        .attendance-page-header {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .attendance-page-header h2 {
            margin: 0 0 4px;
            color: var(--att-text);
            font-size: 21px;
            font-weight: 750;
        }

        .attendance-page-header p {
            margin: 0;
            color: var(--att-muted);
            font-size: 12px;
        }

        .back-btn {
            padding: 10px 15px;
            border-radius: 11px;
            background: var(--att-secondary);
            color: var(--att-muted);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 700;
            transition: transform .25s ease;
        }

        .back-btn:hover {
            transform: translateY(-2px);
        }

        .attendance-page {
            min-height: calc(100vh - 70px);
            padding: 30px 20px 50px;
            background:
                radial-gradient(
                    circle at 10% 10%,
                    rgba(37, 99, 235, .05),
                    transparent 28%
                ),
                var(--att-bg);
        }

        .attendance-container {
            width: 100%;
            max-width: 1250px;
            margin: auto;
        }

        .student-card,
        .summary-card,
        .percentage-card,
        .attendance-card {
            border: 1px solid var(--att-border);
            background: var(--att-card);
            box-shadow: var(--att-shadow);
            transition:
                background .35s ease,
                border-color .35s ease,
                transform .25s ease;
        }

        .student-card {
            margin-bottom: 18px;
            padding: 17px;
            border-radius: 17px;
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .student-avatar {
            width: 54px;
            height: 54px;
            flex-shrink: 0;
            overflow: hidden;
            border-radius: 14px;
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
            font-size: 19px;
            font-weight: 800;
        }

        .student-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .student-label {
            display: block;
            margin-bottom: 2px;
            color: var(--att-primary);
            font-size: 8px;
            font-weight: 800;
            letter-spacing: 1px;
        }

        .student-card h3 {
            margin: 0 0 2px;
            color: var(--att-text);
            font-size: 14px;
            font-weight: 750;
        }

        .student-card p {
            margin: 0;
            color: var(--att-muted);
            font-size: 10px;
        }

        .summary-grid {
            margin-bottom: 18px;
            display: grid;
            grid-template-columns:
                repeat(4, minmax(0, 1fr));
            gap: 15px;
        }

        .summary-card {
            min-height: 105px;
            padding: 17px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .summary-card:hover {
            transform: translateY(-4px);
        }

        .summary-icon {
            width: 46px;
            height: 46px;
            flex-shrink: 0;
            border-radius: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
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

        html.dark-mode .total-icon {
            color: #60a5fa;
            background: rgba(37, 99, 235, .16);
        }

        html.dark-mode .present-icon {
            color: #4ade80;
            background: rgba(34, 197, 94, .14);
        }

        html.dark-mode .absent-icon {
            color: #f87171;
            background: rgba(239, 68, 68, .14);
        }

        html.dark-mode .leave-icon {
            color: #fb923c;
            background: rgba(249, 115, 22, .14);
        }

        .summary-card span {
            display: block;
            margin-bottom: 2px;
            color: var(--att-muted);
            font-size: 10px;
            font-weight: 600;
        }

        .summary-card strong {
            display: block;
            margin-bottom: 2px;
            color: var(--att-text);
            font-size: 18px;
            font-weight: 800;
        }

        .summary-card small {
            color: var(--att-soft);
            font-size: 8px;
        }

        .percentage-card {
            margin-bottom: 18px;
            padding: 22px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .percentage-circle {
            width: 145px;
            height: 145px;
            padding: 11px;
            flex-shrink: 0;
            border-radius: 50%;
            background:
                conic-gradient(
                    #2563eb {{ min($attendancePercentage, 100) }}%,
                    var(--att-border) 0
                );
        }

        .percentage-inner {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: var(--att-card);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .percentage-inner strong {
            color: var(--att-text);
            font-size: 25px;
            font-weight: 800;
        }

        .percentage-inner span {
            color: var(--att-muted);
            font-size: 9px;
        }

        .percentage-content {
            flex: 1;
        }

        .section-label {
            display: block;
            margin-bottom: 3px;
            color: var(--att-primary);
            font-size: 8px;
            font-weight: 800;
            letter-spacing: 1.2px;
        }

        .percentage-content h2 {
            margin: 0 0 4px;
            color: var(--att-text);
            font-size: 17px;
            font-weight: 750;
        }

        .percentage-content p {
            margin: 0 0 17px;
            color: var(--att-soft);
            font-size: 10px;
        }

        .progress-heading {
            margin-bottom: 7px;
            display: flex;
            justify-content: space-between;
            color: var(--att-muted);
            font-size: 10px;
        }

        .progress-heading strong {
            color: var(--att-text);
        }

        .progress-bar {
            width: 100%;
            height: 9px;
            border-radius: 20px;
            background: var(--att-border);
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            border-radius: 20px;
            background:
                linear-gradient(
                    90deg,
                    #2563eb,
                    #60a5fa
                );
        }

        .attendance-card {
            overflow: hidden;
            border-radius: 19px;
        }

        .card-heading {
            padding: 21px 23px;
            border-bottom: 1px solid var(--att-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
        }

        .card-heading h2 {
            margin: 0 0 3px;
            color: var(--att-text);
            font-size: 17px;
            font-weight: 750;
        }

        .card-heading p {
            margin: 0;
            color: var(--att-soft);
            font-size: 10px;
        }

        .record-count {
            padding: 6px 10px;
            border-radius: 20px;
            color: #2563eb;
            background: #dbeafe;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 9px;
            font-weight: 700;
            white-space: nowrap;
        }

        html.dark-mode .record-count {
            color: #60a5fa;
            background: rgba(37, 99, 235, .15);
        }

        .filter-form {
            padding: 17px 23px;
            border-bottom: 1px solid var(--att-border);
            background: var(--att-secondary);
            display: flex;
            align-items: flex-end;
            gap: 12px;
        }

        .filter-group {
            min-width: 170px;
        }

        .filter-group label {
            display: block;
            margin-bottom: 5px;
            color: var(--att-muted);
            font-size: 9px;
            font-weight: 700;
        }

        .filter-group select {
            width: 100%;
            height: 39px;
            padding: 0 11px;
            border: 1px solid var(--att-border);
            border-radius: 9px;
            outline: none;
            background: var(--att-card);
            color: var(--att-text);
            font-size: 11px;
        }

        .filter-actions {
            display: flex;
            gap: 7px;
        }

        .filter-btn,
        .reset-btn {
            min-height: 39px;
            padding: 0 13px;
            border-radius: 9px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            text-decoration: none;
            font-size: 10px;
            font-weight: 700;
            cursor: pointer;
        }

        .filter-btn {
            border: none;
            background: #2563eb;
            color: white;
        }

        .reset-btn {
            border: 1px solid var(--att-border);
            background: var(--att-card);
            color: var(--att-muted);
        }

        .attendance-table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        .attendance-table {
            width: 100%;
            min-width: 700px;
            border-collapse: collapse;
        }

        .attendance-table thead {
            background: var(--att-secondary);
        }

        .attendance-table th {
            padding: 13px 18px;
            border-bottom: 1px solid var(--att-border);
            color: var(--att-muted);
            font-size: 10px;
            font-weight: 750;
            text-align: left;
            text-transform: uppercase;
        }

        .attendance-table td {
            padding: 14px 18px;
            border-bottom: 1px solid var(--att-border);
            color: var(--att-text);
            font-size: 11px;
        }

        .attendance-table tbody tr:hover {
            background: var(--att-secondary);
        }

        .status-badge {
            min-width: 75px;
            padding: 5px 10px;
            border-radius: 20px;
            display: inline-flex;
            justify-content: center;
            font-size: 9px;
            font-weight: 700;
        }

        .status-present {
            color: #15803d;
            background: #dcfce7;
        }

        .status-absent {
            color: #b91c1c;
            background: #fee2e2;
        }

        .status-leave {
            color: #c2410c;
            background: #ffedd5;
        }

        html.dark-mode .status-present {
            color: #4ade80;
            background: rgba(34, 197, 94, .14);
        }

        html.dark-mode .status-absent {
            color: #f87171;
            background: rgba(239, 68, 68, .14);
        }

        html.dark-mode .status-leave {
            color: #fb923c;
            background: rgba(249, 115, 22, .14);
        }

        .pagination-wrapper {
            padding: 17px 22px;
            border-top: 1px solid var(--att-border);
        }

        .empty-state {
            padding: 60px 20px;
            text-align: center;
        }

        .empty-icon {
            width: 65px;
            height: 65px;
            margin: 0 auto 13px;
            border-radius: 18px;
            background: var(--att-secondary);
            color: var(--att-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .empty-state h3 {
            margin: 0 0 5px;
            color: var(--att-text);
            font-size: 16px;
        }

        .empty-state p {
            margin: 0;
            color: var(--att-muted);
            font-size: 11px;
        }

        @media (max-width: 950px) {

            .summary-grid {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }

        }

        @media (max-width: 650px) {

            .attendance-page {
                padding: 20px 12px 35px;
            }

            .attendance-page-header {
                flex-direction: column;
                align-items: stretch;
            }

            .back-btn {
                width: 100%;
            }

            .summary-grid {
                grid-template-columns: 1fr 1fr;
                gap: 10px;
            }

            .summary-card {
                min-height: 95px;
                padding: 13px;
            }

            .summary-card small {
                display: none;
            }

            .percentage-card {
                flex-direction: column;
                text-align: center;
            }

            .percentage-content {
                width: 100%;
            }

            .percentage-content p {
                text-align: center;
            }

            .progress-heading {
                text-align: left;
            }

            .card-heading {
                align-items: flex-start;
                padding: 18px;
            }

            .filter-form {
                padding: 15px;
                flex-direction: column;
                align-items: stretch;
            }

            .filter-group {
                width: 100%;
                min-width: 0;
            }

            .filter-actions {
                width: 100%;
            }

            .filter-btn,
            .reset-btn {
                flex: 1;
            }

            .attendance-table-wrapper {
                padding: 12px;
                overflow: visible;
            }

            .attendance-table,
            .attendance-table tbody,
            .attendance-table tr,
            .attendance-table td {
                display: block;
                width: 100%;
            }

            .attendance-table {
                min-width: 0;
            }

            .attendance-table thead {
                display: none;
            }

            .attendance-table tr {
                margin-bottom: 11px;
                border: 1px solid var(--att-border);
                border-radius: 12px;
                overflow: hidden;
            }

            .attendance-table td {
                position: relative;
                min-height: 38px;
                padding: 9px 10px 9px 43%;
                border-bottom: 1px solid var(--att-border);
            }

            .attendance-table td:last-child {
                border-bottom: none;
            }

            .attendance-table td::before {
                content: attr(data-label);
                position: absolute;
                left: 10px;
                top: 9px;
                width: 35%;
                color: var(--att-muted);
                font-size: 8px;
                font-weight: 750;
            }

        }

        @media (max-width: 420px) {

            .summary-grid {
                grid-template-columns: 1fr;
            }

        }

    </style>

</x-app-layout>