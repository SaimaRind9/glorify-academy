<x-app-layout>

    <x-slot name="header">

        <div class="parent-header">

            <div class="page-header">
                <h2>Parent Dashboard</h2>
                <p>
                    View your child’s profile and academic information
                </p>
            </div>

            <button
                type="button"
                id="parentThemeToggle"
                class="parent-theme-toggle"
                aria-label="Toggle dark mode"
            >
                <span class="parent-theme-icon">
                    <i
                        id="parentThemeIcon"
                        class="fa-solid fa-moon"
                    ></i>
                </span>

                <span id="parentThemeText">
                    Dark Mode
                </span>
            </button>

        </div>

    </x-slot>


    <div class="parent-page">

        <div class="parent-container">


            @if(!$student)

                <div class="alert-card animated-card">

                    <div class="alert-icon">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>

                    <div>

                        <h3>
                            Student Profile Not Found
                        </h3>

                        <p>
                            Your parent account is not connected to a student.
                            Please contact the administrator.
                        </p>

                    </div>

                </div>

            @else


                {{-- =====================================================
                    WELCOME
                ====================================================== --}}

                <div class="welcome-card animated-card">

                    <div class="welcome-decoration decoration-one"></div>
                    <div class="welcome-decoration decoration-two"></div>


                    <div class="welcome-content">

                        <div class="welcome-date">

                            <i class="fa-regular fa-calendar"></i>

                            {{ now()->format('l, d F Y') }}

                        </div>


                        <h1>

                            Welcome,
                            {{ auth()->user()->name }}

                            <span class="wave">
                                👋
                            </span>

                        </h1>


                        <p>
                            Here is the latest profile and attendance
                            information for your child.
                        </p>


                        <div class="welcome-badges">

                            <span>
                                <i class="fa-solid fa-id-card"></i>
                                {{ $student->student_id }}
                            </span>

                            <span>
                                <i class="fa-solid fa-school"></i>
                                {{ $student->classRoom?->class_name ?? 'No Class' }}
                            </span>

                        </div>

                    </div>


                    <div class="student-main-profile">

                        <div class="student-main-photo">

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

                            <small>
                                Student
                            </small>

                            <h2>
                                {{ $student->name }}
                            </h2>

                            <p>
                                {{ $student->classRoom?->class_name ?? 'Class Not Assigned' }}
                            </p>

                        </div>

                    </div>

                </div>



                {{-- =====================================================
                    STATISTICS
                ====================================================== --}}

                <div class="statistics-grid">


                    <div class="stat-card animated-card">

                        <div class="stat-icon total-icon">
                            <i class="fa-solid fa-calendar-days"></i>
                        </div>

                        <div>

                            <p>
                                Total Records
                            </p>

                            <h3>
                                {{ $totalAttendance }}
                            </h3>

                            <span>
                                Attendance entries
                            </span>

                        </div>

                    </div>


                    <div class="stat-card animated-card">

                        <div class="stat-icon present-icon">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>

                        <div>

                            <p>
                                Present
                            </p>

                            <h3>
                                {{ $presentCount }}
                            </h3>

                            <span>
                                Days attended
                            </span>

                        </div>

                    </div>


                    <div class="stat-card animated-card">

                        <div class="stat-icon absent-icon">
                            <i class="fa-solid fa-circle-xmark"></i>
                        </div>

                        <div>

                            <p>
                                Absent
                            </p>

                            <h3>
                                {{ $absentCount }}
                            </h3>

                            <span>
                                Days absent
                            </span>

                        </div>

                    </div>


                    <div class="stat-card animated-card">

                        <div class="stat-icon leave-icon">
                            <i class="fa-solid fa-clock"></i>
                        </div>

                        <div>

                            <p>
                                Leave
                            </p>

                            <h3>
                                {{ $leaveCount }}
                            </h3>

                            <span>
                                Approved leave
                            </span>

                        </div>

                    </div>

                </div>


                
                {{-- =====================================================
    QUICK ACTIONS
====================================================== --}}

<div class="quick-actions">

    <a href="{{ route('parent.profile.edit') }}" class="quick-action-card">

    <div class="quick-action-icon child-action">
        <i class="fa-solid fa-user-graduate"></i>
    </div>

    <div>
        <strong>My Child</strong>
        <span>View student profile</span>
    </div>

    <i class="fa-solid fa-chevron-right action-arrow"></i>

</a>


    <a href="{{ route('parent.attendance.index') }}" class="quick-action-card">
        <div class="quick-action-icon attendance-action">
            <i class="fa-solid fa-calendar-check"></i>
        </div>

        <div>
            <strong>Attendance</strong>
            <span>View attendance</span>
        </div>

        <i class="fa-solid fa-chevron-right action-arrow"></i>
    </a>


    <a href="{{ route('parent.results.index') }}" class="quick-action-card">
        <div class="quick-action-icon result-action">
            <i class="fa-solid fa-chart-column"></i>
        </div>

        <div>
            <strong>Results</strong>
            <span>View exam results</span>
        </div>

        <i class="fa-solid fa-chevron-right action-arrow"></i>
    </a>


    <a href="{{ route('parent.fee-challans.index') }}" class="quick-action-card">
        <div class="quick-action-icon fee-action">
            <i class="fa-solid fa-file-invoice-dollar"></i>
        </div>

        <div>
            <strong>Fee Challans</strong>
            <span>View fee details</span>
        </div>

        <i class="fa-solid fa-chevron-right action-arrow"></i>
    </a>


    <a href="{{ route('parent.payments.index') }}" class="quick-action-card">
        <div class="quick-action-icon payment-action">
            <i class="fa-solid fa-receipt"></i>
        </div>

        <div>
            <strong>Payments</strong>
            <span>Payment history</span>
        </div>

        <i class="fa-solid fa-chevron-right action-arrow"></i>
    </a>


    <a href="{{ route('parent.profile.edit') }}" class="quick-action-card">
        <div class="quick-action-icon profile-action">
            <i class="fa-solid fa-user-gear"></i>
        </div>

        <div>
            <strong>Profile</strong>
            <span>Parent account</span>
        </div>

        <i class="fa-solid fa-chevron-right action-arrow"></i>
    </a>

