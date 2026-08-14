@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <div class="mb-4">

        <h2 class="fw-bold">
            Welcome Back, {{ auth()->user()->name }} 👋
        </h2>

        <p class="text-muted">
            The Glorify Academy Management Dashboard
        </p>

    </div>


    <div class="row g-4">

        <div class="col-lg-3 col-md-6">

            <div class="dashboard-card student-card">

                <div class="icon">
                    <i class="fa-solid fa-user-graduate"></i>
                </div>

                <h3>{{ $students }}</h3>

                <p>Total Students</p>

            </div>

        </div>


        <div class="col-lg-3 col-md-6">

            <div class="dashboard-card teacher-card">

                <div class="icon">
                    <i class="fa-solid fa-chalkboard-user"></i>
                </div>

                <h3>{{ $teachers }}</h3>

                <p>Total Teachers</p>

            </div>

        </div>


        <div class="col-lg-3 col-md-6">

            <div class="dashboard-card class-card">

                <div class="icon">
                    <i class="fa-solid fa-school"></i>
                </div>

                <h3>{{ $classes }}</h3>

                <p>Total Classes</p>

            </div>

        </div>


        <div class="col-lg-3 col-md-6">

            <div class="dashboard-card attendance-card">

                <div class="icon">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>

                <h3>{{ $attendance }}</h3>

                <p>Today's Attendance</p>

            </div>

        </div>

    </div>
<div class="mt-5">

<div class="card shadow border-0 rounded-4">

<div class="card-body">


<h4 class="fw-bold mb-4">
Recent Students
</h4>


<div class="table-responsive">

<table class="table align-middle">


<thead>

<tr>

<th>Photo</th>
<th>Name</th>
<th>Class</th>
<th>Contact</th>

</tr>

</thead>


<tbody>


@foreach($recentStudents as $student)


<tr>


<td>

@if($student->photo)

<img src="{{ asset('storage/'.$student->photo) }}"
width="45"
height="45"
class="rounded-circle"
style="object-fit:cover;">

@else

<img src="https://ui-avatars.com/api/?name={{ $student->name }}"
width="45"
class="rounded-circle">

@endif

</td>


<td>
{{ $student->name }}
</td>


<td>
{{ $student->classRoom->class_name ?? 'N/A' }}
</td>


<td>
{{ $student->contact }}
</td>


</tr>


@endforeach


</tbody>


</table>

</div>


</div>

</div>

</div>
<div class="mt-5">

<h4 class="fw-bold mb-4">
Quick Actions
</h4>


<div class="row g-4">


<div class="col-md-3">

<a href="{{ route('students.create') }}"
class="text-decoration-none">

<div class="dashboard-card text-center">

<i class="fa-solid fa-user-plus fa-2x mb-3 text-primary"></i>

<h5>
Add Student
</h5>

<p>
Register new student
</p>

</div>

</a>

</div>




<div class="col-md-3">

<a href="{{ route('teachers.create') }}"
class="text-decoration-none">


<div class="dashboard-card text-center">

<i class="fa-solid fa-chalkboard-user fa-2x mb-3 text-success"></i>

<h5>
Add Teacher
</h5>

<p>
Create teacher profile
</p>

</div>

</a>

</div>




<div class="col-md-3">

<a href="{{ route('class-rooms.create') }}"
class="text-decoration-none">


<div class="dashboard-card text-center">

<i class="fa-solid fa-school fa-2x mb-3 text-warning"></i>

<h5>
Add Class
</h5>

<p>
Create new class
</p>

</div>

</a>

</div>




<div class="col-md-3">

<a href="#"
class="text-decoration-none">


<div class="dashboard-card text-center">

<i class="fa-solid fa-calendar-check fa-2x mb-3 text-danger"></i>

<h5>
Attendance
</h5>

<p>
Manage attendance
</p>

</div>

</a>

</div>



</div>

</div>


</div>

<div class="mt-5">

<div class="card shadow border-0 rounded-4">

<div class="card-body">


<h4 class="fw-bold mb-4">
Students By Class
</h4>


<canvas id="classChart"></canvas>


</div>

</div>

</div>



<script>

const classNames = @json($classStudents->pluck('class_name'));

const studentCounts = @json($classStudents->pluck('students_count'));


new Chart(document.getElementById('classChart'), {

    type: 'bar',

    data: {

        labels: classNames,

        datasets: [{

            label: 'Students',

            data: studentCounts,

            borderWidth: 2

        }]

    },


    options: {

        responsive:true,

        plugins:{

            legend:{
                display:true
            }

        },

        scales:{

            y:{

                beginAtZero:true

            }

        }

    }

});

</script>
<div class="mt-5">

<div class="card shadow border-0 rounded-4">

<div class="card-body">

<h4 class="fw-bold mb-4">
Monthly Admissions
</h4>


<canvas id="admissionChart"></canvas>


</div>

</div>

</div>


<script>

new Chart(document.getElementById('admissionChart'), {

type:'line',

data:{

labels:@json($monthlyAdmissions->pluck('month')),

datasets:[{

label:'New Students',

data:@json($monthlyAdmissions->pluck('total')),

borderWidth:3,

fill:false

}]

},

options:{

responsive:true

}

});

</script>

<div class="mt-5">

<div class="card shadow border-0 rounded-4">

<div class="card-body">

<h4 class="fw-bold mb-4">
Attendance Overview
</h4>

<canvas id="attendanceChart" style="max-height:300px;"></canvas>

</div>

</div>

</div>


<script>

new Chart(document.getElementById('attendanceChart'), {

    type:'doughnut',

    data:{

        labels:[
            'Present',
            'Absent'
        ],

        datasets:[{

            data:[
                {{ $attendanceData['present'] }},
                {{ $attendanceData['absent'] }}
            ],

            borderWidth:2

        }]

    },

   options:{

    responsive:true,

    maintainAspectRatio:false

}

});

</script>


<div class="mt-5">

<div class="card shadow border-0 rounded-4">

<div class="card-body">

<h4 class="fw-bold mb-4">
Recent Activity
</h4>


@foreach($recentActivities as $activity)

<div class="d-flex align-items-center mb-3">


<div class="rounded-circle bg-primary text-white p-3">

<i class="fa-solid {{ $activity['icon'] }}"></i>

</div>


<div class="ms-3">

<h6 class="mb-1">
{{ $activity['title'] }}
</h6>

<p class="text-muted mb-0">

{{ $activity['count'] }}

- {{ $activity['time'] }}

</p>

</div>


</div>

@endforeach


</div>

</div>

</div>


@endsection