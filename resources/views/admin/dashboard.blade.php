@extends('layouts.admin')

@section('content')

<div class="container-fluid py-4">

    {{-- Welcome Section --}}
    <div class="welcome-box mb-4">
        <div>
            <p class="welcome-small mb-1">
                {{ now()->format('l, d F Y') }}
            </p>

            <h2 class="welcome-title mb-2">
                Welcome Back, {{ auth()->user()->name }} 👋
            </h2>

            <p class="welcome-text mb-0">
                Here is today's overview of The Glorify Academy.
            </p>
        </div>

        <div class="welcome-icon">
            <i class="fa-solid fa-school"></i>
        </div>
    </div>


    {{-- Statistics Cards --}}
    <div class="row g-4 mb-4">

        {{-- Students --}}
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon students-icon">
                    <i class="fa-solid fa-user-graduate"></i>
                </div>

                <div>
                    <p class="stat-label">Total Students</p>
                    <h3 class="stat-number">{{ $totalStudents }}</h3>

                    <a href="{{ route('students.index') }}" class="stat-link">
                        View Students
                        <i class="fa-solid fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>


        


        {{-- Teachers --}}
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon teachers-icon">
                    <i class="fa-solid fa-chalkboard-user"></i>
                </div>

                <div>
                    <p class="stat-label">Total Teachers</p>
                    <h3 class="stat-number">{{ $totalTeachers }}</h3>

                    <a href="{{ route('teachers.index') }}" class="stat-link">
                        View Teachers
                        <i class="fa-solid fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>


        {{-- Parents --}}
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon parents-icon">
                    <i class="fa-solid fa-people-roof"></i>
                </div>

                <div>
                    <p class="stat-label">Registered Parents</p>
                    <h3 class="stat-number">{{ $totalParents }}</h3>

                    <span class="stat-muted">
                        Parent login accounts
                    </span>
                </div>
            </div>
        </div>


        {{-- Classes --}}
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon classes-icon">
                    <i class="fa-solid fa-school-flag"></i>
                </div>

                <div>
                    <p class="stat-label">Total Classes</p>
                    <h3 class="stat-number">{{ $totalClasses }}</h3>

                    <a href="{{ route('class-rooms.index') }}" class="stat-link">
                        View Classes
                        <i class="fa-solid fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

    </div>



{{-- Quick Actions --}}
<div class="dashboard-card mb-4">

    <div class="card-heading">
        <div>
            <h5>Quick Actions</h5>
            <p>Manage academy modules with one click</p>
        </div>

        <div class="heading-icon">
            <i class="fa-solid fa-bolt"></i>
        </div>
    </div>

    <div class="row g-3">

        <div class="col-lg-3 col-md-4 col-6">
            <a href="{{ route('admin.attendance.index') }}" class="quick-action action-blue">
                <i class="fa-solid fa-calendar-check"></i>
                <span>Attendance</span>
            </a>
        </div>

        <div class="col-lg-3 col-md-4 col-6">
            <a href="{{ route('subjects.index') }}" class="quick-action action-green">
                <i class="fa-solid fa-book"></i>
                <span>Subjects</span>
            </a>
        </div>

        <div class="col-lg-3 col-md-4 col-6">
            <a href="{{ route('exams.index') }}" class="quick-action action-orange">
                <i class="fa-solid fa-file-pen"></i>
                <span>Exams</span>
            </a>
        </div>

        <div class="col-lg-3 col-md-4 col-6">
    <a href="{{ route('marks.index') }}" class="quick-action action-eal">
        <i class="fa-solid fa-clipboard-check"></i>
        <span>Marks</span>
    </a>
</div>

        <div class="col-lg-3 col-md-4 col-6">
            <a href="{{ route('results.index') }}" class="quick-action action-purple">
                <i class="fa-solid fa-square-poll-vertical"></i>
                <span>Results</span>
            </a>
        </div>

        <div class="col-lg-3 col-md-4 col-6">
            <a href="{{ route('nursery-assessments.index') }}" class="quick-action action-purple">
                <i class="fa-solid fa-square-poll-vertical"></i>
                <span>Nursery Assessments</span>
            </a>
        </div>

        <div class="col-lg-3 col-md-4 col-6">
            <a href="{{ route('fee-structures.index') }}" class="quick-action action-red">
                <i class="fa-solid fa-money-bill-wave"></i>
                <span>Fees</span>
            </a>
        </div>

        <div class="col-lg-3 col-md-4 col-6">
            <a href="{{ route('notices.index') }}" class="quick-action action-teal">
                <i class="fa-solid fa-bullhorn"></i>
                <span>Notices</span>
            </a>
        </div>

    </div>