</div>
{{-- =====================================================
    PARENT NOTICES
====================================================== --}}

<div class="parent-notices-section animated-card">

    <div class="section-heading">

        <div>

            <span class="section-label">
                ANNOUNCEMENTS
            </span>

            <h2>
                Latest Notices
            </h2>

            <p>
                Important academy updates for parents
            </p>

        </div>

        <span class="notice-count">
            <i class="fa-solid fa-bullhorn"></i>
            {{ $notices->count() }}
        </span>

    </div>


    @if($notices->count())

        <div class="parent-notice-grid">

            @foreach($notices as $notice)

                <div class="parent-notice-card">

                    <div class="parent-notice-image">

                        @if($notice->image)

                            <img
                                src="{{ asset('storage/' . $notice->image) }}"
                                alt="{{ $notice->title }}"
                                onclick="openParentNoticeImage(this.src)"
                            >

                            <div class="image-zoom-hint">
                                <i class="fa-solid fa-magnifying-glass-plus"></i>
                            </div>

                        @else

                            <div class="notice-placeholder">
                                <i class="fa-solid fa-bullhorn"></i>
                            </div>

                        @endif

                    </div>


                    <div class="parent-notice-content">

                        <div class="notice-date">

                            <i class="fa-regular fa-calendar"></i>

                            {{ $notice->publish_date
                                ? $notice->publish_date->format('d M Y')
                                : $notice->created_at->format('d M Y') }}

                        </div>


                        <h3>
                            {{ $notice->title }}
                        </h3>


                        <p>
                            {{ \Illuminate\Support\Str::limit(
                                $notice->description,
                                120
                            ) }}
                        </p>

                    </div>

                </div>

            @endforeach

        </div>

    @else

        <div class="notice-empty-state">

            <div class="notice-empty-icon">
                <i class="fa-solid fa-bullhorn"></i>
            </div>

            <h3>No Notices Available</h3>

            <p>
                There are currently no active announcements.
            </p>

        </div>

    @endif

</div>


{{-- Full Image Viewer --}}

<div id="parentNoticeModal" class="parent-notice-modal">

    <button
        type="button"
        class="parent-modal-close"
        onclick="closeParentNoticeImage()"
    >
        <i class="fa-solid fa-xmark"></i>
    </button>

    <img
        id="parentNoticeFullImage"
        src=""
        alt="Notice Image"
    >

