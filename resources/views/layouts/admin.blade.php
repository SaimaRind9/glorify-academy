<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') | The Glorify Academy</title>

    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f6f9;
            color: #333;
            overflow-x: hidden;
        }

        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */

        .sidebar {
    width: 260px;
    height: 100vh;
    background: linear-gradient(180deg, #182848 0%, #273c75 100%);
    color: white;

    position: fixed;
    top: 0;
    left: 0;

    z-index: 1000;
    transition: all 0.3s ease;

    overflow-y: auto;
    overflow-x: hidden;
}

        .sidebar-brand {
            padding: 24px 18px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
        }

        .sidebar-brand h3 {
            font-size: 21px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .sidebar-brand p {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.7);
            margin: 0;
        }

        .sidebar-menu {
            list-style: none;
            padding: 18px 12px;
            margin: 0;
        }

        .sidebar-menu li {
            margin-bottom: 7px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 12px 15px;
            color: rgba(255, 255, 255, 0.82);
            text-decoration: none;
            border-radius: 9px;
            font-size: 14px;
            transition: all 0.25s ease;
        }

        .sidebar-menu a:hover {
            background: rgba(255, 255, 255, 0.12);
            color: white;
            transform: translateX(3px);
        }

        .sidebar-menu a.active {
            background: white;
            color: #273c75;
            font-weight: 600;
        }

        .sidebar-menu a i {
            width: 22px;
            font-size: 17px;
            text-align: center;
        }

        .menu-heading {
            color: rgba(255, 255, 255, 0.45);
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 15px 15px 7px;
        }

        /* Main Content */

        .main-content {
            width: calc(100% - 260px);
            margin-left: 260px;
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        /* Top Navbar */

        .top-navbar {
            height: 70px;
            background: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
            position: sticky;
            top: 0;
            z-index: 900;
        }

        .navbar-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .menu-toggle {
            border: none;
            background: #f1f3f8;
            color: #273c75;
            width: 42px;
            height: 42px;
            border-radius: 9px;
            font-size: 18px;
            cursor: pointer;
        }

        .page-heading {
            font-size: 20px;
            font-weight: 700;
            color: #273c75;
            margin: 0;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .admin-profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .admin-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #273c75;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: 700;
        }

        .admin-info {
            line-height: 1.2;
        }

        .admin-info strong {
            display: block;
            font-size: 14px;
            color: #333;
        }

        .admin-info span {
            font-size: 12px;
            color: #888;
        }

        .fee-submenu {
    display: none;
    list-style: none;
    margin: 5px 0 5px 25px;
    padding: 0;
}

.fee-submenu.show {
    display: block;
}

.fee-submenu li a {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 9px 12px;
    text-decoration: none;
    font-size: 14px;
}

.fee-submenu li a i {
    width: 18px;
}

#feeArrow {
    transition: transform 0.25s ease;
}

#feeArrow.rotate {
    transform: rotate(180deg);
}

        /* Page Content */

        .content-area {
            padding: 25px;
        }

        .content-card {
            background: white;
            border-radius: 14px;
            padding: 22px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.05);
        }

        /* Alerts */

        .alert {
            border: none;
            border-radius: 10px;
        }

        /* Dropdown */

        .dropdown-menu {
            border: none;
            border-radius: 10px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }

        .dropdown-item {
            font-size: 14px;
            padding: 10px 15px;
        }

        /* Mobile */

        @media (max-width: 991px) {
            .sidebar {
                left: -260px;
            }

            .sidebar.show {
                left: 0;
            }

            .main-content {
                width: 100%;
                margin-left: 0;
            }

            .sidebar-overlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, 0.45);
                z-index: 999;
            }

            .sidebar-overlay.show {
                display: block;
            }
        }

        @media (max-width: 576px) {
            .content-area {
                padding: 15px;
            }

            .top-navbar {
                padding: 0 15px;
            }

            .admin-info {
                display: none;
            }

            .page-heading {
                font-size: 16px;
            }
        }
    </style>

    @stack('styles')
    <script>
function toggleFeeMenu() {

    const menu = document.getElementById('feeSubmenu');
    const arrow = document.getElementById('feeArrow');

    menu.classList.toggle('show');
    arrow.classList.toggle('rotate');
}
</script>
</head>

<body>

<div class="admin-wrapper">

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">

        <div class="sidebar-brand">
            <h3>The Glorify Academy</h3>
            <p>School Management System</p>
        </div>

        <ul class="sidebar-menu">

            <li>
                <a
                    href="{{ route('dashboard') }}"
                    class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"
                >
                    <i class="fa-solid fa-gauge-high"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="menu-heading">Academic Management</li>

            <li>
                <a
                    href="{{ route('students.index') }}"
                    class="{{ request()->routeIs('students.*') ? 'active' : '' }}"
                >
                    <i class="fa-solid fa-user-graduate"></i>
                    <span>Students</span>
                </a>
            </li>

            <li>
                <a
                    href="{{ route('teachers.index') }}"
                    class="{{ request()->routeIs('teachers.*') ? 'active' : '' }}"
                >
                    <i class="fa-solid fa-chalkboard-user"></i>
                    <span>Teachers</span>
                </a>
            </li>

            <li>
    <a href="{{ route('class-rooms.index') }}">
        <i class="fa-solid fa-school"></i>
        <span>Classes</span>
    </a>