</div>


    {{-- First Charts Row --}}
    <div class="row g-4 mb-4">

        {{-- Monthly Admissions --}}
        <div class="col-xl-8">
            <div class="dashboard-card h-100">

                <div class="card-heading">
                    <div>
                        <h5>Monthly Admissions</h5>
                        <p>Student admission records for {{ now()->year }}</p>
                    </div>

                    <div class="heading-icon">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                </div>

                <div class="chart-container large-chart">
                    <canvas id="monthlyAdmissionsChart"></canvas>
                </div>

            </div>
        </div>


        {{-- Gender Distribution --}}
        <div class="col-xl-4">
            <div class="dashboard-card h-100">

                <div class="card-heading">
                    <div>
                        <h5>Gender Distribution</h5>
                        <p>Male and female students</p>
                    </div>

                    <div class="heading-icon">
                        <i class="fa-solid fa-chart-pie"></i>
                    </div>
                </div>

                <div class="chart-container gender-chart">
                    <canvas id="genderChart"></canvas>
                </div>

                <div class="gender-summary">
                    <div>
                        <span class="gender-dot male-dot"></span>
                        Male
                        <strong>{{ $maleStudents }}</strong>
                    </div>

                    <div>
                        <span class="gender-dot female-dot"></span>
                        Female
                        <strong>{{ $femaleStudents }}</strong>
                    </div>
                </div>

            </div>
        </div>

    </div>


    {{-- Students by Class --}}
    <div class="row g-4 mb-4">

        <div class="col-12">
            <div class="dashboard-card">

                <div class="card-heading">
                    <div>
                        <h5>Students by Class</h5>
                        <p>Number of enrolled students in each class</p>
                    </div>

                    <div class="heading-icon">
                        <i class="fa-solid fa-chart-column"></i>
                    </div>
                </div>

                <div class="chart-container class-chart">
                    <canvas id="studentsByClassChart"></canvas>
                </div>

            </div>
        </div>

    </div>


    {{-- Recent Records --}}
    <div class="row g-4">

        {{-- Recent Students --}}
        <div class="col-xl-6">
            <div class="dashboard-card h-100">

                <div class="card-heading">
                    <div>
                        <h5>Recently Added Students</h5>
                        <p>Latest student admissions</p>
                    </div>

                    <a href="{{ route('students.index') }}"
                       class="view-all-link">
                        View All
                    </a>
                </div>

                <div class="recent-list">

                    @forelse($recentStudents as $student)

                        <div class="recent-item">

                            <div class="recent-avatar student-avatar">

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

                            <div class="recent-info">
                                <h6>{{ $student->name }}</h6>

                                <p>
                                    Student ID:
                                    {{ $student->student_id }}
                                </p>
                            </div>

                            <div class="recent-date">
                                {{ $student->created_at->diffForHumans() }}
                            </div>

                        </div>

                    @empty

                        <div class="empty-record">
                            <i class="fa-solid fa-user-graduate"></i>
                            <p>No student records found.</p>
                        </div>

                    @endforelse

                </div>

            </div>
        </div>


        {{-- Recent Teachers --}}
        <div class="col-xl-6">
            <div class="dashboard-card h-100">

                <div class="card-heading">
                    <div>
                        <h5>Recently Added Teachers</h5>
                        <p>Latest teacher records</p>
                    </div>

                    <a href="{{ route('teachers.index') }}"
                       class="view-all-link">
                        View All
                    </a>
                </div>

                <div class="recent-list">

                    @forelse($recentTeachers as $teacher)

                        <div class="recent-item">

                            <div class="recent-avatar teacher-avatar">

                                @if($teacher->photo)
                                    <img
                                        src="{{ asset('storage/' . $teacher->photo) }}"
                                        alt="{{ $teacher->name }}"
                                    >
                                @else
                                    <span>
                                        {{ strtoupper(substr($teacher->name, 0, 1)) }}
                                    </span>
                                @endif

                            </div>

                            <div class="recent-info">
                                <h6>{{ $teacher->name }}</h6>

                                <p>
                                    {{ $teacher->email ?? 'Email not available' }}
                                </p>
                            </div>

                            <div class="recent-date">
                                {{ $teacher->created_at->diffForHumans() }}
                            </div>

                        </div>

                    @empty

                        <div class="empty-record">
                            <i class="fa-solid fa-chalkboard-user"></i>
                            <p>No teacher records found.</p>
                        </div>

                    @endforelse

                </div>

            </div>
        </div>

    </div>

