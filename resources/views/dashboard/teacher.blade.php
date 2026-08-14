<x-app-layout>

    <x-slot name="header">
        <div class="dashboard-header-bar">
            <h2 class="dashboard-page-title">
                Teacher Dashboard
            </h2>

            <button
                type="button"
                id="themeToggle"
                class="theme-toggle"
                aria-label="Toggle dark mode"
            >
                <span class="theme-toggle-icon">
                    <i id="themeIcon" class="fa-solid fa-moon"></i>
                </span>

                <span id="themeText">Dark Mode</span>
            </button>
        </div>
    </x-slot>


    <div class="teacher-dashboard-page">

        <div class="dashboard-container">

            {{-- =========================================================
                WELCOME SECTION
            ========================================================== --}}
            <div class="teacher-welcome animate-item">

                <div class="welcome-decoration decoration-one"></div>
                <div class="welcome-decoration decoration-two"></div>

                <div class="teacher-welcome-content">

                    <div class="welcome-date">
                        <i class="fa-regular fa-calendar"></i>
                        {{ now()->format('l, d F Y') }}
                    </div>

                    <h1>
                        Welcome,
                        {{ $teacher?->name ?? auth()->user()->name }}
                        <span class="wave">👋</span>
                    </h1>

                    <p>
                        Manage your class, subjects, attendance,
                        exams, marks and results from one place.
                    </p>

                    @if($teacher)

                        <div class="welcome-badges">

                            <span>
                                <i class="fa-solid fa-id-badge"></i>
                                {{ $teacher->teacher_id }}
                            </span>

                            <span>
                                <i class="fa-solid fa-school"></i>
                                {{ $teacher->classRoom?->class_name ?? 'No Class' }}
                            </span>

                        </div>

                    @endif

                </div>


                <div class="teacher-profile-area">

                    <div class="profile-glow"></div>

                    <div class="teacher-profile-photo">

                        @if($teacher && $teacher->photo)

                            <img
                                src="{{ asset('storage/' . $teacher->photo) }}"
                                alt="{{ $teacher->name }}"
                            >

                        @else

                            <span>
                                {{ strtoupper(
                                    substr(
                                        $teacher?->name ?? auth()->user()->name,
                                        0,
                                        1
                                    )
                                ) }}
                            </span>

                        @endif

                    </div>

                </div>

            </div>


            @if(!$teacher)

                <div class="alert-box animate-item">

                    <div class="alert-icon">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>

                    <div>
                        <strong>Teacher profile not connected</strong>

                        <p>
                            Your login account is not connected to a teacher
                            profile. Please contact the administrator.
                        </p>
                    </div>

                </div>

            @else


                {{-- =====================================================
                    STATISTICS
                ====================================================== --}}
                <div class="dashboard-grid">


                    <div class="dashboard-card animate-item">

                        <div class="card-icon blue-icon">
                            <i class="fa-solid fa-chalkboard-user"></i>
                        </div>

                        <div class="stat-content">

                            <p>Teacher ID</p>

                            <h3>
                                {{ $teacher->teacher_id }}
                            </h3>

                            <span>
                                Academy identification
                            </span>

                        </div>

                    </div>


                    <div class="dashboard-card animate-item">

                        <div class="card-icon green-icon">
                            <i class="fa-solid fa-school"></i>
                        </div>

                        <div class="stat-content">

                            <p>Assigned Class</p>

                            <h3>
                                {{ $teacher->classRoom?->class_name ?? 'Not Assigned' }}
                            </h3>

                            <span>
                                Your current class
                            </span>

                        </div>

                    </div>


                    <div class="dashboard-card animate-item">

                        <div class="card-icon purple-icon">
                            <i class="fa-solid fa-user-graduate"></i>
                        </div>

                        <div class="stat-content">

                            <p>Total Students</p>

                            <h3>
                                {{ $totalStudents }}
                            </h3>

                            <span>
                                Students in your class
                            </span>

                        </div>

                    </div>


                    <div class="dashboard-card animate-item">

                        <div class="card-icon orange-icon">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>

                        <div class="stat-content">

                            <p>Account Status</p>

                            <h3>
                                {{ ucfirst(auth()->user()->status) }}
                            </h3>

                            <span>
                                Teacher account
                            </span>

                        </div>

                    </div>

                </div>



                {{-- =====================================================
                    QUICK ACTIONS
                ====================================================== --}}
                <div class="content-card quick-actions-card animate-item">

                    <div class="section-heading">

                        <div>

                            <span class="section-label">
                                SHORTCUTS
                            </span>

                            <h2>
                                Quick Actions
                            </h2>

                            <p>
                                Manage your academic activities
                            </p>

                        </div>

                        <div class="section-heading-icon">
                            <i class="fa-solid fa-bolt"></i>
                        </div>

                    </div>


                    <div class="action-grid">


                        {{-- My Class --}}
                        <a href="#students"
                           class="action-button class-action">

                            <div class="action-icon">
                                <i class="fa-solid fa-school"></i>
                            </div>

                            <div class="action-content">

                                <strong>
                                    My Class
                                </strong>

                                <span>
                                    View assigned class and students
                                </span>

                            </div>

                            <i class="fa-solid fa-arrow-right action-arrow"></i>

                        </a>


                        {{-- Subjects --}}
                        <a href="{{ route('teacher.subjects.index') }}"
                           class="action-button subject-action">

                            <div class="action-icon">
                                <i class="fa-solid fa-book-open"></i>
                            </div>

                            <div class="action-content">

                                <strong>
                                    My Subjects
                                </strong>

                                <span>
                                    Add and manage class subjects
                                </span>

                            </div>

                            <i class="fa-solid fa-arrow-right action-arrow"></i>

                        </a>


                        {{-- Attendance --}}
                        <a href="{{ route('teacher.attendance') }}"
                           class="action-button attendance-action">

                            <div class="action-icon">
                                <i class="fa-solid fa-calendar-check"></i>
                            </div>

                            <div class="action-content">

                                <strong>
                                    Mark Attendance
                                </strong>

                                <span>
                                    Record today's attendance
                                </span>

                            </div>

                            <i class="fa-solid fa-arrow-right action-arrow"></i>

                        </a>


                        {{-- Attendance History --}}
                        <a href="{{ route('teacher.attendance.history') }}"
                           class="action-button history-action">

                            <div class="action-icon">
                                <i class="fa-solid fa-clock-rotate-left"></i>
                            </div>

                            <div class="action-content">

                                <strong>
                                    Attendance History
                                </strong>

                                <span>
                                    View previous attendance
                                </span>

                            </div>

                            <i class="fa-solid fa-arrow-right action-arrow"></i>

                        </a>


                        {{-- Exams --}}
                        <a href="{{ route('teacher.exams.index') }}"
                           class="action-button exam-action">

                            <div class="action-icon">
                                <i class="fa-solid fa-file-pen"></i>
                            </div>

                            <div class="action-content">

                                <strong>
                                    Exams
                                </strong>

                                <span>
                                    Create and manage exams
                                </span>

                            </div>

                            <i class="fa-solid fa-arrow-right action-arrow"></i>

                        </a>


                        {{-- Marks --}}
                        <a href="{{ route('teacher.marks.index') }}"
                           class="action-button marks-action">

                            <div class="action-icon">
                                <i class="fa-solid fa-clipboard-list"></i>
                            </div>

                            <div class="action-content">

                                <strong>
                                    Marks
                                </strong>

                                <span>
                                    Enter and edit student marks
                                </span>

                            </div>

                            <i class="fa-solid fa-arrow-right action-arrow"></i>

                        </a>


                        {{-- Results --}}
                        <a href="{{ route('teacher.results.index') }}"
                           class="action-button result-action">

                            <div class="action-icon">
                                <i class="fa-solid fa-chart-column"></i>
                            </div>

                            <div class="action-content">

                                <strong>
                                    Results
                                </strong>

                                <span>
                                    Generate and print results
                                </span>

                            </div>

                            <i class="fa-solid fa-arrow-right action-arrow"></i>

                        </a>


                        {{-- Profile --}}
                        <a href="{{ route('teacher.profile.edit') }}"
                           class="action-button profile-action">

                            <div class="action-icon">
                                <i class="fa-solid fa-user"></i>
                            </div>

                            <div class="action-content">

                                <strong>
                                    My Profile
                                </strong>

                                <span>
                                    View and update information
                                </span>

                            </div>

                            <i class="fa-solid fa-arrow-right action-arrow"></i>

                        </a>

                    </div>

                </div>



                {{-- =====================================================
                    PROFILE + STUDENTS
                ====================================================== --}}
                <div class="content-layout">


                    {{-- Teacher Profile --}}
                    <div class="content-card animate-item"
                         id="teacher-profile">

                        <div class="section-heading">

                            <div>

                                <span class="section-label">
                                    ACCOUNT
                                </span>

                                <h2>
                                    My Profile
                                </h2>

                                <p>
                                    Your academy information
                                </p>

                            </div>

                            <a href="{{ route('teacher.profile.edit') }}"
                               class="small-edit-button">

                                <i class="fa-solid fa-pen"></i>

                            </a>

                        </div>


                        <div class="mini-profile">

                            <div class="mini-profile-avatar">

                                @if($teacher->photo)

                                    <img
                                        src="{{ asset('storage/' . $teacher->photo) }}"
                                        alt="{{ $teacher->name }}"
                                    >

                                @else

                                    {{ strtoupper(substr($teacher->name, 0, 1)) }}

                                @endif

                            </div>

                            <div>

                                <h3>
                                    {{ $teacher->name }}
                                </h3>

                                <p>
                                    {{ $teacher->qualification ?? 'Teacher' }}
                                </p>

                            </div>

                        </div>


                        <div class="profile-details">


                            <div class="detail-row">

                                <span>
                                    <i class="fa-solid fa-id-card"></i>
                                    Teacher ID
                                </span>

                                <strong>
                                    {{ $teacher->teacher_id }}
                                </strong>

                            </div>


                            <div class="detail-row">

                                <span>
                                    <i class="fa-solid fa-envelope"></i>
                                    Email
                                </span>

                                <strong>
                                    {{ $teacher->email ?? 'Not available' }}
                                </strong>

                            </div>


                            <div class="detail-row">

                                <span>
                                    <i class="fa-solid fa-phone"></i>
                                    Phone
                                </span>

                                <strong>
                                    {{ $teacher->phone ?? 'Not available' }}
                                </strong>

                            </div>


                            <div class="detail-row">

                                <span>
                                    <i class="fa-solid fa-school"></i>
                                    Assigned Class
                                </span>

                                <strong>
                                    {{ $teacher->classRoom?->class_name ?? 'Not Assigned' }}
                                </strong>

                            </div>


                            <div class="detail-row">

                                <span>
                                    <i class="fa-solid fa-graduation-cap"></i>
                                    Qualification
                                </span>

                                <strong>
                                    {{ $teacher->qualification ?? 'Not available' }}
                                </strong>

                            </div>


                            <div class="detail-row">

                                <span>
                                    <i class="fa-solid fa-briefcase"></i>
                                    Experience
                                </span>

                                <strong>
                                    {{ $teacher->experience ?? 'Not available' }}
                                </strong>

                            </div>


                            <div class="detail-row">

                                <span>
                                    <i class="fa-solid fa-circle-check"></i>
                                    Status
                                </span>

                                <strong class="status-badge">
                                    {{ ucfirst($teacher->status) }}
                                </strong>

                            </div>

                        </div>

                    </div>



                    {{-- Students --}}
                    <div class="content-card animate-item"
                         id="students">

                        <div class="section-heading">

                            <div>

                                <span class="section-label">
                                    CLASSROOM
                                </span>

                                <h2>
                                    My Class Students
                                </h2>

                                <p>
                                    {{ $teacher->classRoom?->class_name
                                        ?? 'No class assigned' }}
                                </p>

                            </div>


                            <span class="student-count">

                                <i class="fa-solid fa-users"></i>

                                {{ $totalStudents }}
                                Students

                            </span>

                        </div>


                        <div class="student-list">

                            @forelse($students as $student)

                                <div class="student-item">

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


                                    <div class="student-info">

                                        <h4>
                                            {{ $student->name }}
                                        </h4>

                                        <p>
                                            <i class="fa-regular fa-id-card"></i>

                                            {{ $student->student_id }}
                                        </p>

                                    </div>


                                    <span class="gender-badge">
                                        {{ $student->gender }}
                                    </span>

                                </div>

                            @empty

                                <div class="empty-state">

                                    <div class="empty-icon">
                                        <i class="fa-solid fa-user-graduate"></i>
                                    </div>

                                    <h3>No Students Found</h3>

                                    <p>
                                        There are currently no students
                                        in your assigned class.
                                    </p>

                                </div>

                            @endforelse

                        </div>

                    </div>

                </div>

            @endif



            {{-- =========================================================
                LOGOUT
            ========================================================== --}}
            <div class="logout-area animate-item">

                <form method="POST"
                      action="{{ route('logout') }}">

                    @csrf

                    <button type="submit"
                            class="logout-button">

                        <i class="fa-solid fa-right-from-bracket"></i>

                        Logout

                    </button>

                </form>

            </div>

        </div>

    </div>



    <style>

        /* ============================================================
           VARIABLES
        ============================================================ */

        :root {
            --page-bg: #f4f7fb;
            --card-bg: #ffffff;
            --card-secondary: #f8fafc;

            --text-primary: #0f172a;
            --text-secondary: #64748b;
            --text-muted: #94a3b8;

            --border: #e5eaf1;

            --primary: #2563eb;
            --primary-dark: #1d4ed8;

            --shadow:
                0 10px 30px rgba(15, 23, 42, 0.055);

            --hover-shadow:
                0 18px 40px rgba(15, 23, 42, 0.11);
        }


        html.dark-mode {
            --page-bg: #090e1a;
            --card-bg: #111827;
            --card-secondary: #172033;

            --text-primary: #f8fafc;
            --text-secondary: #a8b3c7;
            --text-muted: #75829a;

            --border: #253047;

            --primary: #60a5fa;
            --primary-dark: #3b82f6;

            --shadow:
                0 12px 35px rgba(0, 0, 0, 0.25);

            --hover-shadow:
                0 20px 45px rgba(0, 0, 0, 0.38);
        }


        html {
            scroll-behavior: smooth;
        }


        body {
            background: var(--page-bg);
            transition:
                background-color .35s ease,
                color .35s ease;
        }


        .teacher-dashboard-page {
            min-height: 100vh;
            padding: 32px 0;
            background:
                radial-gradient(
                    circle at 10% 10%,
                    rgba(37, 99, 235, .055),
                    transparent 25%
                ),
                radial-gradient(
                    circle at 90% 40%,
                    rgba(147, 51, 234, .045),
                    transparent 24%
                ),
                var(--page-bg);

            transition: background .35s ease;
        }


        .dashboard-container {
            width: min(1280px, calc(100% - 40px));
            margin: 0 auto;
        }



        /* ============================================================
           HEADER + DARK MODE
        ============================================================ */

        .dashboard-header-bar {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
        }


        .dashboard-page-title {
            margin: 0;
            color: var(--text-primary) !important;
            font-size: 20px;
            font-weight: 700;
            transition: color .3s ease;
        }


        .theme-toggle {
            position: relative;
            display: inline-flex;
            align-items: center;
            gap: 9px;
            padding: 8px 13px 8px 8px;
            border: 1px solid var(--border);
            border-radius: 30px;
            background: var(--card-bg);
            color: var(--text-secondary);
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;

            box-shadow:
                0 5px 15px rgba(15, 23, 42, .06);

            transition:
                transform .25s ease,
                background .3s ease,
                border-color .3s ease,
                color .3s ease,
                box-shadow .25s ease;
        }


        .theme-toggle:hover {
            transform: translateY(-2px);

            box-shadow:
                0 9px 22px rgba(15, 23, 42, .11);
        }


        .theme-toggle-icon {
            width: 31px;
            height: 31px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;

            background:
                linear-gradient(
                    135deg,
                    #172554,
                    #2563eb
                );

            color: white;
        }


        html.dark-mode .theme-toggle-icon {
            background:
                linear-gradient(
                    135deg,
                    #f59e0b,
                    #f97316
                );
        }



        /* ============================================================
           WELCOME
        ============================================================ */

        .teacher-welcome {
            position: relative;
            overflow: hidden;

            min-height: 205px;
            padding: 35px;

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 30px;

            border-radius: 26px;

            background:
                linear-gradient(
                    125deg,
                    #0f1f4a 0%,
                    #1d4ed8 55%,
                    #3b82f6 100%
                );

            color: white;

            box-shadow:
                0 22px 50px rgba(37, 99, 235, .22);

            margin-bottom: 24px;
        }


        html.dark-mode .teacher-welcome {
            background:
                linear-gradient(
                    125deg,
                    #111827 0%,
                    #172554 48%,
                    #1e40af 100%
                );

            box-shadow:
                0 25px 60px rgba(0, 0, 0, .35);
        }


        .teacher-welcome-content {
            position: relative;
            z-index: 3;
            max-width: 680px;
        }


        .welcome-date {
            display: inline-flex;
            align-items: center;
            gap: 7px;

            margin-bottom: 10px;

            padding: 6px 10px;

            border: 1px solid rgba(255,255,255,.16);
            border-radius: 20px;

            background: rgba(255,255,255,.10);

            font-size: 12px;
            color: rgba(255,255,255,.88);

            backdrop-filter: blur(8px);
        }


        .teacher-welcome h1 {
            margin: 0 0 9px;

            font-size: clamp(25px, 3vw, 34px);
            line-height: 1.2;
            font-weight: 800;

            letter-spacing: -.5px;
        }


        .teacher-welcome-content > p {
            max-width: 580px;

            margin: 0;

            color: rgba(255,255,255,.82);

            font-size: 14px;
            line-height: 1.7;
        }


        .welcome-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 9px;

            margin-top: 18px;
        }


        .welcome-badges span {
            display: inline-flex;
            align-items: center;
            gap: 7px;

            padding: 7px 11px;

            border: 1px solid rgba(255,255,255,.15);
            border-radius: 20px;

            background: rgba(255,255,255,.09);

            color: rgba(255,255,255,.9);

            font-size: 11px;
            font-weight: 600;

            backdrop-filter: blur(8px);
        }


        .teacher-profile-area {
            position: relative;
            z-index: 3;

            width: 125px;
            height: 125px;

            display: flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;
        }


        .profile-glow {
            position: absolute;

            width: 125px;
            height: 125px;

            border-radius: 32px;

            background: rgba(255,255,255,.16);

            filter: blur(18px);

            animation: profilePulse 3s ease-in-out infinite;
        }


        .teacher-profile-photo {
            position: relative;
            z-index: 2;

            width: 100px;
            height: 100px;

            overflow: hidden;

            display: flex;
            align-items: center;
            justify-content: center;

            border: 4px solid rgba(255,255,255,.28);
            border-radius: 27px;

            background: rgba(255,255,255,.16);

            color: white;

            font-size: 36px;
            font-weight: 800;

            box-shadow:
                0 15px 35px rgba(0,0,0,.18);

            backdrop-filter: blur(10px);

            transition: transform .3s ease;
        }


        .teacher-welcome:hover .teacher-profile-photo {
            transform:
                translateY(-4px)
                rotate(2deg);
        }


        .teacher-profile-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }


        .welcome-decoration {
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
        }


        .decoration-one {
            width: 260px;
            height: 260px;

            right: -60px;
            top: -100px;

            border: 45px solid rgba(255,255,255,.055);

            animation: floatingCircle 9s ease-in-out infinite;
        }


        .decoration-two {
            width: 160px;
            height: 160px;

            right: 180px;
            bottom: -120px;

            background: rgba(255,255,255,.045);

            animation: floatingCircle 7s ease-in-out infinite reverse;
        }


        .wave {
            display: inline-block;
            transform-origin: 70% 70%;
            animation: waveAnimation 2.5s ease-in-out 1;
        }



        /* ============================================================
           STATS
        ============================================================ */

        .dashboard-grid {
            display: grid;

            grid-template-columns:
                repeat(4, minmax(0, 1fr));

            gap: 18px;

            margin-bottom: 24px;
        }


        .dashboard-card,
        .content-card {
            border: 1px solid var(--border);
            background: var(--card-bg);

            box-shadow: var(--shadow);

            transition:
                transform .28s ease,
                box-shadow .28s ease,
                background .35s ease,
                border-color .35s ease;
        }


        .dashboard-card {
            position: relative;
            overflow: hidden;

            min-height: 125px;
            padding: 21px;

            display: flex;
            align-items: center;
            gap: 14px;

            border-radius: 19px;
        }


        .dashboard-card::after {
            content: "";

            position: absolute;

            width: 70px;
            height: 70px;

            right: -28px;
            top: -28px;

            border-radius: 50%;

            background: rgba(37,99,235,.04);

            transition: transform .35s ease;
        }


        .dashboard-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--hover-shadow);
        }


        .dashboard-card:hover::after {
            transform: scale(1.8);
        }


        .card-icon {
            width: 54px;
            height: 54px;

            display: flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;

            border-radius: 16px;

            font-size: 20px;

            transition:
                transform .3s ease,
                box-shadow .3s ease;
        }


        .dashboard-card:hover .card-icon {
            transform:
                scale(1.08)
                rotate(-4deg);
        }


        .blue-icon {
            background: #dbeafe;
            color: #2563eb;
        }


        .green-icon {
            background: #d1fae5;
            color: #059669;
        }


        .purple-icon {
            background: #f3e8ff;
            color: #9333ea;
        }


        .orange-icon {
            background: #ffedd5;
            color: #ea580c;
        }


        html.dark-mode .blue-icon {
            background: rgba(37,99,235,.18);
            color: #60a5fa;
        }


        html.dark-mode .green-icon {
            background: rgba(5,150,105,.17);
            color: #34d399;
        }


        html.dark-mode .purple-icon {
            background: rgba(147,51,234,.17);
            color: #c084fc;
        }


        html.dark-mode .orange-icon {
            background: rgba(234,88,12,.17);
            color: #fb923c;
        }


        .stat-content {
            min-width: 0;
        }


        .stat-content p {
            margin: 0 0 3px;

            color: var(--text-secondary);

            font-size: 11px;
            font-weight: 600;
        }


        .stat-content h3 {
            margin: 0 0 3px;

            color: var(--text-primary);

            font-size: 17px;
            font-weight: 750;

            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;

            transition: color .3s ease;
        }


        .stat-content span {
            color: var(--text-muted);
            font-size: 10px;
        }



        /* ============================================================
           CONTENT CARD
        ============================================================ */

        .content-card {
            padding: 25px;
            border-radius: 21px;
        }


        .quick-actions-card {
            margin-bottom: 24px;
        }


        .section-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;

            margin-bottom: 22px;
        }


        .section-label {
            display: block;

            margin-bottom: 3px;

            color: var(--primary);

            font-size: 9px;
            font-weight: 800;

            letter-spacing: 1.4px;
        }


        .section-heading h2 {
            margin: 0 0 3px;

            color: var(--text-primary);

            font-size: 18px;
            font-weight: 750;

            transition: color .3s ease;
        }


        .section-heading p {
            margin: 0;

            color: var(--text-muted);

            font-size: 12px;
        }


        .section-heading-icon,
        .small-edit-button {
            width: 38px;
            height: 38px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 11px;

            background: var(--card-secondary);
            color: var(--primary);

            text-decoration: none;

            transition:
                transform .25s ease,
                background .3s ease;
        }


        .small-edit-button:hover {
            transform: rotate(8deg) scale(1.06);
        }



        /* ============================================================
           QUICK ACTIONS
        ============================================================ */

        .action-grid {
            display: grid;

            grid-template-columns:
                repeat(4, minmax(0, 1fr));

            gap: 14px;
        }


        .action-button {
            position: relative;
            overflow: hidden;

            min-height: 112px;
            padding: 17px;

            display: flex;
            align-items: center;
            gap: 12px;

            border: 1px solid transparent;
            border-radius: 16px;

            text-decoration: none;

            transition:
                transform .28s ease,
                box-shadow .28s ease,
                border-color .28s ease;
        }


        .action-button::before {
            content: "";

            position: absolute;

            width: 80px;
            height: 80px;

            right: -45px;
            bottom: -45px;

            border-radius: 50%;

            background: currentColor;
            opacity: .035;

            transition: transform .35s ease;
        }


        .action-button:hover {
            transform: translateY(-5px);

            box-shadow:
                0 13px 28px rgba(15,23,42,.10);
        }


        .action-button:hover::before {
            transform: scale(2);
        }


        .action-icon {
            width: 43px;
            height: 43px;

            display: flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;

            border-radius: 13px;

            background: rgba(255,255,255,.62);

            font-size: 18px;

            transition:
                transform .3s ease,
                background .3s ease;
        }


        html.dark-mode .action-icon {
            background: rgba(255,255,255,.06);
        }


        .action-button:hover .action-icon {
            transform:
                translateY(-2px)
                scale(1.07);
        }


        .action-content {
            flex: 1;
            min-width: 0;
        }


        .action-content strong,
        .action-content span {
            display: block;
        }


        .action-content strong {
            font-size: 13px;
            font-weight: 750;
        }


        .action-content span {
            margin-top: 4px;

            font-size: 10.5px;
            line-height: 1.45;

            opacity: .78;
        }


        .action-arrow {
            font-size: 10px;

            opacity: 0;

            transform: translateX(-7px);

            transition:
                opacity .25s ease,
                transform .25s ease;
        }


        .action-button:hover .action-arrow {
            opacity: .7;
            transform: translateX(0);
        }


        .class-action {
            color: #1d4ed8;
            background: #eff6ff;
        }


        .subject-action {
            color: #7e22ce;
            background: #faf5ff;
        }


        .attendance-action {
            color: white;

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #1d4ed8
                );

            box-shadow:
                0 10px 24px rgba(37,99,235,.16);
        }


        .attendance-action .action-icon {
            background: rgba(255,255,255,.14);
        }


        .history-action {
            color: #047857;
            background: #ecfdf5;
        }


        .exam-action {
            color: #c2410c;
            background: #fff7ed;
        }


        .marks-action {
            color: #b45309;
            background: #fffbeb;
        }


        .result-action {
            color: #be123c;
            background: #fff1f2;
        }


        .profile-action {
            color: #334155;
            background: #f8fafc;
            border-color: #e2e8f0;
        }


        html.dark-mode .class-action {
            color: #60a5fa;
            background: rgba(37,99,235,.12);
            border-color: rgba(96,165,250,.10);
        }


        html.dark-mode .subject-action {
            color: #c084fc;
            background: rgba(147,51,234,.12);
            border-color: rgba(192,132,252,.10);
        }


        html.dark-mode .attendance-action {
            color: #ffffff;

            background:
                linear-gradient(
                    135deg,
                    #1d4ed8,
                    #1e40af
                );
        }


        html.dark-mode .history-action {
            color: #34d399;
            background: rgba(5,150,105,.12);
            border-color: rgba(52,211,153,.10);
        }


        html.dark-mode .exam-action {
            color: #fb923c;
            background: rgba(234,88,12,.12);
            border-color: rgba(251,146,60,.10);
        }


        html.dark-mode .marks-action {
            color: #fbbf24;
            background: rgba(217,119,6,.12);
            border-color: rgba(251,191,36,.10);
        }


        html.dark-mode .result-action {
            color: #fb7185;
            background: rgba(225,29,72,.12);
            border-color: rgba(251,113,133,.10);
        }


        html.dark-mode .profile-action {
            color: #cbd5e1;
            background: var(--card-secondary);
            border-color: var(--border);
        }



        /* ============================================================
           PROFILE + STUDENTS
        ============================================================ */

        .content-layout {
            display: grid;

            grid-template-columns:
                minmax(0, .85fr)
                minmax(0, 1.15fr);

            gap: 22px;
        }


        .mini-profile {
            display: flex;
            align-items: center;
            gap: 13px;

            padding: 14px;

            margin-bottom: 12px;

            border-radius: 15px;

            background: var(--card-secondary);

            transition: background .3s ease;
        }


        .mini-profile-avatar {
            width: 48px;
            height: 48px;

            display: flex;
            align-items: center;
            justify-content: center;

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

            font-size: 17px;
            font-weight: 800;
        }


        .mini-profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }


        .mini-profile h3 {
            margin: 0 0 2px;

            color: var(--text-primary);

            font-size: 14px;
            font-weight: 750;
        }


        .mini-profile p {
            margin: 0;

            color: var(--text-muted);

            font-size: 11px;
        }


        .detail-row {
            min-height: 46px;

            padding: 11px 2px;

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;

            border-bottom: 1px solid var(--border);

            transition: border-color .3s ease;
        }


        .detail-row:last-child {
            border-bottom: none;
        }


        .detail-row > span {
            display: flex;
            align-items: center;
            gap: 8px;

            color: var(--text-secondary);

            font-size: 11px;
        }


        .detail-row > span i {
            width: 15px;

            color: var(--text-muted);

            text-align: center;
        }


        .detail-row strong {
            max-width: 55%;

            color: var(--text-primary);

            font-size: 11px;
            font-weight: 650;

            text-align: right;

            overflow-wrap: anywhere;

            transition: color .3s ease;
        }


        .status-badge {
            display: inline-flex;
            align-items: center;

            padding: 5px 10px;

            border-radius: 20px;

            background: #dcfce7;

            color: #15803d !important;

            font-size: 10px !important;
            font-weight: 700 !important;
        }


        html.dark-mode .status-badge {
            background: rgba(34,197,94,.13);
            color: #4ade80 !important;
        }



        /* ============================================================
           STUDENTS
        ============================================================ */

        .student-count {
            display: inline-flex;
            align-items: center;
            gap: 6px;

            padding: 6px 10px;

            border-radius: 20px;

            background: #eff6ff;
            color: #2563eb;

            font-size: 10px;
            font-weight: 700;
        }


        html.dark-mode .student-count {
            background: rgba(37,99,235,.15);
            color: #60a5fa;
        }


        .student-list {
            max-height: 450px;

            padding-right: 4px;

            overflow-y: auto;
        }


        .student-list::-webkit-scrollbar {
            width: 5px;
        }


        .student-list::-webkit-scrollbar-track {
            background: transparent;
        }


        .student-list::-webkit-scrollbar-thumb {
            border-radius: 10px;
            background: var(--border);
        }


        .student-item {
            position: relative;

            padding: 12px 8px;

            display: flex;
            align-items: center;

            border-bottom: 1px solid var(--border);
            border-radius: 11px;

            transition:
                transform .22s ease,
                background .22s ease,
                border-color .3s ease;
        }


        .student-item:last-child {
            border-bottom: none;
        }


        .student-item:hover {
            background: var(--card-secondary);
            transform: translateX(4px);
        }


        .student-avatar {
            width: 43px;
            height: 43px;

            margin-right: 11px;

            display: flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;

            overflow: hidden;

            border-radius: 13px;

            background: #dbeafe;
            color: #2563eb;

            font-size: 13px;
            font-weight: 750;
        }


        html.dark-mode .student-avatar {
            background: rgba(37,99,235,.17);
            color: #60a5fa;
        }


        .student-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }


        .student-info {
            flex: 1;
            min-width: 0;
        }


        .student-info h4 {
            margin: 0 0 3px;

            color: var(--text-primary);

            font-size: 12px;
            font-weight: 700;

            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;

            transition: color .3s ease;
        }


        .student-info p {
            margin: 0;

            color: var(--text-muted);

            font-size: 10px;
        }


        .student-info p i {
            margin-right: 3px;
        }


        .gender-badge {
            padding: 5px 9px;

            border-radius: 20px;

            background: var(--card-secondary);
            color: var(--text-secondary);

            font-size: 9px;
            font-weight: 700;

            transition:
                background .3s ease,
                color .3s ease;
        }



        /* ============================================================
           EMPTY / ALERT
        ============================================================ */

        .empty-state {
            padding: 55px 20px;
            text-align: center;
        }


        .empty-icon {
            width: 60px;
            height: 60px;

            margin: 0 auto 12px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 18px;

            background: var(--card-secondary);
            color: var(--text-muted);

            font-size: 23px;
        }


        .empty-state h3 {
            margin: 0 0 5px;

            color: var(--text-primary);

            font-size: 14px;
            font-weight: 700;
        }


        .empty-state p {
            margin: 0;

            color: var(--text-muted);

            font-size: 11px;
        }


        .alert-box {
            display: flex;
            align-items: center;
            gap: 13px;

            padding: 17px;

            border: 1px solid #fecaca;
            border-radius: 15px;

            background: #fef2f2;
            color: #b91c1c;
        }


        .alert-icon {
            width: 42px;
            height: 42px;

            display: flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;

            border-radius: 12px;

            background: #fee2e2;
        }


        .alert-box strong {
            display: block;
            margin-bottom: 2px;
            font-size: 13px;
        }


        .alert-box p {
            margin: 0;
            font-size: 11px;
        }



        /* ============================================================
           LOGOUT
        ============================================================ */

        .logout-area {
            margin-top: 24px;

            display: flex;
            justify-content: flex-end;
        }


        .logout-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;

            padding: 10px 17px;

            border: 1px solid #fecaca;
            border-radius: 11px;

            background: #fff1f2;
            color: #dc2626;

            font-size: 11px;
            font-weight: 700;

            cursor: pointer;

            transition:
                transform .25s ease,
                background .25s ease,
                box-shadow .25s ease;
        }


        .logout-button:hover {
            transform: translateY(-2px);

            background: #fee2e2;

            box-shadow:
                0 8px 20px rgba(220,38,38,.10);
        }


        html.dark-mode .logout-button {
            border-color: rgba(248,113,113,.17);
            background: rgba(220,38,38,.10);
            color: #f87171;
        }



        /* ============================================================
           PAGE ANIMATIONS
        ============================================================ */

        .animate-item {
            opacity: 0;
            transform: translateY(18px);

            animation:
                fadeSlideUp .55s ease forwards;
        }


        .teacher-welcome {
            animation-delay: .03s;
        }


        .dashboard-grid .dashboard-card:nth-child(1) {
            animation-delay: .10s;
        }


        .dashboard-grid .dashboard-card:nth-child(2) {
            animation-delay: .16s;
        }


        .dashboard-grid .dashboard-card:nth-child(3) {
            animation-delay: .22s;
        }


        .dashboard-grid .dashboard-card:nth-child(4) {
            animation-delay: .28s;
        }


        .quick-actions-card {
            animation-delay: .34s;
        }


        .content-layout .content-card:nth-child(1) {
            animation-delay: .40s;
        }


        .content-layout .content-card:nth-child(2) {
            animation-delay: .46s;
        }


        .logout-area {
            animation-delay: .52s;
        }


        @keyframes fadeSlideUp {

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


        @keyframes profilePulse {

            0%,
            100% {
                transform: scale(.92);
                opacity: .6;
            }

            50% {
                transform: scale(1.08);
                opacity: .9;
            }

        }


        @keyframes floatingCircle {

            0%,
            100% {
                transform: translate(0, 0);
            }

            50% {
                transform: translate(-12px, 13px);
            }

        }



        /* ============================================================
           DARK MODE - LAYOUT / BREEZE FIXES
        ============================================================ */

        html.dark-mode body,
        html.dark-mode .min-h-screen {
            background-color: var(--page-bg) !important;
        }


        html.dark-mode nav {
            background-color: var(--card-bg) !important;
            border-color: var(--border) !important;
        }


        html.dark-mode header {
            background-color: var(--card-bg) !important;
            box-shadow: none !important;
        }


        html.dark-mode header > div {
            color: var(--text-primary);
        }


        html.dark-mode .bg-white {
            background-color: var(--card-bg) !important;
        }


        html.dark-mode .text-gray-800,
        html.dark-mode .text-gray-900 {
            color: var(--text-primary) !important;
        }


        html.dark-mode .text-gray-500,
        html.dark-mode .text-gray-600,
        html.dark-mode .text-gray-700 {
            color: var(--text-secondary) !important;
        }


        html.dark-mode .border-gray-100,
        html.dark-mode .border-gray-200 {
            border-color: var(--border) !important;
        }



        /* ============================================================
           RESPONSIVE
        ============================================================ */

        @media (max-width: 1100px) {

            .action-grid {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }

        }


        @media (max-width: 992px) {

            .dashboard-grid {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }


            .content-layout {
                grid-template-columns: 1fr;
            }

        }


        @media (max-width: 768px) {

            .teacher-dashboard-page {
                padding: 23px 0;
            }


            .dashboard-container {
                width: min(100% - 28px, 1280px);
            }


            .teacher-welcome {
                min-height: auto;
                padding: 28px;
            }


            .teacher-profile-area {
                width: 95px;
                height: 95px;
            }


            .teacher-profile-photo {
                width: 78px;
                height: 78px;

                border-radius: 21px;

                font-size: 28px;
            }


            .profile-glow {
                width: 95px;
                height: 95px;
            }

        }


        @media (max-width: 576px) {

            .dashboard-header-bar {
                align-items: center;
            }


            .dashboard-page-title {
                font-size: 17px;
            }


            .theme-toggle {
                padding: 6px;
            }


            .theme-toggle-icon {
                width: 30px;
                height: 30px;
            }


            #themeText {
                display: none;
            }


            .teacher-dashboard-page {
                padding-top: 18px;
            }


            .dashboard-container {
                width: calc(100% - 22px);
            }


            .teacher-welcome {
                padding: 25px 21px;

                border-radius: 21px;
            }


            .teacher-welcome h1 {
                font-size: 23px;
            }


            .teacher-welcome-content > p {
                font-size: 12px;
            }


            .teacher-profile-area {
                display: none;
            }


            .welcome-badges {
                margin-top: 15px;
            }


            .dashboard-grid,
            .action-grid {
                grid-template-columns: 1fr;
            }


            .dashboard-grid {
                gap: 12px;
            }


            .dashboard-card {
                min-height: 105px;
                padding: 17px;
            }


            .content-card {
                padding: 19px;

                border-radius: 17px;
            }


            .action-grid {
                gap: 11px;
            }


            .action-button {
                min-height: 90px;
                padding: 14px;
            }


            .action-arrow {
                opacity: .5;
                transform: none;
            }


            .section-heading {
                align-items: flex-start;
            }


            .detail-row {
                align-items: flex-start;
            }


            .detail-row > span {
                max-width: 43%;
            }


            .detail-row strong {
                max-width: 55%;
            }


            .student-item {
                padding-left: 3px;
                padding-right: 3px;
            }


            .gender-badge {
                font-size: 8px;
            }


            .logout-area,
            .logout-area form,
            .logout-button {
                width: 100%;
            }

        }


        /* Reduce animation for accessibility */

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

        document.addEventListener('DOMContentLoaded', function () {

            const root = document.documentElement;
            const toggle = document.getElementById('themeToggle');
            const icon = document.getElementById('themeIcon');
            const text = document.getElementById('themeText');

            /*
            |--------------------------------------------------------------------------
            | Apply Theme
            |--------------------------------------------------------------------------
            */

            function applyTheme(theme) {

                if (theme === 'dark') {

                    root.classList.add('dark-mode');

                    if (icon) {
                        icon.className = 'fa-solid fa-sun';
                    }

                    if (text) {
                        text.textContent = 'Light Mode';
                    }

                } else {

                    root.classList.remove('dark-mode');

                    if (icon) {
                        icon.className = 'fa-solid fa-moon';
                    }

                    if (text) {
                        text.textContent = 'Dark Mode';
                    }

                }

            }


            /*
            |--------------------------------------------------------------------------
            | Load Saved Theme
            |--------------------------------------------------------------------------
            */

            const savedTheme =
                localStorage.getItem('teacher-dashboard-theme');

            if (savedTheme) {

                applyTheme(savedTheme);

            } else {

                /*
                 * First visit:
                 * browser/system dark mode ko respect karega.
                 */

                const prefersDark =
                    window.matchMedia &&
                    window.matchMedia(
                        '(prefers-color-scheme: dark)'
                    ).matches;

                applyTheme(
                    prefersDark ? 'dark' : 'light'
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Toggle Theme
            |--------------------------------------------------------------------------
            */

            if (toggle) {

                toggle.addEventListener('click', function () {

                    const darkMode =
                        root.classList.contains('dark-mode');

                    const newTheme =
                        darkMode ? 'light' : 'dark';

                    applyTheme(newTheme);

                    localStorage.setItem(
                        'teacher-dashboard-theme',
                        newTheme
                    );

                });

            }

        });

    </script>

</x-app-layout>