</div>



                {{-- =====================================================
                    PROFILE + ATTENDANCE SUMMARY
                ====================================================== --}}

                <div class="dashboard-layout">


                    {{-- Child Profile --}}

                    <div class="content-card animated-card">

                        <div class="section-heading">

                            <div>

                                <span class="section-label">
                                    STUDENT
                                </span>

                                <h2>
                                    Child Profile
                                </h2>

                                <p>
                                    Personal and academic information
                                </p>

                            </div>


                            <span class="student-id-badge">

                                <i class="fa-regular fa-id-card"></i>

                                {{ $student->student_id }}

                            </span>

                        </div>


                        <div class="profile-top">

                            <div class="profile-avatar">

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

                                <h3>
                                    {{ $student->name }}
                                </h3>

                                <p>
                                    {{ $student->classRoom?->class_name ?? 'No Class Assigned' }}
                                </p>

                            </div>

                        </div>


                        <div class="profile-details">


                            <div class="detail-row">

                                <span>
                                    <i class="fa-solid fa-user"></i>
                                    Student Name
                                </span>

                                <strong>
                                    {{ $student->name }}
                                </strong>

                            </div>


                            <div class="detail-row">

                                <span>
                                    <i class="fa-regular fa-id-card"></i>
                                    Student ID
                                </span>

                                <strong>
                                    {{ $student->student_id }}
                                </strong>

                            </div>


                            <div class="detail-row">

                                <span>
                                    <i class="fa-solid fa-school"></i>
                                    Class
                                </span>

                                <strong>
                                    {{ $student->classRoom?->class_name ?? 'Not Assigned' }}
                                </strong>

                            </div>


                            <div class="detail-row">

                                <span>
                                    <i class="fa-solid fa-venus-mars"></i>
                                    Gender
                                </span>

                                <strong>
                                    {{ $student->gender ?? 'Not Available' }}
                                </strong>

                            </div>


                            <div class="detail-row">

                                <span>
                                    <i class="fa-solid fa-phone"></i>
                                    Contact Number
                                </span>

                                <strong>
                                    {{ $student->contact_no ?? $student->phone ?? 'Not Available' }}
                                </strong>

                            </div>


                            <div class="detail-row">

                                <span>
                                    <i class="fa-solid fa-location-dot"></i>
                                    Address
                                </span>

                                <strong>
                                    {{ $student->address ?? 'Not Available' }}
                                </strong>

                            </div>


                            <div class="detail-row">

                                <span>
                                    <i class="fa-solid fa-droplet"></i>
                                    Blood Group
                                </span>

                                <strong>
                                    {{ $student->blood_group ?? 'Not Available' }}
                                </strong>

                            </div>


                        </div>

                    </div>



                    {{-- Attendance Summary --}}

                    <div class="content-card attendance-summary-card animated-card">

                        <div class="section-heading">

                            <div>

                                <span class="section-label">
                                    ATTENDANCE
                                </span>

                                <h2>
                                    Attendance Summary
                                </h2>

                                <p>
                                    Overall attendance performance
                                </p>

                            </div>


                            <div class="heading-icon">
                                <i class="fa-solid fa-chart-pie"></i>
                            </div>

                        </div>



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



                        <div class="progress-wrapper">

                            <div class="progress-heading">

                                <span>
                                    Attendance Progress
                                </span>

                                <strong>
                                    {{ $presentCount }}/{{ $totalAttendance }}
                                </strong>

                            </div>


                            <div class="progress-bar">

                                <div
                                    class="progress-fill"
                                    style="width: {{ min($attendancePercentage, 100) }}%;"
                                ></div>

                            </div>

                        </div>



                        <div class="attendance-message">

                            @if($totalAttendance === 0)

                                <i class="fa-solid fa-circle-info"></i>

                                <span>
                                    Attendance has not been recorded yet.
                                </span>

                            @elseif($attendancePercentage >= 85)

                                <i class="fa-solid fa-star"></i>

                                <span>
                                    Excellent attendance performance.
                                </span>

                            @elseif($attendancePercentage >= 70)

                                <i class="fa-solid fa-thumbs-up"></i>

                                <span>
                                    Attendance performance is satisfactory.
                                </span>

                            @else

                                <i class="fa-solid fa-triangle-exclamation"></i>

                                <span>
                                    Attendance needs improvement.
                                </span>

                            @endif

                        </div>

                    </div>

                </div>



                {{-- =====================================================
                    RECENT ATTENDANCE
                ====================================================== --}}

                <div class="content-card recent-card animated-card">

                    <div class="section-heading">

                        <div>

                            <span class="section-label">
                                HISTORY
                            </span>

                            <h2>
                                Recent Attendance
                            </h2>

                            <p>
                                Latest seven attendance records
                            </p>

                        </div>


                        <span class="record-count">

                            <i class="fa-solid fa-clock-rotate-left"></i>

                            {{ $recentAttendances->count() }}
                            Records

                        </span>

                    </div>


                    @if($recentAttendances->isNotEmpty())

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

                                    @foreach($recentAttendances as $attendance)

                                        <tr>

                                            <td
                                                data-label="#"
                                                class="serial-number"
                                            >
                                                {{ $loop->iteration }}
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

                    @else

                        <div class="empty-state">

                            <div class="empty-icon">
                                <i class="fa-solid fa-calendar-xmark"></i>
                            </div>

                            <h3>
                                No Attendance Records
                            </h3>

                            <p>
                                Attendance information has not been added
                                for this student yet.
                            </p>

                        </div>

                    @endif

                </div>

            @endif



            {{-- =========================================================
                LOGOUT
            ========================================================== --}}

            <div class="logout-area animated-card">

                <form
                    method="POST"
                    action="{{ route('logout') }}"
                >

                    @csrf

                    <button
                        type="submit"
                        class="logout-button"
                    >

                        <i class="fa-solid fa-right-from-bracket"></i>

                        Logout

                    </button>

                </form>

            </div>


        </div>

    </div>



    <style>

        /* =========================================================
           VARIABLES
        ========================================================= */

        :root {
            --parent-bg: #f4f7fb;
            --parent-card: #ffffff;
            --parent-secondary: #f8fafc;

            --parent-text: #0f172a;
            --parent-muted: #64748b;
            --parent-soft: #94a3b8;

            --parent-border: #e4eaf2;

            --parent-primary: #2563eb;

            --parent-shadow:
                0 8px 25px rgba(15, 23, 42, .05);

            --parent-hover-shadow:
                0 17px 40px rgba(15, 23, 42, .10);
        }


        html.dark-mode {
            --parent-bg: #090e1a;
            --parent-card: #111827;
            --parent-secondary: #172033;

            --parent-text: #f8fafc;
            --parent-muted: #a7b2c5;
            --parent-soft: #75829a;

            --parent-border: #253047;

            --parent-primary: #60a5fa;

            --parent-shadow:
                0 10px 30px rgba(0, 0, 0, .25);

            --parent-hover-shadow:
                0 18px 45px rgba(0, 0, 0, .38);
        }


        * {
            box-sizing: border-box;
        }


        body {
            background: var(--parent-bg);

            transition:
                background .35s ease,
                color .35s ease;
        }



        /* =========================================================
           HEADER
        ========================================================= */

        .parent-header {
            width: 100%;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 20px;
        }


        .page-header h2 {
            margin: 0 0 4px;

            color: var(--parent-text);

            font-size: 21px;
            font-weight: 750;

            transition: color .3s ease;
        }


        .page-header p {
            margin: 0;

            color: var(--parent-muted);

            font-size: 13px;
        }


        .parent-theme-toggle {
            display: inline-flex;
            align-items: center;
            gap: 9px;

            padding: 7px 13px 7px 7px;

            border: 1px solid var(--parent-border);
            border-radius: 30px;

            background: var(--parent-card);
            color: var(--parent-muted);

            font-size: 12px;
            font-weight: 700;

            cursor: pointer;

            box-shadow:
                0 5px 15px rgba(15,23,42,.07);

            transition:
                transform .25s ease,
                background .35s ease,
                border-color .35s ease,
                color .35s ease;
        }


        .parent-theme-toggle:hover {
            transform: translateY(-2px);
        }


        .parent-theme-icon {
            width: 31px;
            height: 31px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;

            color: white;

            background:
                linear-gradient(
                    135deg,
                    #172554,
                    #2563eb
                );
        }


        html.dark-mode .parent-theme-icon {
            background:
                linear-gradient(
                    135deg,
                    #f59e0b,
                    #f97316
                );
        }



        /* =========================================================
           PAGE
        ========================================================= */

        .parent-page {
            min-height: calc(100vh - 70px);

            padding: 30px 20px 50px;

            background:
                radial-gradient(
                    circle at 10% 10%,
                    rgba(37, 99, 235, .05),
                    transparent 27%
                ),
                radial-gradient(
                    circle at 90% 45%,
                    rgba(147, 51, 234, .04),
                    transparent 25%
                ),
                var(--parent-bg);

            transition: background .35s ease;
        }


        .parent-container {
            width: 100%;
            max-width: 1350px;

            margin: auto;
        }



        /* =========================================================
           WELCOME
        ========================================================= */

        .welcome-card {
            position: relative;

            overflow: hidden;

            margin-bottom: 22px;

            padding: 32px;

            border-radius: 24px;

            color: white;

            background:
                linear-gradient(
                    135deg,
                    #172554,
                    #2563eb
                );

            display: flex;
            justify-content: space-between;
            align-items: center;

            gap: 25px;

            box-shadow:
                0 18px 40px rgba(37, 99, 235, .20);
        }


        html.dark-mode .welcome-card {
            background:
                linear-gradient(
                    135deg,
                    #111827,
                    #172554,
                    #1e40af
                );

            box-shadow:
                0 20px 50px rgba(0,0,0,.35);
        }


        .welcome-content {
            position: relative;
            z-index: 2;
        }


        .welcome-date {
            width: fit-content;

            margin: 0 0 9px;

            padding: 6px 10px;

            display: flex;
            align-items: center;

            gap: 7px;

            border: 1px solid rgba(255,255,255,.15);
            border-radius: 20px;

            background: rgba(255,255,255,.10);

            font-size: 11px;

            backdrop-filter: blur(8px);
        }


        .welcome-content h1 {
            margin: 0 0 8px;

            font-size: 29px;
            font-weight: 800;
        }


        .welcome-content > p {
            max-width: 600px;

            margin: 0;

            color: rgba(255,255,255,.83);

            font-size: 13px;
            line-height: 1.65;
        }


        .welcome-badges {
            margin-top: 17px;

            display: flex;
            flex-wrap: wrap;

            gap: 8px;
        }


        .welcome-badges span {
            padding: 6px 10px;

            display: inline-flex;
            align-items: center;

            gap: 6px;

            border: 1px solid rgba(255,255,255,.13);
            border-radius: 20px;

            background: rgba(255,255,255,.09);

            font-size: 10px;
            font-weight: 600;
        }


        .student-main-profile {
            position: relative;
            z-index: 2;

            min-width: 280px;

            padding: 15px 18px;

            border: 1px solid rgba(255,255,255,.15);
            border-radius: 17px;

            background: rgba(255,255,255,.10);

            display: flex;
            align-items: center;

            gap: 14px;

            backdrop-filter: blur(8px);

            transition: transform .3s ease;
        }


        .student-main-profile:hover {
            transform: translateY(-4px);
        }


        .student-main-photo {
            width: 64px;
            height: 64px;

            border: 3px solid rgba(255,255,255,.25);
            border-radius: 17px;

            background: rgba(255,255,255,.18);

            overflow: hidden;

            display: flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;

            font-size: 25px;
            font-weight: 800;
        }


        .student-main-photo img {
            width: 100%;
            height: 100%;

            object-fit: cover;
        }


        .student-main-profile small {
            display: block;

            margin-bottom: 2px;

            opacity: .75;

            font-size: 10px;

            text-transform: uppercase;
            letter-spacing: .6px;
        }


        .student-main-profile h2 {
            margin: 0 0 3px;

            font-size: 18px;
            font-weight: 750;
        }


        .student-main-profile p {
            margin: 0;

            opacity: .8;

            font-size: 12px;
        }


        .welcome-decoration {
            position: absolute;

            border-radius: 50%;

            pointer-events: none;
        }


        .decoration-one {
            width: 270px;
            height: 270px;

            right: -80px;
            top: -130px;

            border: 45px solid rgba(255,255,255,.05);

            animation:
                floatCircle 8s ease-in-out infinite;
        }


        .decoration-two {
            width: 130px;
            height: 130px;

            left: 45%;
            bottom: -100px;

            background: rgba(255,255,255,.04);

            animation:
                floatCircle 7s ease-in-out infinite reverse;
        }


        .wave {
            display: inline-block;

            transform-origin: 70% 70%;

            animation:
                waveAnimation 2.4s ease-in-out 1;
        }



        /* =========================================================
           STATISTICS
        ========================================================= */

        .statistics-grid {
            margin-bottom: 22px;

            display: grid;

            grid-template-columns:
                repeat(4, minmax(0, 1fr));

            gap: 18px;
        }


        .stat-card,
        .content-card {
            border: 1px solid var(--parent-border);
            border-radius: 18px;

            background: var(--parent-card);

            box-shadow: var(--parent-shadow);

            transition:
                transform .28s ease,
                box-shadow .28s ease,
                background .35s ease,
                border-color .35s ease;
        }


        .stat-card {
            min-height: 112px;

            padding: 20px;

            display: flex;
            align-items: center;

            gap: 14px;
        }


        .stat-card:hover {
            transform: translateY(-5px);

            box-shadow: var(--parent-hover-shadow);
        }


        .stat-icon {
            width: 50px;
            height: 50px;

            border-radius: 14px;

            display: flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;

            font-size: 20px;

            transition:
                transform .3s ease;
        }


        .stat-card:hover .stat-icon {
            transform:
                scale(1.08)
                rotate(-4deg);
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
            background: rgba(37,99,235,.17);
        }


        html.dark-mode .present-icon {
            color: #4ade80;
            background: rgba(34,197,94,.14);
        }


        html.dark-mode .absent-icon {
            color: #f87171;
            background: rgba(239,68,68,.14);
        }


        html.dark-mode .leave-icon {
            color: #fb923c;
            background: rgba(249,115,22,.14);
        }


        .stat-card p {
            margin: 0 0 2px;

            color: var(--parent-muted);

            font-size: 11px;
            font-weight: 600;
        }


        .stat-card h3 {
            margin: 0 0 2px;

            color: var(--parent-text);

            font-size: 23px;
            font-weight: 800;
        }


        .stat-card span {
            color: var(--parent-soft);

            font-size: 9px;
        }



        /* =========================================================
           CONTENT
        ========================================================= */

        .dashboard-layout {
            margin-bottom: 22px;

            display: grid;

            grid-template-columns:
                1.15fr .85fr;

            gap: 22px;
        }


        .content-card {
            padding: 24px;
        }


        .section-heading {
            margin-bottom: 22px;

            display: flex;
            justify-content: space-between;
            align-items: center;

            gap: 15px;
        }


        .section-label {
            display: block;

            margin-bottom: 3px;

            color: var(--parent-primary);

            font-size: 9px;
            font-weight: 800;

            letter-spacing: 1.3px;
        }


        .section-heading h2 {
            margin: 0 0 4px;

            color: var(--parent-text);

            font-size: 18px;
            font-weight: 750;
        }


        .section-heading p {
            margin: 0;

            color: var(--parent-soft);

            font-size: 12px;
        }


        .student-id-badge,
        .record-count {
            padding: 6px 11px;

            border-radius: 20px;

            color: #1d4ed8;
            background: #dbeafe;

            display: inline-flex;
            align-items: center;

            gap: 6px;

            font-size: 10px;
            font-weight: 700;

            white-space: nowrap;
        }


        html.dark-mode .student-id-badge,
        html.dark-mode .record-count {
            color: #60a5fa;

            background:
                rgba(37,99,235,.15);
        }


        .heading-icon {
            width: 39px;
            height: 39px;

            border-radius: 11px;

            background: var(--parent-secondary);
            color: var(--parent-primary);

            display: flex;
            align-items: center;
            justify-content: center;
        }



        /* =========================================================
           PROFILE
        ========================================================= */

        .profile-top {
            margin-bottom: 10px;
            padding: 14px;

            border-radius: 15px;

            background: var(--parent-secondary);

            display: flex;
            align-items: center;

            gap: 12px;

            transition: background .35s ease;
        }


        .profile-avatar {
            width: 48px;
            height: 48px;

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

            flex-shrink: 0;

            font-size: 17px;
            font-weight: 800;
        }


        .profile-avatar img {
            width: 100%;
            height: 100%;

            object-fit: cover;
        }


        .profile-top h3 {
            margin: 0 0 2px;

            color: var(--parent-text);

            font-size: 14px;
            font-weight: 750;
        }


        .profile-top p {
            margin: 0;

            color: var(--parent-soft);

            font-size: 10px;
        }


        .detail-row {
            padding: 13px 0;

            border-bottom:
                1px solid var(--parent-border);

            display: flex;
            justify-content: space-between;

            gap: 20px;

            transition: border-color .35s ease;
        }


        .detail-row:last-child {
            border-bottom: none;
        }


        .detail-row span {
            display: flex;
            align-items: center;

            gap: 8px;

            color: var(--parent-muted);

            font-size: 11px;
        }


        .detail-row span i {
            width: 15px;

            color: var(--parent-soft);

            text-align: center;
        }


        .detail-row strong {
            max-width: 60%;

            color: var(--parent-text);

            font-size: 11px;
            font-weight: 650;

            text-align: right;

            word-break: break-word;
        }

