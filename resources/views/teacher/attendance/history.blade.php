<x-app-layout>

    <x-slot name="header">
        <div class="page-header">
            <div>
                <h2>Attendance History</h2>
                <p>View previous attendance records of your assigned class</p>
            </div>

            <div class="header-actions">
                <a href="{{ route('teacher.attendance') }}" class="mark-button">
                    Mark Attendance
                </a>

                <a href="{{ route('dashboard') }}" class="back-button">
                    Back to Dashboard
                </a>
            </div>
        </div>
    </x-slot>


    <div class="history-page">

        <div class="history-container">

            {{-- Top Information --}}
            <div class="information-card">

                <div class="teacher-info">

                    <div class="teacher-avatar">

                        @if($teacher && $teacher->photo)
                            <img
                                src="{{ asset('storage/' . $teacher->photo) }}"
                                alt="{{ $teacher->name }}"
                            >
                        @else
                            <span>
                                {{ strtoupper(substr($teacher->name ?? auth()->user()->name, 0, 1)) }}
                            </span>
                        @endif

                    </div>

                    <div>
                        <p class="small-title">Class Teacher</p>

                        <h2>
                            {{ $teacher->name ?? auth()->user()->name }}
                        </h2>

                        <p class="teacher-email">
                            {{ $teacher->email ?? auth()->user()->email }}
                        </p>
                    </div>

                </div>


                <div class="class-info">

                    <div>
                        <p>Assigned Class</p>

                        <strong>
                            {{ $teacher?->classRoom?->class_name ?? 'Not Assigned' }}
                        </strong>
                    </div>

                    <div>
                        <p>Selected Date</p>

                        <strong>
                            {{ \Carbon\Carbon::parse($selectedDate)->format('d F Y') }}
                        </strong>
                    </div>

                </div>

            </div>


            {{-- Date Filter --}}
            <div class="filter-card">

                <form
                    action="{{ route('teacher.attendance.history') }}"
                    method="GET"
                    class="filter-form"
                >

                    <div class="filter-group">
                        <label for="date">Select Attendance Date</label>

                        <input
                            type="date"
                            name="date"
                            id="date"
                            value="{{ $selectedDate }}"
                            max="{{ now()->toDateString() }}"
                        >
                    </div>


                    <button type="submit" class="filter-button">
                        View Attendance
                    </button>


                    <a
                        href="{{ route('teacher.attendance.history') }}"
                        class="today-button"
                    >
                        Today
                    </a>

                </form>

            </div>


            @php
                $presentCount = $attendances
                    ->where('status', 'Present')
                    ->count();

                $absentCount = $attendances
                    ->where('status', 'Absent')
                    ->count();

                $leaveCount = $attendances
                    ->where('status', 'Leave')
                    ->count();
            @endphp


            {{-- Statistics --}}
            <div class="statistics-grid">

                <div class="statistic-card total-card">
                    <div class="statistic-icon">
                        👨‍🎓
                    </div>

                    <div>
                        <p>Total Records</p>
                        <h3>{{ $attendances->count() }}</h3>
                    </div>
                </div>


                <div class="statistic-card present-card">
                    <div class="statistic-icon">
                        ✓
                    </div>

                    <div>
                        <p>Present</p>
                        <h3>{{ $presentCount }}</h3>
                    </div>
                </div>


                <div class="statistic-card absent-card">
                    <div class="statistic-icon">
                        ✕
                    </div>

                    <div>
                        <p>Absent</p>
                        <h3>{{ $absentCount }}</h3>
                    </div>
                </div>


                <div class="statistic-card leave-card">
                    <div class="statistic-icon">
                        ◷
                    </div>

                    <div>
                        <p>Leave</p>
                        <h3>{{ $leaveCount }}</h3>
                    </div>
                </div>

            </div>


            {{-- Attendance Table --}}
            <div class="history-card">

                <div class="history-card-header">

                    <div>
                        <h2>
                            Attendance Records
                        </h2>

                        <p>
                            Records for
                            {{ \Carbon\Carbon::parse($selectedDate)->format('d F Y') }}
                        </p>
                    </div>


                    @if($attendances->isNotEmpty())
                        <div class="search-box">
                            <span>⌕</span>

                            <input
                                type="text"
                                id="studentSearch"
                                placeholder="Search student..."
                                onkeyup="searchStudents()"
                            >
                        </div>
                    @endif

                </div>


                @if($attendances->isNotEmpty())

                    <div class="table-container">

                        <table class="history-table">

                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Student</th>
                                    <th>Student ID</th>
                                    <th>Status</th>
                                    <th>Attendance Date</th>
                                    <th>Recorded Time</th>
                                </tr>
                            </thead>


                            <tbody id="attendanceTableBody">

                                @foreach($attendances as $attendance)

                                    <tr
                                        class="attendance-row"
                                        data-name="{{ strtolower($attendance->student?->name ?? '') }}"
                                        data-student-id="{{ strtolower($attendance->student?->student_id ?? '') }}"
                                    >

                                        <td class="serial-number">
                                            {{ $loop->iteration }}
                                        </td>


                                        <td>
                                            <div class="student-profile">

                                                <div class="student-avatar">

                                                    @if($attendance->student?->photo)
                                                        <img
                                                            src="{{ asset('storage/' . $attendance->student->photo) }}"
                                                            alt="{{ $attendance->student->name }}"
                                                        >
                                                    @else
                                                        <span>
                                                            {{ strtoupper(substr($attendance->student?->name ?? 'S', 0, 1)) }}
                                                        </span>
                                                    @endif

                                                </div>


                                                <div>
                                                    <strong>
                                                        {{ $attendance->student?->name ?? 'Student Not Found' }}
                                                    </strong>

                                                    <small>
                                                        {{ $teacher?->classRoom?->class_name ?? 'Class' }}
                                                    </small>
                                                </div>

                                            </div>
                                        </td>


                                        <td>
                                            <span class="student-id">
                                                {{ $attendance->student?->student_id ?? 'N/A' }}
                                            </span>
                                        </td>


                                        <td>
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


                                        <td>
                                            {{ \Carbon\Carbon::parse($attendance->date)->format('d M Y') }}
                                        </td>


                                        <td>
                                            {{ $attendance->created_at?->format('h:i A') ?? 'N/A' }}
                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>


                    <div class="table-footer">

                        <p id="resultCount">
                            Showing {{ $attendances->count() }} attendance records
                        </p>

                        <div class="locked-note">
                            🔒 Attendance history is read-only.
                        </div>

                    </div>

                @else

                    <div class="empty-state">

                        <div class="empty-icon">
                            📋
                        </div>

                        <h3>No Attendance Found</h3>

                        <p>
                            No attendance records were found for
                            <strong>
                                {{ \Carbon\Carbon::parse($selectedDate)->format('d F Y') }}
                            </strong>.
                        </p>

                        @if($selectedDate === now()->toDateString())
                            <a href="{{ route('teacher.attendance') }}">
                                Mark Today's Attendance
                            </a>
                        @endif

                    </div>

                @endif

            </div>

        </div>

    </div>


    <style>

        * {
            box-sizing: border-box;
        }

        body {
            background: #f4f7fb;
        }

        .page-header {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 18px;
        }

        .page-header h2 {
            margin: 0 0 4px;
            color: #0f172a;
            font-size: 21px;
            font-weight: 750;
        }

        .page-header p {
            margin: 0;
            color: #64748b;
            font-size: 13px;
        }

        .header-actions {
            display: flex;
            gap: 10px;
        }

        .mark-button,
        .back-button {
            padding: 10px 15px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            transition: 0.2s;
        }

        .mark-button {
            color: white;
            background: #2563eb;
            border: 1px solid #2563eb;
        }

        .mark-button:hover {
            background: #1d4ed8;
        }

        .back-button {
            color: #334155;
            background: white;
            border: 1px solid #dbe4f0;
        }

        .back-button:hover {
            color: #1d4ed8;
            background: #eff6ff;
            border-color: #93c5fd;
        }

        .history-page {
            min-height: calc(100vh - 70px);
            padding: 30px 20px 50px;
        }

        .history-container {
            width: 100%;
            max-width: 1350px;
            margin: auto;
        }

        .information-card {
            margin-bottom: 20px;
            padding: 25px 28px;
            border-radius: 20px;
            color: white;
            background: linear-gradient(135deg, #172554, #2563eb);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 25px;
            box-shadow: 0 15px 35px rgba(37, 99, 235, 0.18);
        }

        .teacher-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .teacher-avatar {
            width: 67px;
            height: 67px;
            border: 3px solid rgba(255, 255, 255, 0.25);
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.15);
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 27px;
            font-weight: 800;
        }

        .teacher-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .small-title {
            margin: 0 0 3px;
            opacity: 0.75;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }

        .teacher-info h2 {
            margin: 0 0 4px;
            font-size: 21px;
            font-weight: 750;
        }

        .teacher-email {
            margin: 0;
            opacity: 0.82;
            font-size: 12px;
        }

        .class-info {
            display: flex;
            gap: 12px;
        }

        .class-info > div {
            min-width: 175px;
            padding: 14px 16px;
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.1);
        }

        .class-info p {
            margin: 0 0 3px;
            opacity: 0.75;
            font-size: 11px;
        }

        .class-info strong {
            display: block;
            font-size: 13px;
        }

        .filter-card {
            margin-bottom: 20px;
            padding: 20px 23px;
            border: 1px solid #e4eaf2;
            border-radius: 17px;
            background: white;
            box-shadow: 0 7px 22px rgba(15, 23, 42, 0.045);
        }

        .filter-form {
            display: flex;
            align-items: flex-end;
            gap: 12px;
        }

        .filter-group {
            width: 100%;
            max-width: 320px;
        }

        .filter-group label {
            display: block;
            margin-bottom: 7px;
            color: #475569;
            font-size: 12px;
            font-weight: 700;
        }

        .filter-group input {
            width: 100%;
            height: 43px;
            padding: 0 13px;
            border: 1px solid #dce4ee;
            border-radius: 10px;
            outline: none;
            color: #334155;
            background: white;
            font-size: 13px;
        }

        .filter-group input:focus {
            border-color: #60a5fa;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .filter-button,
        .today-button {
            height: 43px;
            padding: 0 18px;
            border-radius: 10px;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
        }

        .filter-button {
            border: none;
            color: white;
            background: #2563eb;
        }

        .filter-button:hover {
            background: #1d4ed8;
        }

        .today-button {
            border: 1px solid #dbe4f0;
            color: #475569;
            background: #f8fafc;
        }

        .today-button:hover {
            color: #1d4ed8;
            border-color: #93c5fd;
            background: #eff6ff;
        }

        .statistics-grid {
            margin-bottom: 20px;
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 17px;
        }

        .statistic-card {
            padding: 19px;
            border: 1px solid #e4eaf2;
            border-radius: 17px;
            background: white;
            display: flex;
            align-items: center;
            gap: 14px;
            box-shadow: 0 7px 22px rgba(15, 23, 42, 0.045);
        }

        .statistic-icon {
            width: 49px;
            height: 49px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 20px;
            font-weight: 800;
        }

        .statistic-card p {
            margin: 0 0 3px;
            color: #64748b;
            font-size: 12px;
        }

        .statistic-card h3 {
            margin: 0;
            color: #0f172a;
            font-size: 22px;
            font-weight: 800;
        }

        .total-card .statistic-icon {
            color: #2563eb;
            background: #dbeafe;
        }

        .present-card .statistic-icon {
            color: #15803d;
            background: #dcfce7;
        }

        .absent-card .statistic-icon {
            color: #dc2626;
            background: #fee2e2;
        }

        .leave-card .statistic-icon {
            color: #c2410c;
            background: #ffedd5;
        }

        .history-card {
            border: 1px solid #e4eaf2;
            border-radius: 20px;
            background: white;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.055);
        }

        .history-card-header {
            padding: 22px 25px;
            border-bottom: 1px solid #edf1f6;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 18px;
        }

        .history-card-header h2 {
            margin: 0 0 4px;
            color: #0f172a;
            font-size: 18px;
            font-weight: 750;
        }

        .history-card-header p {
            margin: 0;
            color: #64748b;
            font-size: 12px;
        }

        .search-box {
            width: 100%;
            max-width: 330px;
            height: 41px;
            padding: 0 13px;
            border: 1px solid #dce4ee;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .search-box span {
            color: #94a3b8;
            font-size: 20px;
        }

        .search-box input {
            width: 100%;
            height: 100%;
            border: none;
            outline: none;
            color: #334155;
            background: transparent;
            font-size: 12px;
        }

        .search-box:focus-within {
            border-color: #60a5fa;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .table-container {
            width: 100%;
            overflow-x: auto;
        }

        .history-table {
            width: 100%;
            min-width: 850px;
            border-collapse: collapse;
        }

        .history-table thead {
            background: #f8fafc;
        }

        .history-table th {
            padding: 13px 17px;
            border-bottom: 1px solid #e7edf4;
            color: #64748b;
            font-size: 11px;
            font-weight: 750;
            text-align: left;
            text-transform: uppercase;
            letter-spacing: 0.45px;
        }

        .history-table td {
            padding: 14px 17px;
            border-bottom: 1px solid #edf1f6;
            color: #334155;
            font-size: 13px;
            vertical-align: middle;
        }

        .history-table tbody tr:hover {
            background: #fafcff;
        }

        .history-table tbody tr:last-child td {
            border-bottom: none;
        }

        .serial-number {
            width: 45px;
            color: #94a3b8 !important;
            font-weight: 600;
        }

        .student-profile {
            min-width: 190px;
            display: flex;
            align-items: center;
            gap: 11px;
        }

        .student-avatar {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            color: #1d4ed8;
            background: #dbeafe;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-weight: 800;
        }

        .student-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .student-profile strong {
            display: block;
            margin-bottom: 2px;
            color: #172033;
            font-size: 13px;
            font-weight: 700;
        }

        .student-profile small {
            display: block;
            color: #94a3b8;
            font-size: 11px;
        }

        .student-id {
            padding: 5px 9px;
            border-radius: 7px;
            color: #475569;
            background: #f1f5f9;
            font-size: 11px;
            font-weight: 650;
        }

        .status-badge {
            min-width: 75px;
            padding: 6px 11px;
            border-radius: 20px;
            display: inline-flex;
            justify-content: center;
            font-size: 11px;
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

        .table-footer {
            padding: 16px 22px;
            border-top: 1px solid #edf1f6;
            background: #fbfcfe;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
        }

        .table-footer p {
            margin: 0;
            color: #64748b;
            font-size: 11px;
        }

        .locked-note {
            padding: 6px 10px;
            border-radius: 8px;
            color: #475569;
            background: #f1f5f9;
            font-size: 11px;
            font-weight: 650;
        }

        .empty-state {
            padding: 70px 20px;
            text-align: center;
        }

        .empty-icon {
            width: 78px;
            height: 78px;
            margin: 0 auto 17px;
            border-radius: 22px;
            background: #eff6ff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 34px;
        }

        .empty-state h3 {
            margin: 0 0 7px;
            color: #0f172a;
            font-size: 19px;
        }

        .empty-state p {
            max-width: 450px;
            margin: 0 auto 20px;
            color: #64748b;
            font-size: 13px;
            line-height: 1.6;
        }

        .empty-state a {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 10px;
            color: white;
            background: #2563eb;
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
        }

        @media (max-width: 992px) {

            .information-card {
                align-items: flex-start;
                flex-direction: column;
            }

            .class-info {
                width: 100%;
            }

            .class-info > div {
                flex: 1;
            }

            .statistics-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 650px) {

            .history-page {
                padding: 20px 12px 35px;
            }

            .page-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .header-actions {
                width: 100%;
            }

            .mark-button,
            .back-button {
                flex: 1;
                text-align: center;
            }

            .information-card {
                padding: 21px;
                border-radius: 17px;
            }

            .teacher-avatar {
                width: 57px;
                height: 57px;
                border-radius: 15px;
            }

            .teacher-info h2 {
                font-size: 17px;
            }

            .class-info {
                flex-direction: column;
            }

            .class-info > div {
                width: 100%;
                min-width: 0;
            }

            .filter-form {
                align-items: stretch;
                flex-direction: column;
            }

            .filter-group {
                max-width: none;
            }

            .statistics-grid {
                grid-template-columns: 1fr 1fr;
                gap: 11px;
            }

            .statistic-card {
                padding: 14px;
                gap: 10px;
            }

            .statistic-icon {
                width: 40px;
                height: 40px;
                border-radius: 11px;
                font-size: 16px;
            }

            .statistic-card h3 {
                font-size: 18px;
            }

            .history-card-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .search-box {
                max-width: none;
            }

            .table-footer {
                align-items: flex-start;
                flex-direction: column;
            }
        }

    </style>


    <script>

        function searchStudents() {

            const searchInput = document.getElementById('studentSearch');

            if (!searchInput) {
                return;
            }

            const searchValue = searchInput.value
                .toLowerCase()
                .trim();

            const rows = document.querySelectorAll('.attendance-row');

            let visibleRecords = 0;

            rows.forEach(function(row) {

                const studentName = row.dataset.name || '';
                const studentId = row.dataset.studentId || '';

                const matched =
                    studentName.includes(searchValue) ||
                    studentId.includes(searchValue);

                row.style.display = matched ? '' : 'none';

                if (matched) {
                    visibleRecords++;
                }
            });

            const resultCount = document.getElementById('resultCount');

            if (resultCount) {
                resultCount.textContent =
                    'Showing ' + visibleRecords + ' attendance records';
            }
        }

    </script>

</x-app-layout>