</div>


{{-- Dashboard Styling --}}
<style>

    .welcome-box {
        background: linear-gradient(135deg, #172554, #2563eb);
        color: white;
        border-radius: 20px;
        padding: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 15px 35px rgba(37, 99, 235, 0.18);
        overflow: hidden;
        position: relative;
    }

    .welcome-box::before {
        content: "";
        position: absolute;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.08);
        right: -50px;
        top: -100px;
    }

    .welcome-small {
        font-size: 14px;
        opacity: 0.85;
    }

    .welcome-title {
        font-size: 28px;
        font-weight: 700;
    }

    .welcome-text {
        font-size: 15px;
        opacity: 0.9;
    }

    .welcome-icon {
        position: relative;
        z-index: 1;
        width: 85px;
        height: 85px;
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.16);
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 38px;
    }

    .stat-card {
        background: white;
        border-radius: 18px;
        padding: 23px;
        display: flex;
        align-items: center;
        gap: 18px;
        height: 100%;
        border: 1px solid #edf0f5;
        box-shadow: 0 8px 25px rgba(15, 23, 42, 0.06);
        transition: all 0.25s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(15, 23, 42, 0.10);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 25px;
        flex-shrink: 0;
    }

    .students-icon {
        color: #2563eb;
        background: #dbeafe;
    }

    .teachers-icon {
        color: #059669;
        background: #d1fae5;
    }

    .parents-icon {
        color: #9333ea;
        background: #f3e8ff;
    }

    .classes-icon {
        color: #ea580c;
        background: #ffedd5;
    }

    .stat-label {
        margin: 0 0 4px;
        color: #64748b;
        font-size: 14px;
        font-weight: 500;
    }

    .stat-number {
        margin: 0 0 4px;
        color: #0f172a;
        font-size: 29px;
        font-weight: 750;
    }

    .action-eal{
    background: linear-gradient(135deg, #ce3094, #ec93c5);
    color: #fff;
}

/* .action-eal:hover{
    background: linear-gradient(135deg, #964385, #108077);
    color: #fff;
} */

    .stat-link,
    .stat-muted {
        font-size: 12px;
        text-decoration: none;
    }

    .stat-link {
        color: #2563eb;
        font-weight: 600;
    }

    .stat-link:hover {
        color: #1d4ed8;
    }

    .stat-muted {
        color: #94a3b8;
    }

    .dashboard-card {
        background: white;
        border-radius: 18px;
        padding: 24px;
        border: 1px solid #edf0f5;
        box-shadow: 0 8px 25px rgba(15, 23, 42, 0.06);
    }

    .card-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .card-heading h5 {
        margin: 0 0 4px;
        color: #0f172a;
        font-size: 18px;
        font-weight: 700;
    }

    .card-heading p {
        margin: 0;
        color: #94a3b8;
        font-size: 13px;
    }

    .heading-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: #eff6ff;
        color: #2563eb;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 18px;
    }

    .chart-container {
        position: relative;
        width: 100%;
    }

    .large-chart {
        height: 330px;
    }

    .gender-chart {
        height: 270px;
    }

    .class-chart {
        height: 350px;
    }

    .gender-summary {
        display: flex;
        justify-content: center;
        gap: 28px;
        margin-top: 12px;
        color: #64748b;
        font-size: 13px;
    }

    .gender-summary strong {
        color: #0f172a;
        margin-left: 4px;
    }

    .gender-dot {
        width: 9px;
        height: 9px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 5px;
    }

    .male-dot {
        background: #2563eb;
    }

    .female-dot {
        background: #ec4899;
    }

    .view-all-link {
        font-size: 13px;
        color: #2563eb;
        text-decoration: none;
        font-weight: 600;
    }

    .view-all-link:hover {
        color: #1d4ed8;
    }

    .recent-list {
        display: flex;
        flex-direction: column;
    }

    .recent-item {
        display: flex;
        align-items: center;
        padding: 14px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .recent-item:last-child {
        border-bottom: none;
    }

    .recent-avatar {
        width: 46px;
        height: 46px;
        border-radius: 13px;
        margin-right: 13px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        flex-shrink: 0;
    }

    .recent-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .student-avatar {
        background: #dbeafe;
        color: #2563eb;
    }

    .teacher-avatar {
        background: #d1fae5;
        color: #059669;
    }

    .recent-info {
        flex: 1;
        min-width: 0;
    }

    .recent-info h6 {
        margin: 0 0 3px;
        color: #0f172a;
        font-size: 14px;
        font-weight: 650;
    }

    .recent-info p {
        margin: 0;
        color: #94a3b8;
        font-size: 12px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .recent-date {
        color: #94a3b8;
        font-size: 11px;
        white-space: nowrap;
        margin-left: 10px;
    }

    .empty-record {
        text-align: center;
        padding: 35px 20px;
        color: #94a3b8;
    }

    .empty-record i {
        font-size: 30px;
        margin-bottom: 10px;
    }

    .empty-record p {
        margin: 0;
        font-size: 13px;
    }



    .quick-action{
    display:flex;
    flex-direction:column;
    justify-content:center;
    align-items:center;
    gap:12px;
    height:120px;
    border-radius:18px;
    text-decoration:none;
    color:#fff;
    font-weight:600;
    transition:.3s;
}

.quick-action i{
    font-size:34px;
}

.quick-action:hover{
    transform:translateY(-6px);
    color:#fff;
    box-shadow:0 15px 30px rgba(0,0,0,.15);
}

.action-blue{
    background:linear-gradient(135deg,#2563eb,#1d4ed8);
}

.action-green{
    background:linear-gradient(135deg,#16a34a,#15803d);
}

.action-orange{
    background:linear-gradient(135deg,#f97316,#ea580c);
}

.action-purple{
    background:linear-gradient(135deg,#9333ea,#7e22ce);
}

.action-red{
    background:linear-gradient(135deg,#ef4444,#dc2626);
}

.action-teal{
    background:linear-gradient(135deg,#0891b2,#0e7490);
}


    @media (max-width: 768px) {

        .welcome-box {
            padding: 24px;
        }

        .welcome-title {
            font-size: 22px;
        }

        .welcome-icon {
            display: none;
        }

        .large-chart,
        .class-chart {
            height: 280px;
        }

        .gender-chart {
            height: 240px;
        }

        .recent-date {
            display: none;
        }
    }

</style>


{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const classNames = @json($classNames);
        const classStudentCounts = @json($classStudentCounts);
        const monthlyAdmissionData = @json($monthlyAdmissionData);

        /*
        | Monthly Admissions Charts
        */

        const monthlyCanvas =
            document.getElementById('monthlyAdmissionsChart');

        if (monthlyCanvas) {

            new Chart(monthlyCanvas, {
                type: 'line',

                data: {
                    labels: [
                        'Jan', 'Feb', 'Mar', 'Apr',
                        'May', 'Jun', 'Jul', 'Aug',
                        'Sep', 'Oct', 'Nov', 'Dec'
                    ],

                    datasets: [{
                        label: 'Admissions',
                        data: monthlyAdmissionData,
                        borderColor: '#2563eb',
                        backgroundColor: 'rgba(37, 99, 235, 0.12)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 3,
                        pointRadius: 4,
                        pointBackgroundColor: '#2563eb',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2
                    }]
                },

                options: {
                    responsive: true,
                    maintainAspectRatio: false,

                    plugins: {
                        legend: {
                            display: false
                        }
                    },

                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            },
                            grid: {
                                color: '#f1f5f9'
                            }
                        },

                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }


        /*
        |--------------------------------------------------------------------------
        | Gender Distribution Chart
        |--------------------------------------------------------------------------
        */

        const genderCanvas =
            document.getElementById('genderChart');

        if (genderCanvas) {

            new Chart(genderCanvas, {
                type: 'doughnut',

                data: {
                    labels: ['Male', 'Female'],

                    datasets: [{
                        data: [
                            {{ $maleStudents }},
                            {{ $femaleStudents }}
                        ],

                        backgroundColor: [
                            '#2563eb',
                            '#ec4899'
                        ],

                        borderWidth: 0,
                        hoverOffset: 6
                    }]
                },

                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '68%',

                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }


        /*
        |--------------------------------------------------------------------------
        | Students by Class Chart
        |--------------------------------------------------------------------------
        */

        const classCanvas =
            document.getElementById('studentsByClassChart');

        if (classCanvas) {

            new Chart(classCanvas, {
                type: 'bar',

                data: {
                    labels: classNames,

                    datasets: [{
                        label: 'Students',
                        data: classStudentCounts,
                        backgroundColor: '#4f46e5',
                        borderRadius: 8,
                        borderSkipped: false,
                        maxBarThickness: 55
                    }]
                },

                options: {
                    responsive: true,
                    maintainAspectRatio: false,

                    plugins: {
                        legend: {
                            display: false
                        }
                    },

                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            },
                            grid: {
                                color: '#f1f5f9'
                            }
                        },

                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }

    });
</script>

@endsection