/* =========================================================
   PARENT NOTICES
========================================================= */

.parent-notices-section {
    margin-bottom: 22px;

    padding: 24px;

    border: 1px solid var(--parent-border);
    border-radius: 20px;

    background: var(--parent-card);

    box-shadow: var(--parent-shadow);
}

.notice-count {
    padding: 6px 10px;

    border-radius: 20px;

    background: #dbeafe;
    color: #2563eb;

    display: inline-flex;
    align-items: center;

    gap: 5px;

    font-size: 9px;
    font-weight: 700;
}

html.dark-mode .notice-count {
    background: rgba(37, 99, 235, .15);
    color: #60a5fa;
}


.parent-notice-grid {
    display: grid;

    grid-template-columns:
        repeat(3, minmax(0, 1fr));

    gap: 15px;
}


.parent-notice-card {
    overflow: hidden;

    border: 1px solid var(--parent-border);
    border-radius: 16px;

    background: var(--parent-secondary);

    transition:
        transform .28s ease,
        box-shadow .28s ease,
        border-color .28s ease;
}


.parent-notice-card:hover {
    transform: translateY(-5px);

    border-color:
        rgba(37, 99, 235, .24);

    box-shadow:
        0 15px 30px rgba(15, 23, 42, .10);
}


.parent-notice-image {
    position: relative;

    width: 100%;
    height: 170px;

    overflow: hidden;

    background: var(--parent-card);
}


