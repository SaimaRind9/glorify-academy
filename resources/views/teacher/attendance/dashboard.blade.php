@extends('layouts.admin')

@section('title', 'Teacher Dashboard')

@section('content')

<div class="container-fluid">

    <div class="mb-4">
        <h2 class="fw-bold mb-1">
            Teacher Dashboard
        </h2>

        <p class="text-muted mb-0">
            Manage your classes, subjects, attendance, exams, marks and results
        </p>
    </div>


    <div class="row g-4">

        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body text-center p-4">

                    <i class="fa-solid fa-school fa-2x mb-3"></i>

                    <h5 class="fw-bold">
                        My Classes
                    </h5>

                    <p class="text-muted">
                        View assigned classes and students
                    </p>

                    <a href="#"
                       class="btn btn-primary">
                        Open
                    </a>

                </div>
            </div>
        </div>


        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body text-center p-4">

                    <i class="fa-solid fa-book fa-2x mb-3"></i>

                    <h5 class="fw-bold">
                        My Subjects
                    </h5>

                    <p class="text-muted">
                        Add and manage your subjects
                    </p>

                    <a href="#"
                       class="btn btn-primary">
                        Open
                    </a>

                </div>
            </div>
        </div>


        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body text-center p-4">

                    <i class="fa-solid fa-calendar-check fa-2x mb-3"></i>

                    <h5 class="fw-bold">
                        Attendance
                    </h5>

                    <p class="text-muted">
                        Mark attendance and view history
                    </p>

                    <a href="{{ route('teacher.attendance') }}"
                       class="btn btn-primary">
                        Open
                    </a>

                </div>
            </div>
        </div>


        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body text-center p-4">

                    <i class="fa-solid fa-file-pen fa-2x mb-3"></i>

                    <h5 class="fw-bold">
                        Exams
                    </h5>

                    <p class="text-muted">
                        Create and manage exams
                    </p>

                    <a href="#"
                       class="btn btn-primary">
                        Open
                    </a>

                </div>
            </div>
        </div>


        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body text-center p-4">

                    <i class="fa-solid fa-clipboard-list fa-2x mb-3"></i>

                    <h5 class="fw-bold">
                        Marks
                    </h5>

                    <p class="text-muted">
                        Enter and edit student marks
                    </p>

                    <a href="#"
                       class="btn btn-primary">
                        Open
                    </a>

                </div>
            </div>
        </div>


        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body text-center p-4">

                    <i class="fa-solid fa-chart-column fa-2x mb-3"></i>

                    <h5 class="fw-bold">
                        Results
                    </h5>

                    <p class="text-muted">
                        Generate and view student results
                    </p>

                    <a href="#"
                       class="btn btn-primary">
                        Open
                    </a>

                </div>
            </div>
        </div>

    </div>

</div>

@endsection