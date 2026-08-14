@extends('layouts.admin')


@section('content')


<div class="container-fluid">


<!-- Header -->

<div class="d-flex justify-content-between align-items-center mb-4">


<div>

<h2 class="fw-bold">
Students Management
</h2>


<p class="text-muted">
Manage Glorify Academy students
</p>


</div>



<a href="{{ route('students.create') }}" class="btn btn-primary">

<i class="fa-solid fa-plus"></i>

Add Student

</a>


</div>





<!-- Statistics Cards -->


<div class="row g-4 mb-4">


<div class="col-md-3">


<div class="dashboard-card">


<div class="d-flex align-items-center">


<div class="bg-primary text-white rounded-circle p-3">

<i class="fa-solid fa-user-graduate fa-lg"></i>

</div>



<div class="ms-3">


<h3 class="fw-bold mb-1">

{{ $totalStudents }}

</h3>


<p class="text-muted mb-0">

Total Students

</p>


</div>


</div>


</div>


</div>






<div class="col-md-3">


<div class="dashboard-card">


<div class="d-flex align-items-center">


<div class="bg-success text-white rounded-circle p-3">

<i class="fa-solid fa-child fa-lg"></i>

</div>



<div class="ms-3">


<h3 class="fw-bold mb-1">

{{ $maleStudents }}

</h3>


<p class="text-muted mb-0">

Male Students

</p>


</div>


</div>


</div>


</div>







<div class="col-md-3">


<div class="dashboard-card">


<div class="d-flex align-items-center">


<div class="bg-warning text-white rounded-circle p-3">

<i class="fa-solid fa-child-dress fa-lg"></i>

</div>



<div class="ms-3">


<h3 class="fw-bold mb-1">

{{ $femaleStudents }}

</h3>


<p class="text-muted mb-0">

Female Students

</p>


</div>


</div>


</div>


</div>







<div class="col-md-3">


<div class="dashboard-card">


<div class="d-flex align-items-center">


<div class="bg-danger text-white rounded-circle p-3">

<i class="fa-solid fa-calendar-plus fa-lg"></i>

</div>



<div class="ms-3">


<h3 class="fw-bold mb-1">

{{ $newAdmissions }}

</h3>


<p class="text-muted mb-0">

New Admissions

</p>


</div>


</div>


</div>


</div>




</div>






<!-- Student Table -->


<div class="card shadow border-0 rounded-4">


<div class="card-body">



@if(session('success'))

<div class="alert alert-success">

{{ session('success') }}

</div>

@endif




<div class="mb-4">


<form method="GET"
action="{{ route('students.index') }}">


<div class="row g-3 mb-4">


<div class="col-md-5">

<input type="text"
name="search"
class="form-control"
placeholder="Search name or student ID..."
value="{{ request('search') }}">

</div>




<div class="col-md-3">


<select name="class_room_id"
class="form-control">


<option value="">
All Classes
</option>


@foreach($classes as $class)


<option value="{{ $class->id }}"
{{ request('class_room_id')==$class->id?'selected':'' }}>


{{ $class->class_name }}


</option>


@endforeach


</select>


</div>




<div class="col-md-2">


<select name="gender"
class="form-control">


<option value="">
Gender
</option>


<option value="Male">
Male
</option>


<option value="Female">
Female
</option>


</select>


</div>



<div class="col-md-2">

<button class="btn btn-primary w-100">

<i class="fa-solid fa-filter"></i>
Filter

</button>


</div>



</div>


</form>

</div>





<div class="table-responsive">


<table class="table align-middle table-hover">


<thead>


<tr>

<th>Photo</th>

<th>Student ID</th>

<th>Name</th>

<th>Class</th>

<th>Shift</th>

<th>Phone</th>

<th>Action</th>




</tr>


</thead>




<tbody>


@if($students->count() > 0)



@foreach($students as $student)



<tr>



<td>



@if($student->photo)


<img src="{{ asset('storage/'.$student->photo) }}"
width="50"
height="50"
class="rounded-circle"
style="object-fit:cover;">



@else


<img src="https://ui-avatars.com/api/?name={{ $student->name }}"
width="50"
height="50"
class="rounded-circle">


@endif



</td>




<td>

{{ $student->student_id }}

</td>





<td>

<strong>

{{ $student->name }}

</strong>

</td>





<td>

{{ $student->classRoom->class_name ?? 'Not Assigned' }}

</td>


<td>

    {{ $student->shift->name ?? '-' }}

</td>


<td>

{{ $student->contact }}

</td>





<td>



<a href="{{ route('students.show',$student->id) }}"
class="btn btn-sm btn-info rounded-circle text-white">

<i class="fa-solid fa-eye"></i>

</a>




<a href="{{ route('students.edit',$student->id) }}"
class="btn btn-sm btn-warning rounded-circle">

<i class="fa-solid fa-pen"></i>

</a>




<form action="{{ route('students.destroy',$student->id) }}"
method="POST"
style="display:inline;">


@csrf

@method('DELETE')



<button class="btn btn-sm btn-danger rounded-circle"
onclick="return confirm('Are you sure you want to delete this student?')">


<i class="fa-solid fa-trash"></i>


</button>



<a href="{{ route('students.idcard', $student->id) }}"
   class="btn btn-primary btn-sm"
   target="_blank">
    <i class="fas fa-id-card"></i> ID Card
</a>



</form>



</td>



</tr>




@endforeach



@else



<tr>

<td colspan="6" class="text-center text-muted">

No Students Found

</td>


</tr>



@endif



</tbody>


</table>


</div>



</div>


</div>


</div>


@endsection