.parent-notice-image img {
    width: 100%;
    height: 100%;

    object-fit: cover;

    cursor: zoom-in;

    transition: transform .35s ease;
}


.parent-notice-card:hover
.parent-notice-image img {
    transform: scale(1.04);
}


.image-zoom-hint {
    position: absolute;

    right: 10px;
    bottom: 10px;

    width: 30px;
    height: 30px;

    border-radius: 50%;

    background:
        rgba(15, 23, 42, .75);

    color: white;

    display: flex;
    align-items: center;
    justify-content: center;

    font-size: 11px;

    pointer-events: none;
}


.notice-placeholder {
    width: 100%;
    height: 100%;

    display: flex;
    align-items: center;
    justify-content: center;

    background:
        linear-gradient(
            135deg,
            #dbeafe,
            #eff6ff
        );

    color: #2563eb;

    font-size: 30px;
}


html.dark-mode .notice-placeholder {
    background:
        linear-gradient(
            135deg,
            rgba(37,99,235,.18),
            rgba(37,99,235,.08)
        );

    color: #60a5fa;
}


.parent-notice-content {
    padding: 15px;
}


.notice-date {
    margin-bottom: 6px;

    color: var(--parent-soft);

    display: flex;
    align-items: center;

    gap: 5px;

    font-size: 8px;
    font-weight: 600;
}


.parent-notice-content h3 {
    margin: 0 0 6px;

    color: var(--parent-text);

    font-size: 13px;
    font-weight: 750;

    line-height: 1.4;
}


.parent-notice-content p {
    margin: 0;

    color: var(--parent-muted);

    font-size: 9px;
    line-height: 1.6;
}


/* Empty */

.notice-empty-state {
    padding: 45px 20px;

    text-align: center;
}


.notice-empty-icon {
    width: 60px;
    height: 60px;

    margin: 0 auto 12px;

    border-radius: 17px;

    background: var(--parent-secondary);
    color: var(--parent-primary);

    display: flex;
    align-items: center;
    justify-content: center;

    font-size: 22px;
}


.notice-empty-state h3 {
    margin: 0 0 5px;

    color: var(--parent-text);

    font-size: 15px;
}


.notice-empty-state p {
    margin: 0;

    color: var(--parent-muted);

    font-size: 10px;
}


/* =========================================================
   NOTICE IMAGE MODAL
========================================================= */

.parent-notice-modal {
    position: fixed;
    inset: 0;

    z-index: 99999;

    display: none;
    align-items: center;
    justify-content: center;

    padding: 30px;

    background:
        rgba(0, 0, 0, .9);

    backdrop-filter: blur(5px);
}


.parent-notice-modal.active {
    display: flex;
}


