<x-app-layout>

    <x-slot name="header">
        <div class="page-header">
            <div>
                <h2>Student Attendance</h2>
                <p>Mark attendance for your assigned class</p>
            </div>

            <a href="{{ route('dashboard') }}" class="back-button">
                ← Back to Dashboard
            </a>
        </div>
    </x-slot>


    <div class="attendance-page">

        <div class="attendance-container">

            {{-- Success Message --}}
            @if(session('success'))
                <div class="alert alert-success">
                    <span class="alert-icon">✓</span>

                    <div>
                        <strong>Success!</strong>
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
            @endif


            {{-- Warning Message --}}
            @if(session('warning'))
                <div class="alert alert-warning">
                    <span class="alert-icon">!</span>

                    <div>
                        <strong>Attention</strong>
                        <p>{{ session('warning') }}</p>
                    </div>
                </div>
            @endif


            {{-- Validation Errors --}}
            @if($errors->any())
                <div class="alert alert-danger">
                    <span class="alert-icon">!</span>

                    <div>
                        <strong>Attendance could not be saved.</strong>

                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            @endif


            {{-- Top Information Card --}}
            <div class="attendance-info-card">

                <div class="teacher-information">

                    <div class="teacher-avatar">
                        @if(isset($teacher) && $teacher->photo)
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
                        <p class="small-label">Class Teacher</p>

                        <h2>
                            {{ $teacher->name ?? auth()->user()->name }}
                        </h2>

                        <p class="teacher-email">
                            {{ $teacher->email ?? auth()->user()->email }}
                        </p>
                    </div>

                </div>


                <div class="class-date-information">

                    <div class="information-box">
                        <span class="information-icon">🏫</span>

                        <div>
                            <p>Assigned Class</p>

                            <strong>
                                {{ $teacher?->classRoom?->class_name ?? 'Not Assigned' }}
                            </strong>
                        </div>
                    </div>


                    <div class="information-box">
                        <span class="information-icon">📅</span>

                        <div>
                            <p>Attendance Date</p>
                            <strong>{{ now()->format('d F Y') }}</strong>
                        </div>
                    </div>

                </div>

            </div>


            {{-- Attendance Statistics --}}
            <div class="statistics-grid">

                <div class="statistic-card total-card">
                    <div class="statistic-icon">👨‍🎓</div>

                    <div>
                        <p>Total Students</p>
                        <h3 id="totalCount">{{ $students->count() }}</h3>
                    </div>
                </div>


                <div class="statistic-card present-card">
                    <div class="statistic-icon">✓</div>

                    <div>
                        <p>Present</p>
                        <h3 id="presentCount">{{ $students->count() }}</h3>
                    </div>
                </div>


                <div class="statistic-card absent-card">
                    <div class="statistic-icon">✕</div>

                    <div>
                        <p>Absent</p>
                        <h3 id="absentCount">0</h3>
                    </div>
                </div>


                <div class="statistic-card leave-card">
                    <div class="statistic-icon">◷</div>

                    <div>
                        <p>Leave</p>
                        <h3 id="leaveCount">0</h3>
                    </div>
                </div>

            </div>


            {{-- Attendance Form Card --}}
            <div class="attendance-card">

                <div class="attendance-card-header">

                    <div>
                        <h2>Mark Today's Attendance</h2>

                        <p>
                            Select the attendance status for every student.
                        </p>
                    </div>


                    @if($students->isNotEmpty())
                        <button
                            type="button"
                            class="mark-all-button"
                            onclick="markAllStudents('Present')"
                        >
                            ✓ Mark All Present
                        </button>
                    @endif

                </div>


                @if($students->isNotEmpty())

                    {{-- Search --}}
                    <div class="search-area">

                        <div class="search-box">
                            <span>⌕</span>

                            <input
                                type="text"
                                id="studentSearch"
                                placeholder="Search student by name or ID..."
                                onkeyup="searchStudents()"
                            >
                        </div>

                        <p id="searchResultCount">
                            Showing {{ $students->count() }} students
                        </p>

                    </div>


                    <form
                        action="{{ route('teacher.attendance.store') }}"
                        method="POST"
                        id="attendanceForm"
                    >

                        @csrf


                        <div class="table-container">

                            <table class="attendance-table">

                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Student</th>
                                        <th>Student ID</th>
                                        <th>Gender</th>
                                        <th>Attendance Status</th>
                                    </tr>
                                </thead>


                                <tbody id="studentTableBody">

                                    @foreach($students as $student)

                                        <tr
                                            class="student-row"
                                            data-name="{{ strtolower($student->name) }}"
                                            data-student-id="{{ strtolower($student->student_id ?? '') }}"
                                        >

                                            <td class="serial-number">
                                                {{ $loop->iteration }}
                                            </td>


                                            <td>
                                                <div class="student-profile">

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

                                                        <small>
                                                            {{ $teacher?->classRoom?->class_name ?? 'Class' }}
                                                        </small>
                                                    </div>

                                                </div>
                                            </td>


                                            <td>
                                                <span class="student-id">
                                                    {{ $student->student_id ?? 'N/A' }}
                                                </span>
                                            </td>


                                            <td>
                                                <span class="gender-badge">
                                                    {{ $student->gender ?? 'N/A' }}
                                                </span>
                                            </td>


                                            <td>

                                                <div class="attendance-options">

                                                    <input
                                                        type="radio"
                                                        name="attendance[{{ $student->id }}]"
                                                        value="Present"
                                                        id="present_{{ $student->id }}"
                                                        class="attendance-radio"
                                                        checked
                                                        onchange="updateAttendanceCounters()"
                                                    >

                                                    <label
                                                        for="present_{{ $student->id }}"
                                                        class="attendance-label present-label"
                                                    >
                                                        <span>✓</span>
                                                        Present
                                                    </label>


                                                    <input
                                                        type="radio"
                                                        name="attendance[{{ $student->id }}]"
                                                        value="Absent"
                                                        id="absent_{{ $student->id }}"
                                                        class="attendance-radio"
                                                        onchange="updateAttendanceCounters()"
                                                    >

                                                    <label
                                                        for="absent_{{ $student->id }}"
                                                        class="attendance-label absent-label"
                                                    >
                                                        <span>✕</span>
                                                        Absent
                                                    </label>


                                                    <input
                                                        type="radio"
                                                        name="attendance[{{ $student->id }}]"
                                                        value="Leave"
                                                        id="leave_{{ $student->id }}"
                                                        class="attendance-radio"
                                                        onchange="updateAttendanceCounters()"
                                                    >

                                                    <label
                                                        for="leave_{{ $student->id }}"
                                                        class="attendance-label leave-label"
                                                    >
                                                        <span>◷</span>
                                                        Leave
                                                    </label>

                                                </div>

                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>


                        <div class="form-footer">

                            <div class="footer-information">
                                <span>ℹ</span>

                                <p>
                                    Attendance will be saved for
                                    <strong>{{ now()->format('d F Y') }}</strong>.
                                    You can update today's attendance again if required.
                                </p>
                            </div>


                            <button
                                type="submit"
                                class="save-attendance-button"
                                id="saveButton"
                            >
                                <span>✓</span>
                                Save Attendance
                            </button>

                        </div>

                    </form>

                @else

                    {{-- Empty State --}}
                    <div class="empty-state">

                        <div class="empty-icon">👨‍🎓</div>

                        <h3>No Students Found</h3>

                        <p>
                            There are currently no students registered in your
                            assigned class.
                        </p>

                        <a href="{{ route('dashboard') }}">
                            Return to Dashboard
                        </a>

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
            align-items: center;
            justify-content: space-between;
            gap: 15px;
        }

        .page-header h2 {
            margin: 0 0 3px;
            color: #0f172a;
            font-size: 21px;
            font-weight: 750;
        }

        .page-header p {
            margin: 0;
            color: #64748b;
            font-size: 13px;
        }

        .back-button {
            padding: 10px 16px;
            border: 1px solid #dbe4f0;
            border-radius: 10px;
            color: #334155;
            background: white;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: 0.2s ease;
        }

        .back-button:hover {
            color: #1d4ed8;
            border-color: #93c5fd;
            background: #eff6ff;
        }

        .attendance-page {
            min-height: calc(100vh - 70px);
            padding: 30px 20px 50px;
        }

        .attendance-container {
            width: 100%;
            max-width: 1350px;
            margin: auto;
        }

        .alert {
            margin-bottom: 20px;
            padding: 16px 18px;
            border-radius: 13px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            border: 1px solid;
        }

        .alert-icon {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-weight: 800;
        }

        .alert strong {
            display: block;
            margin-bottom: 2px;
            font-size: 14px;
        }

        .alert p {
            margin: 0;
            font-size: 13px;
        }

        .alert-success {
            border-color: #bbf7d0;
            color: #166534;
            background: #f0fdf4;
        }

        .alert-success .alert-icon {
            color: white;
            background: #16a34a;
        }

        .alert-warning {
            border-color: #fde68a;
            color: #92400e;
            background: #fffbeb;
        }

        .alert-warning .alert-icon {
            color: white;
            background: #f59e0b;
        }

        .alert-danger {
            border-color: #fecaca;
            color: #991b1b;
            background: #fef2f2;
        }

        .alert-danger .alert-icon {
            color: white;
            background: #dc2626;
        }

        .attendance-info-card {
            margin-bottom: 22px;
            padding: 25px 28px;
            border-radius: 20px;
            color: white;
            background: linear-gradient(135deg, #172554, #1d4ed8);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 25px;
            box-shadow: 0 15px 35px rgba(29, 78, 216, 0.18);
        }

        .teacher-information {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .teacher-avatar {
            width: 68px;
            height: 68px;
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

        .small-label {
            margin: 0 0 3px;
            opacity: 0.75;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.7px;
        }

        .teacher-information h2 {
            margin: 0 0 4px;
            font-size: 21px;
            font-weight: 750;
        }

        .teacher-email {
            margin: 0;
            opacity: 0.82;
            font-size: 12px;
        }

        .class-date-information {
            display: flex;
            gap: 12px;
        }

        .information-box {
            min-width: 185px;
            padding: 14px 16px;
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 11px;
        }

        .information-icon {
            font-size: 22px;
        }

        .information-box p {
            margin: 0 0 2px;
            opacity: 0.75;
            font-size: 11px;
        }

        .information-box strong {
            display: block;
            font-size: 13px;
        }

        .statistics-grid {
            margin-bottom: 22px;
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

        .attendance-card {
            border: 1px solid #e4eaf2;
            border-radius: 20px;
            background: white;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.055);
        }

        .attendance-card-header {
            padding: 23px 25px;
            border-bottom: 1px solid #edf1f6;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
        }

        .attendance-card-header h2 {
            margin: 0 0 4px;
            color: #0f172a;
            font-size: 18px;
            font-weight: 750;
        }

        .attendance-card-header p {
            margin: 0;
            color: #64748b;
            font-size: 12px;
        }

        .mark-all-button {
            padding: 10px 16px;
            border: 1px solid #86efac;
            border-radius: 10px;
            color: #15803d;
            background: #f0fdf4;
            cursor: pointer;
            font-size: 12px;
            font-weight: 700;
            transition: 0.2s;
        }

        .mark-all-button:hover {
            color: white;
            background: #16a34a;
        }

        .search-area {
            padding: 17px 25px;
            border-bottom: 1px solid #edf1f6;
            background: #fbfcfe;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
        }

        .search-box {
            width: 100%;
            max-width: 430px;
            height: 42px;
            padding: 0 14px;
            border: 1px solid #dce4ee;
            border-radius: 11px;
            background: white;
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .search-box span {
            color: #94a3b8;
            font-size: 21px;
        }

        .search-box input {
            width: 100%;
            height: 100%;
            padding: 0;
            border: none;
            outline: none;
            color: #334155;
            background: transparent;
            font-size: 13px;
        }

        .search-box:focus-within {
            border-color: #60a5fa;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        #searchResultCount {
            margin: 0;
            color: #64748b;
            font-size: 12px;
        }

        .table-container {
            width: 100%;
            overflow-x: auto;
        }

        .attendance-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 900px;
        }

        .attendance-table thead {
            background: #f8fafc;
        }

        .attendance-table th {
            padding: 13px 17px;
            border-bottom: 1px solid #e7edf4;
            color: #64748b;
            font-size: 11px;
            font-weight: 750;
            text-align: left;
            text-transform: uppercase;
            letter-spacing: 0.45px;
        }

        .attendance-table td {
            padding: 14px 17px;
            border-bottom: 1px solid #edf1f6;
            color: #334155;
            font-size: 13px;
            vertical-align: middle;
        }

        .attendance-table tbody tr {
            transition: 0.18s;
        }

        .attendance-table tbody tr:hover {
            background: #fafcff;
        }

        .attendance-table tbody tr:last-child td {
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

        .gender-badge {
            padding: 5px 10px;
            border-radius: 20px;
            color: #475569;
            background: #f1f5f9;
            font-size: 11px;
            font-weight: 600;
        }

        .attendance-options {
            min-width: 350px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .attendance-radio {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .attendance-label {
            padding: 8px 11px;
            border: 1px solid #dce4ee;
            border-radius: 9px;
            color: #64748b;
            background: white;
            display: flex;
            align-items: center;
            gap: 5px;
            cursor: pointer;
            font-size: 11px;
            font-weight: 700;
            transition: 0.18s;
            user-select: none;
        }

        .attendance-label:hover {
            transform: translateY(-1px);
        }

        .attendance-label span {
            font-weight: 900;
        }

        .attendance-radio:checked + .present-label {
            border-color: #22c55e;
            color: #15803d;
            background: #dcfce7;
            box-shadow: 0 0 0 2px rgba(34, 197, 94, 0.08);
        }

        .attendance-radio:checked + .absent-label {
            border-color: #ef4444;
            color: #b91c1c;
            background: #fee2e2;
            box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.08);
        }

        .attendance-radio:checked + .leave-label {
            border-color: #f97316;
            color: #c2410c;
            background: #ffedd5;
            box-shadow: 0 0 0 2px rgba(249, 115, 22, 0.08);
        }

        .form-footer {
            padding: 20px 25px;
            border-top: 1px solid #edf1f6;
            background: #fbfcfe;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .footer-information {
            max-width: 650px;
            display: flex;
            align-items: flex-start;
            gap: 9px;
            color: #64748b;
        }

        .footer-information span {
            width: 21px;
            height: 21px;
            border-radius: 50%;
            color: white;
            background: #3b82f6;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 12px;
            font-weight: 800;
        }

        .footer-information p {
            margin: 1px 0 0;
            font-size: 11px;
            line-height: 1.5;
        }

        .save-attendance-button {
            min-width: 175px;
            padding: 12px 18px;
            border: none;
            border-radius: 11px;
            color: white;
            background: linear-gradient(135deg, #1d4ed8, #2563eb);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 750;
            box-shadow: 0 7px 18px rgba(37, 99, 235, 0.23);
            transition: 0.2s;
        }

        .save-attendance-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 22px rgba(37, 99, 235, 0.28);
        }

        .save-attendance-button:disabled {
            opacity: 0.65;
            cursor: not-allowed;
            transform: none;
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
            max-width: 430px;
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

            .attendance-info-card {
                align-items: flex-start;
                flex-direction: column;
            }

            .class-date-information {
                width: 100%;
            }

            .information-box {
                flex: 1;
            }

            .statistics-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 650px) {

            .attendance-page {
                padding: 20px 12px 35px;
            }

            .page-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .attendance-info-card {
                padding: 21px;
                border-radius: 17px;
            }

            .teacher-avatar {
                width: 57px;
                height: 57px;
                border-radius: 15px;
            }

            .teacher-information h2 {
                font-size: 17px;
            }

            .class-date-information {
                flex-direction: column;
            }

            .information-box {
                width: 100%;
                min-width: 0;
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

            .attendance-card-header {
                padding: 19px;
                align-items: flex-start;
                flex-direction: column;
            }

            .mark-all-button {
                width: 100%;
            }

            .search-area {
                padding: 15px 19px;
                align-items: flex-start;
                flex-direction: column;
            }

            .search-box {
                max-width: none;
            }

            .form-footer {
                padding: 18px;
                align-items: stretch;
                flex-direction: column;
            }

            .save-attendance-button {
                width: 100%;
            }
        }

    </style>


    <script>

        /**
         * Update Present, Absent and Leave counters.
         */
        function updateAttendanceCounters() {

            const presentCount = document.querySelectorAll(
                'input[value="Present"]:checked'
            ).length;

            const absentCount = document.querySelectorAll(
                'input[value="Absent"]:checked'
            ).length;

            const leaveCount = document.querySelectorAll(
                'input[value="Leave"]:checked'
            ).length;

            document.getElementById('presentCount').textContent = presentCount;
            document.getElementById('absentCount').textContent = absentCount;
            document.getElementById('leaveCount').textContent = leaveCount;
        }


        /**
         * Mark every student with the selected attendance status.
         */
        function markAllStudents(status) {

            const attendanceInputs = document.querySelectorAll(
                'input.attendance-radio[value="' + status + '"]'
            );

            attendanceInputs.forEach(function(input) {
                input.checked = true;
            });

            updateAttendanceCounters();
        }


        /**
         * Search students using student name or student ID.
         */
        function searchStudents() {

            const searchValue = document
                .getElementById('studentSearch')
                .value
                .toLowerCase()
                .trim();

            const studentRows = document.querySelectorAll('.student-row');

            let visibleStudents = 0;

            studentRows.forEach(function(row) {

                const studentName = row.dataset.name || '';
                const studentId = row.dataset.studentId || '';

                const isMatched =
                    studentName.includes(searchValue) ||
                    studentId.includes(searchValue);

                row.style.display = isMatched ? '' : 'none';

                if (isMatched) {
                    visibleStudents++;
                }
            });

            document.getElementById('searchResultCount').textContent =
                'Showing ' + visibleStudents + ' students';
        }


        /**
         * Prevent multiple form submissions.
         */
        const attendanceForm = document.getElementById('attendanceForm');

        if (attendanceForm) {

            attendanceForm.addEventListener('submit', function() {

                const saveButton = document.getElementById('saveButton');

                saveButton.disabled = true;
                saveButton.innerHTML = '<span>⌛</span> Saving Attendance...';
            });
        }


        document.addEventListener('DOMContentLoaded', function() {
            updateAttendanceCounters();
        });

    </script>

</x-app-layout>