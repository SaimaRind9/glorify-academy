<!DOCTYPE html>
<html>
<head>
<title>Student ID Card</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;
}

body{
    background:#f2f2f2;
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:100vh;
}


.cards-container{
    display:flex;
    flex-direction:column;
    gap:30px;
    align-items:center;
}


.card{
    width:540px;
    height:340px;
    background:#fef8ea;
    border-radius:25px;
    overflow:hidden;
    box-shadow:0 10px 25px rgba(0,0,0,.25);
    border:2px solid #0b5ed7;
}


/* HEADER */

.header{
    background:#0b5ed7;
    color:white;
    height:95px;
    padding:15px;
    text-align:center;
}


.header img{
    width:65px;
    height:65px;
    border-radius:50%;
    background:white;
    float:left;
}


.header h2{
    font-size:22px;
    padding-top:8px;
}


.header p{
    font-size:14px;
}



/* FRONT */

.photo{
    width:35%;
    float:left;
    text-align:center;
    margin-top:25px;
}


.photo img{
    width:120px;
    height:150px;
    object-fit:cover;
    border:4px solid #0b5ed7;
    border-radius:12px;
}


.title{
    text-align:center;
    color:#0b5ed7;
    font-weight:bold;
    margin-top:10px;
}


table{
    width:60%;
    float:right;
    margin-top:20px;
}


td{
    padding:6px;
    font-size:14px;
}


td:first-child{
    color:#0b5ed7;
    font-weight:bold;
}



/* BACK SIDE */


.back-content{
    padding:20px;
}


.back-header{
    display:flex;
    align-items:center;
    gap:50px;
    color:white;
    background:#0b5ed7;
    padding:15px;
    border-radius:15px;
}

.back-header img{
    width:65px;
    height:65px;
    border-radius:50%;
    background:white;
    float:left;
}


.back-header h2{
    font-size:22px;
}


.info{
    margin-top:15px;
    line-height:25px;
    font-size:14px;
}


.line{
    border-top:2px solid black;
    margin:15px 0;
}


.bottom{
    display:flex;
    justify-content:space-between;
    font-size:14px;
    line-height:25px;
}


.valid{
    color:#0b5ed7;
}


/* PRINT */

.print-btn{
    margin-top:20px;
    text-align:center;
}


button{
    background:#0b5ed7;
    color:white;
    border:none;
    padding:10px 25px;
    border-radius:8px;
}


@media print{

body{
    background:white;
}

.print-btn{
    display:none;
}

.card{
    box-shadow:none;
}

}

</style>

</head>


<body>


<div>


<div class="cards-container">


<!-- FRONT SIDE -->

<div class="card">


<div class="header">

<img src="{{ asset('images/logo.jpeg') }}">

<h2>THE GLORIFY ACADEMY</h2>

<p>Student Identity Card</p>

</div>


<div class="photo">

@if($student->photo)

<img src="{{ asset('storage/'.$student->photo) }}">

@else

<img src="{{ asset('images/default.png') }}">

@endif

</div>


<div class="title">
STUDENT ID
</div>


<table>

<tr>
<td>Name</td>
<td>{{ $student->name }}</td>
</tr>


<tr>
<td>Father</td>
<td>{{ $student->father_name }}</td>
</tr>


<tr>
<td>ID</td>
<td>{{ $student->student_id }}</td>
</tr>


<tr>
<td>Class</td>
<td>{{ $student->classRoom->class_name }}</td>
</tr>


<!-- <tr>
<td>Contact</td>
<td>{{ $student->contact }}</td>
</tr> -->


</table>


</div>



<!-- BACK SIDE -->


<div class="card">


<div class="back-content">


<div class="back-header">

<img src="{{ asset('images/logo.jpeg') }}">

<h2>THE GLORIFY ACADEMY</h2>

</div>


<div class="info">

<b>Address:</b> {{ $student->address }}

<br>

<b>Contact No:</b> {{ $student->contact }}

<br>

<b>D.O.B:</b> {{ $student->dob }}

<br>

<b>Blood Group:</b> {{ $student->blood_group }}

</div>


<div class="line"></div>


<div class="bottom">


<div>

<b>In Case of Emergency Please Inform:</b>

<br>

Name : XYZ

</div>


<div class="valid">

<b>Valid From:</b> {{ $student->valid_from }}

<br>

<b>Valid Until:</b> {{ $student->valid_until }}

</div>


</div>


</div>


</div>


</div>



<div class="print-btn">

<button onclick="window.print()">Print ID Card</button>

</div>


</div>


</body>
</html>