.parent-notice-modal img {
    max-width: 95vw;
    max-height: 92vh;

    width: auto;
    height: auto;

    object-fit: contain;

    border-radius: 10px;

    box-shadow:
        0 20px 60px rgba(0, 0, 0, .5);
}


.parent-modal-close {
    position: absolute;

    top: 20px;
    right: 25px;

    width: 42px;
    height: 42px;

    border: none;
    border-radius: 50%;

    background:
        rgba(255, 255, 255, .15);

    color: white;

    display: flex;
    align-items: center;
    justify-content: center;

    font-size: 20px;

    cursor: pointer;
}


.parent-modal-close:hover {
    background:
        rgba(255, 255, 255, .25);
}


/* Responsive */

@media (max-width: 992px) {

    .parent-notice-grid {
        grid-template-columns:
            repeat(2, minmax(0, 1fr));
    }

}


@media (max-width: 600px) {

    .parent-notices-section {
        padding: 18px;
    }

    .parent-notice-grid {
        grid-template-columns: 1fr;
    }

    .parent-notice-image {
        height: 200px;
    }

}

        /* =========================================================
           ATTENDANCE SUMMARY
        ========================================================= */

        .attendance-summary-card {
            text-align: center;
        }


        .attendance-summary-card .section-heading {
            text-align: left;
        }


        .percentage-circle {
            width: 175px;
            height: 175px;

            margin: 10px auto 25px;

            padding: 13px;

            border-radius: 50%;

            background:
                conic-gradient(
                    #2563eb {{ min($attendancePercentage, 100) }}%,
                    var(--parent-border) 0
                );

            transition: background .35s ease;
        }


        .percentage-inner {
            width: 100%;
            height: 100%;

            border-radius: 50%;

            background: var(--parent-card);

            display: flex;
            align-items: center;
            justify-content: center;

            flex-direction: column;

            transition: background .35s ease;
        }


        .percentage-inner strong {
            color: var(--parent-text);

            font-size: 30px;
            font-weight: 800;
        }


        .percentage-inner span {
            margin-top: 3px;

            color: var(--parent-muted);

            font-size: 11px;
        }


        .progress-wrapper {
            text-align: left;
        }


        .progress-heading {
            margin-bottom: 8px;

            display: flex;
            justify-content: space-between;

            color: var(--parent-muted);

            font-size: 12px;
        }


        .progress-heading strong {
            color: var(--parent-text);
        }


        .progress-bar {
            width: 100%;
            height: 9px;

            border-radius: 20px;

            background: var(--parent-border);

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

            transition: width .8s ease;
        }


        .attendance-message {
            margin-top: 20px;

            padding: 12px;

            border-radius: 11px;

            color: var(--parent-muted);

            background: var(--parent-secondary);

            display: flex;
            align-items: center;
            justify-content: center;

            gap: 8px;

            font-size: 11px;
        }



        /* =========================================================
           RECENT ATTENDANCE
        ========================================================= */

        .recent-card {
            padding: 0;

            overflow: hidden;
        }


        .recent-card .section-heading {
            margin: 0;

            padding: 22px 24px;

            border-bottom:
                1px solid var(--parent-border);
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
            background: var(--parent-secondary);
        }


        .attendance-table th {
            padding: 13px 18px;

            border-bottom:
                1px solid var(--parent-border);

            color: var(--parent-muted);

            font-size: 10px;
            font-weight: 750;

            text-align: left;

            text-transform: uppercase;

            letter-spacing: .4px;
        }


        .attendance-table td {
            padding: 15px 18px;

            border-bottom:
                1px solid var(--parent-border);

            color: var(--parent-text);

            font-size: 12px;
        }


        .attendance-table tbody tr {
            transition: background .2s ease;
        }


        .attendance-table tbody tr:hover {
            background: var(--parent-secondary);
        }


        .attendance-table tbody tr:last-child td {
            border-bottom: none;
        }


        .serial-number {
            color: var(--parent-soft) !important;

            font-weight: 600;
        }


        .status-badge {
            min-width: 75px;

            padding: 6px 11px;

            border-radius: 20px;

            display: inline-flex;
            justify-content: center;

            font-size: 10px;
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

            background:
                rgba(34,197,94,.14);
        }


        html.dark-mode .status-absent {
            color: #f87171;

            background:
                rgba(239,68,68,.14);
        }


        html.dark-mode .status-leave {
            color: #fb923c;

            background:
                rgba(249,115,22,.14);
        }



        /* =========================================================
           EMPTY / ALERT
        ========================================================= */

        .empty-state {
            padding: 65px 20px;

            text-align: center;
        }


        .empty-icon {
            width: 70px;
            height: 70px;

            margin: 0 auto 15px;

            border-radius: 20px;

            color: var(--parent-primary);
            background: var(--parent-secondary);

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 27px;
        }


        .empty-state h3 {
            margin: 0 0 7px;

            color: var(--parent-text);

            font-size: 18px;
        }


        .empty-state p {
            margin: 0;

            color: var(--parent-muted);

            font-size: 13px;
        }


        .alert-card {
            padding: 25px;

            border: 1px solid #fecaca;
            border-radius: 17px;

            color: #991b1b;
            background: #fef2f2;

            display: flex;
            align-items: center;

            gap: 17px;
        }


        html.dark-mode .alert-card {
            color: #fca5a5;

            background:
                rgba(127,29,29,.18);

            border-color:
                rgba(248,113,113,.20);
        }


        .alert-icon {
            width: 50px;
            height: 50px;

            border-radius: 14px;

            background: #fee2e2;

            display: flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;

            font-size: 20px;
        }


        html.dark-mode .alert-icon {
            background:
                rgba(239,68,68,.14);
        }


        .alert-card h3 {
            margin: 0 0 5px;

            font-size: 17px;
        }


        .alert-card p {
            margin: 0;

            font-size: 13px;
        }



        /* =========================================================
           LOGOUT
        ========================================================= */

        .logout-area {
            margin-top: 25px;

            display: flex;
            justify-content: flex-end;
        }


        .logout-button {
            padding: 10px 18px;

            border: 1px solid #fecaca;
            border-radius: 11px;

            color: #dc2626;
            background: #fff1f2;

            cursor: pointer;

            display: inline-flex;
            align-items: center;

            gap: 7px;

            font-size: 12px;
            font-weight: 700;

            transition:
                transform .25s ease,
                background .25s ease;
        }


        .logout-button:hover {
            transform: translateY(-2px);

            background: #fee2e2;
        }


        html.dark-mode .logout-button {
            color: #f87171;

            background:
                rgba(220,38,38,.12);

            border-color:
                rgba(248,113,113,.18);
        }



        /* =========================================================
           ANIMATIONS
        ========================================================= */

        .animated-card {
            opacity: 0;

            transform: translateY(16px);

            animation:
                parentFadeUp .55s ease forwards;
        }


        .welcome-card {
            animation-delay: .04s;
        }


        .statistics-grid .stat-card:nth-child(1) {
            animation-delay: .10s;
        }


        .statistics-grid .stat-card:nth-child(2) {
            animation-delay: .15s;
        }


        .statistics-grid .stat-card:nth-child(3) {
            animation-delay: .20s;
        }


        .statistics-grid .stat-card:nth-child(4) {
            animation-delay: .25s;
        }


        .dashboard-layout .content-card:nth-child(1) {
            animation-delay: .30s;
        }


        .dashboard-layout .content-card:nth-child(2) {
            animation-delay: .36s;
        }


        .recent-card {
            animation-delay: .42s;
        }


        .logout-area {
            animation-delay: .48s;
        }


        @keyframes parentFadeUp {

            to {
                opacity: 1;
                transform: translateY(0);
            }

        }


        @keyframes waveAnimation {

            0%,
            60%,
            100% {
                transform: rotate(0deg);
            }

            10% {
                transform: rotate(15deg);
            }

            20% {
                transform: rotate(-10deg);
            }

            30% {
                transform: rotate(14deg);
            }

            40% {
                transform: rotate(-6deg);
            }

            50% {
                transform: rotate(10deg);
            }

        }


        @keyframes floatCircle {

            0%,
            100% {
                transform: translate(0,0);
            }

            50% {
                transform: translate(-12px,12px);
            }

        }

