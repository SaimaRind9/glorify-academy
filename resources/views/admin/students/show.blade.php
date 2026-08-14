@extends('layouts.admin')


@section('content')


<div class="container-fluid">


<div class="d-flex justify-content-between align-items-center mb-4">


<div>

<h2 class="fw-bold">
Student Profile
</h2>

<p class="text-muted">
The Glorify Academy Student Details
</p>

</div>



<a href="{{ route('students.index') }}"
class="btn btn-secondary">

<i class="fa-solid fa-arrow-left"></i>

Back

</a>


</div>





<div class="card shadow border-0 rounded-4">


<div class="card-body p-4">


<div class="row align-items-center">



<!-- Photo -->


<div class="col-md-4 text-center">


@if($student->photo)


<img src="{{ asset('storage/'.$student->photo) }}"
class="rounded-circle shadow"
width="180"
height="180"
style="object-fit:cover;">



@else


<img src="https://ui-avatars.com/api/?name={{ $student->name }}"
class="rounded-circle shadow"
width="180"
height="180">


@endif



<h3 class="mt-3 fw-bold">

{{ $student->name }}

</h3>


<p class="text-muted">

{{ $student->student_id }}

</p>


</div>






<!-- Details -->


<div class="col-md-8">


<div class="row">



<div class="col-md-6 mb-3">

<label class="text-muted">
Father Name
</label>

<h5>
{{ $student->father_name }}
</h5>

</div>




<div class="col-md-6 mb-3">

<label class="text-muted">
Class
</label>

<h5>

{{ $student->classRoom->class_name ?? 'Not Assigned' }}

</h5>

</div>






<div class="col-md-6 mb-3">

<label class="text-muted">
Date of Birth
</label>

<h5>

{{ $student->dob ?? 'N/A' }}

</h5>

</div>






<div class="col-md-6 mb-3">

<label class="text-muted">
Gender
</label>

<h5>

{{ $student->gender }}

</h5>

</div>






<div class="col-md-6 mb-3">

<label class="text-muted">
Contact
</label>

<h5>

{{ $student->contact }}

</h5>

</div>

<div class="col-md-12 mb-3">

    <label class="text-muted">
Shift
</label>

    <h5>

        {{ $student->shift->name ?? '-' }}

</h5>
</div>


<div class="col-md-12 mb-3">

<label class="text-muted">
Address
</label>

<h5>

{{ $student->address ?? 'N/A' }}

</h5>

</div>



</div>


</div>


</div>


</div>


</div>


@endsection