</li>
            <li class="menu-heading">School Operations</li>

            <li>
                <a href="{{ route('admin.attendance.index') }}">
    <i class="fa-solid fa-calendar-check"></i>
    <span>Attendance</span>
</a>
            </li>

            <li class="menu-item">

    <a href="javascript:void(0);"
       class="menu-link"
       onclick="toggleFeeMenu()">

        <i class="fa-solid fa-money-bill-wave"></i>

        <span>Fees</span>

        <i class="fa-solid fa-chevron-down ms-auto"
           id="feeArrow"></i>

    </a>


    <ul id="feeSubmenu"
        class="fee-submenu">

        <li>
            <a href="{{ route('fee-types.index') }}">
                <i class="fa-solid fa-tags"></i>
                Fee Types
            </a>
        </li>

        <li>
            <a href="{{ route('fee-structures.index') }}">
                <i class="fa-solid fa-list-check"></i>
                Fee Structure
            </a>
        </li>

        <li>
            <a href="{{ route('student-fee-assignments.index') }}">
                <i class="fa-solid fa-user-tag"></i>
                Student Fee Assignment
            </a>
        </li>

        <li>
            <a href="{{ route('fee-challans.create') }}">
                <i class="fa-solid fa-file-circle-plus"></i>
                Generate Challan
            </a>
        </li>

        <li>
            <a href="{{ route('fee-challans.index') }}">
                <i class="fa-solid fa-file-invoice-dollar"></i>
                Fee Challans
            </a>
        </li>

        <li>
            <a href="{{ route('fee-reports.index') }}">
                <i class="fa-solid fa-chart-column"></i>
                Fee Reports
            </a>
        </li>

    </ul>

</li>

            <li>
                <a href="{{ route('exams.index') }}">
                    <i class="fa-solid fa-file-pen"></i>
                    <span>Examinations</span>
                </a>
            </li>

            <li>
                <a href="{{ route('results.index') }}">
                    <i class="fa-solid fa-chart-column"></i>
                    <span>Results</span>
                </a>
            </li>

            <li class="menu-heading">Account</li>

            <li>
                <a href="{{ route('profile.edit') }}">
                    <i class="fa-solid fa-user-gear"></i>
                    <span>Profile</span>
                </a>
            </li>

            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button
                        type="submit"
                        style="
                            width: 100%;
                            border: none;
                            background: transparent;
                            color: rgba(255, 255, 255, 0.82);
                            display: flex;
                            align-items: center;
                            gap: 13px;
                            padding: 12px 15px;
                            border-radius: 9px;
                            font-size: 14px;
                        "
                    >
                        <i
                            class="fa-solid fa-right-from-bracket"
                            style="width: 22px;"
                        ></i>

                        <span>Logout</span>
                    </button>
                </form>
            </li>

        </ul>

    </aside>

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Main Content -->
    <main class="main-content">

        <!-- Top Navbar -->
        <nav class="top-navbar">

            <div class="navbar-left">

                <button
                    type="button"
                    class="menu-toggle"
                    id="menuToggle"
                >
                    <i class="fa-solid fa-bars"></i>
                </button>

                <h1 class="page-heading">
                    @yield('page-title', 'Dashboard')
                </h1>

            </div>

            <div class="navbar-right">

                <div class="dropdown">

                    <button
                        class="btn border-0 dropdown-toggle admin-profile"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                    >
                        <div class="admin-avatar">
                            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                        </div>

                        <div class="admin-info text-start">
                            <strong>
                                {{ auth()->user()->name ?? 'Admin' }}
                            </strong>

                            <span>
                                Administrator
                            </span>
                        </div>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end">

                        <li>
                            <a
                                class="dropdown-item"
                                href="{{ route('profile.edit') }}"
                            >
                                <i class="fa-solid fa-user me-2"></i>
                                My Profile
                            </a>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <button
                                    type="submit"
                                    class="dropdown-item text-danger"
                                >
                                    <i class="fa-solid fa-right-from-bracket me-2"></i>
                                    Logout
                                </button>
                            </form>
                        </li>

                    </ul>

                </div>

            </div>

        </nav>

        <!-- Content -->
        <section class="content-area">

            @if(session('success'))
                <div
                    class="alert alert-success alert-dismissible fade show"
                    role="alert"
                >
                    <i class="fa-solid fa-circle-check me-2"></i>

                    {{ session('success') }}

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                    ></button>
                </div>
            @endif

            @if(session('error'))
                <div
                    class="alert alert-danger alert-dismissible fade show"
                    role="alert"
                >
                    <i class="fa-solid fa-circle-exclamation me-2"></i>

                    {{ session('error') }}

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                    ></button>
                </div>
            @endif

            @if($errors->any())
                <div
                    class="alert alert-danger alert-dismissible fade show"
                    role="alert"
                >
                    <strong>Please fix the following errors:</strong>

                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                    ></button>
                </div>
            @endif

            @yield('content')

        </section>

    </main>

</div>

<!-- Bootstrap JS -->
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>

<script>
    const sidebar = document.getElementById('sidebar');
    const menuToggle = document.getElementById('menuToggle');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    menuToggle.addEventListener('click', function () {
        sidebar.classList.toggle('show');
        sidebarOverlay.classList.toggle('show');
    });

    sidebarOverlay.addEventListener('click', function () {
        sidebar.classList.remove('show');
        sidebarOverlay.classList.remove('show');
    });
</script>

@stack('scripts')

</body>

</html>