/* =========================================================
   QUICK ACTIONS
========================================================= */

.quick-actions {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 16px;
    margin-bottom: 22px;
}

.quick-action-card {
    position: relative;

    display: flex;
    align-items: center;
    gap: 13px;

    min-height: 88px;
    padding: 16px;

    border: 1px solid var(--parent-border);
    border-radius: 17px;

    background: var(--parent-card);
    color: var(--parent-text);

    text-decoration: none;

    box-shadow: var(--parent-shadow);

    overflow: hidden;

    transition:
        transform .28s ease,
        box-shadow .28s ease,
        border-color .28s ease,
        background .35s ease;
}

.quick-action-card::before {
    content: "";

    position: absolute;
    left: 0;
    top: 0;

    width: 4px;
    height: 100%;

    background: var(--parent-primary);

    opacity: 0;

    transition: opacity .25s ease;
}

.quick-action-card:hover {
    transform: translateY(-5px);

    border-color: rgba(37, 99, 235, .25);

    box-shadow: var(--parent-hover-shadow);
}

.quick-action-card:hover::before {
    opacity: 1;
}


/* Icon */

.quick-action-icon {
    width: 48px;
    height: 48px;

    flex-shrink: 0;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 14px;

    font-size: 18px;

    transition:
        transform .3s ease,
        background .3s ease;
}

.quick-action-card:hover .quick-action-icon {
    transform: scale(1.08) rotate(-4deg);
}


/* Different icon styles */

.child-action {
    color: #2563eb;
    background: #dbeafe;
}

.attendance-action {
    color: #15803d;
    background: #dcfce7;
}

.result-action {
    color: #7c3aed;
    background: #ede9fe;
}

.fee-action {
    color: #c2410c;
    background: #ffedd5;
}

.payment-action {
    color: #0891b2;
    background: #cffafe;
}

.profile-action {
    color: #db2777;
    background: #fce7f3;
}


/* Text */

.quick-action-card > div:nth-child(2) {
    min-width: 0;
    flex: 1;
}

.quick-action-card strong {
    display: block;

    margin-bottom: 3px;

    color: var(--parent-text);

    font-size: 13px;
    font-weight: 750;

    transition: color .3s ease;
}

.quick-action-card span {
    display: block;

    color: var(--parent-muted);

    font-size: 10px;

    transition: color .3s ease;
}


/* Arrow */

.action-arrow {
    margin-left: auto;

    color: var(--parent-soft);

    font-size: 11px;

    transition:
        transform .25s ease,
        color .25s ease;
}

.quick-action-card:hover .action-arrow {
    color: var(--parent-primary);

    transform: translateX(4px);
}


/* =========================================================
   QUICK ACTIONS - DARK MODE
========================================================= */

html.dark-mode .quick-action-card {
    background: var(--parent-card);
    border-color: var(--parent-border);
}

html.dark-mode .quick-action-card:hover {
    border-color: rgba(96, 165, 250, .30);
}

html.dark-mode .child-action {
    color: #60a5fa;
    background: rgba(37, 99, 235, .16);
}

html.dark-mode .attendance-action {
    color: #4ade80;
    background: rgba(34, 197, 94, .14);
}

html.dark-mode .result-action {
    color: #c084fc;
    background: rgba(147, 51, 234, .15);
}

html.dark-mode .fee-action {
    color: #fb923c;
    background: rgba(249, 115, 22, .14);
}

html.dark-mode .payment-action {
    color: #22d3ee;
    background: rgba(6, 182, 212, .14);
}

html.dark-mode .profile-action {
    color: #f472b6;
    background: rgba(236, 72, 153, .14);
}


/* =========================================================
   QUICK ACTION ANIMATION
========================================================= */

.quick-action-card {
    opacity: 0;
    transform: translateY(12px);

    animation: quickActionFade .5s ease forwards;
}

.quick-action-card:nth-child(1) {
    animation-delay: .08s;
}

.quick-action-card:nth-child(2) {
    animation-delay: .13s;
}

.quick-action-card:nth-child(3) {
    animation-delay: .18s;
}

.quick-action-card:nth-child(4) {
    animation-delay: .23s;
}

.quick-action-card:nth-child(5) {
    animation-delay: .28s;
}

.quick-action-card:nth-child(6) {
    animation-delay: .33s;
}

@keyframes quickActionFade {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}


/* =========================================================
   QUICK ACTIONS RESPONSIVE
========================================================= */

@media (max-width: 992px) {

    .quick-actions {
        grid-template-columns:
            repeat(2, minmax(0, 1fr));
    }

}

@media (max-width: 600px) {

    .quick-actions {
        grid-template-columns: 1fr;
        gap: 11px;
    }

    .quick-action-card {
        min-height: 76px;
        padding: 13px;
    }

    .quick-action-icon {
        width: 43px;
        height: 43px;

        border-radius: 12px;

        font-size: 16px;
    }

}

        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 992px) {

            .statistics-grid {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }


            .dashboard-layout {
                grid-template-columns: 1fr;
            }


            .welcome-card {
                align-items: flex-start;

                flex-direction: column;
            }


            .student-main-profile {
                width: 100%;
            }

        }


        @media (max-width: 600px) {

            .parent-page {
                padding: 20px 12px 35px;
            }


            .parent-theme-toggle {
                padding: 6px;
            }


            .parent-theme-icon {
                width: 30px;
                height: 30px;
            }


            #parentThemeText {
                display: none;
            }


            .welcome-card {
                padding: 22px;

                border-radius: 18px;
            }


            .welcome-content h1 {
                font-size: 22px;
            }


            .student-main-profile {
                min-width: 0;
            }


            .statistics-grid {
                grid-template-columns: 1fr 1fr;

                gap: 11px;
            }


            .stat-card {
                min-height: 100px;

                padding: 14px;

                gap: 9px;
            }


            .stat-icon {
                width: 40px;
                height: 40px;

                border-radius: 11px;

                font-size: 15px;
            }


            .stat-card h3 {
                font-size: 19px;
            }


            .stat-card span {
                display: none;
            }


            .content-card {
                padding: 19px;
            }


            .section-heading {
                align-items: flex-start;
            }


            .recent-card {
                padding: 0;
            }


            .recent-card .section-heading {
                padding: 19px;
            }


            .detail-row {
                align-items: flex-start;

                flex-direction: column;

                gap: 5px;
            }


            .detail-row strong {
                max-width: 100%;

                text-align: left;
            }


            .percentage-circle {
                width: 150px;
                height: 150px;
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
                margin-bottom: 12px;

                overflow: hidden;

                border: 1px solid var(--parent-border);
                border-radius: 13px;

                background: var(--parent-card);
            }


            .attendance-table td {
                position: relative;

                min-height: 40px;

                padding:
                    10px 12px
                    10px 42%;

                border-bottom:
                    1px solid var(--parent-border);
            }


            .attendance-table td:last-child {
                border-bottom: none;
            }


            .attendance-table td::before {
                content: attr(data-label);

                position: absolute;

                top: 10px;
                left: 12px;

                width: 34%;

                color: var(--parent-muted);

                font-size: 9px;
                font-weight: 750;
            }


            .logout-area,
            .logout-area form,
            .logout-button {
                width: 100%;
            }


            .logout-button {
                justify-content: center;
            }

        }


        @media (max-width: 420px) {

            .statistics-grid {
                grid-template-columns: 1fr;
            }

        }


        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: .01ms !important;
                scroll-behavior: auto !important;
            }

        }

    </style>



    <script>

        document.addEventListener(
            'DOMContentLoaded',
            function () {

                const root =
                    document.documentElement;

                const toggle =
                    document.getElementById(
                        'parentThemeToggle'
                    );

                const icon =
                    document.getElementById(
                        'parentThemeIcon'
                    );

                const text =
                    document.getElementById(
                        'parentThemeText'
                    );


                function updateThemeButton() {

                    const isDark =
                        root.classList.contains(
                            'dark-mode'
                        );


                    if (icon) {

                        icon.className =
                            isDark
                                ? 'fa-solid fa-sun'
                                : 'fa-solid fa-moon';

                    }


                    if (text) {

                        text.textContent =
                            isDark
                                ? 'Light Mode'
                                : 'Dark Mode';

                    }

                }


                /*
                |--------------------------------------------------------------------------
                | Current global theme
                |--------------------------------------------------------------------------
                */

                updateThemeButton();


                /*
                |--------------------------------------------------------------------------
                | Toggle
                |--------------------------------------------------------------------------
                */

                if (toggle) {

                    toggle.addEventListener(
                        'click',
                        function () {

                            const isDark =
                                root.classList.contains(
                                    'dark-mode'
                                );


                            const newTheme =
                                isDark
                                    ? 'light'
                                    : 'dark';


                            if (newTheme === 'dark') {

                                root.classList.add(
                                    'dark-mode'
                                );

                            } else {

                                root.classList.remove(
                                    'dark-mode'
                                );

                            }


                            /*
                             * Same global key used by
                             * Teacher Dashboard / app layout.
                             */

                            localStorage.setItem(
                                'teacher-dashboard-theme',
                                newTheme
                            );


                            updateThemeButton();

                        }
                    );

                }

            }
        );

  

    function openParentNoticeImage(src) {

        const modal =
            document.getElementById(
                'parentNoticeModal'
            );

        const image =
            document.getElementById(
                'parentNoticeFullImage'
            );

        image.src = src;

        modal.classList.add('active');

        document.body.style.overflow = 'hidden';
    }


    function closeParentNoticeImage() {

        const modal =
            document.getElementById(
                'parentNoticeModal'
            );

        modal.classList.remove('active');

        document.body.style.overflow = '';
    }


    document
        .getElementById('parentNoticeModal')
        ?.addEventListener(
            'click',
            function (event) {

                if (event.target === this) {
                    closeParentNoticeImage();
                }

            }
        );


    document.addEventListener(
        'keydown',
        function (event) {

            if (event.key === 'Escape') {
                closeParentNoticeImage();
            }

        }
    );

</script>
</x-app-layout>