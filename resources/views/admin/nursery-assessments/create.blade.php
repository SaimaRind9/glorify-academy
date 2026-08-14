@extends('layouts.admin')

@section('title', 'Nursery Activity Assessment')

@section('content')

<div class="container-fluid">

    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                Nursery Activity Assessment
            </h1>
            <p class="text-muted mb-0">
                Enter activity-based assessment for Nursery students.
            </p>
        </div>

        <a href="{{ route('nursery-assessments.index') }}"
           class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i>
            Back
        </a>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}

            <button class="btn-close"
                    data-bs-dismiss="alert">
            </button>
        </div>
    @endif

    {{-- Error Message --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-times-circle"></i>
            {{ session('error') }}

            <button class="btn-close"
                    data-bs-dismiss="alert">
            </button>
        </div>
    @endif

    {{-- Validation Errors --}}
    @if($errors->any())

        <div class="alert alert-danger">

            <strong>Please fix the following errors:</strong>

            <ul class="mb-0 mt-2">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    <!-- Filter Card -->

    <div class="card shadow mb-4">

        <div class="card-header py-3">

            <h6 class="m-0 font-weight-bold text-primary">

                Select Exam & Class

            </h6>

        </div>

        <div class="card-body">

            <form
                method="GET"
                action="{{ route('nursery-assessments.create') }}"
            >

                <div class="row">

                    <!-- Exam -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Select Exam

                        </label>

                        <select
                            name="exam_id"
                            class="form-select"
                            required
                        >

                            <option value="">

                                -- Select Exam --

                            </option>

                            @foreach($exams as $exam)

                                <option
                                    value="{{ $exam->id }}"
                                    {{ $selectedExamId == $exam->id ? 'selected' : '' }}
                                >

                                    {{ $exam->exam_name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <!-- Nursery Class -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Select Nursery Class

                        </label>

                        <select
                            name="class_room_id"
                            class="form-select"
                            required
                        >

                            <option value="">

                                -- Select Class --

                            </option>

                            @foreach($nurseryClasses as $class)

                                <option
                                    value="{{ $class->id }}"
                                    {{ $selectedClassRoomId == $class->id ? 'selected' : '' }}
                                >

                                    {{ $class->class_name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                </div>

                <button
                    class="btn btn-primary"
                    type="submit"
                >

                    <i class="fas fa-search"></i>

                    Load Students

                </button>

            </form>

        </div>

    </div>

@if($students->count())

<div class="card shadow">

    <div class="card-header bg-primary text-white">

        <h5 class="mb-0">

            Nursery Activity Assessment

        </h5>

    </div>

    <div class="card-body">

        <form
            action="{{ route('nursery-assessments.store') }}"
            method="POST"
        >

            @csrf

            <input
                type="hidden"
                name="exam_id"
                value="{{ $selectedExamId }}"
            >

            <input
                type="hidden"
                name="class_room_id"
                value="{{ $selectedClassRoomId }}"
            >

                        {{-- Assessment Table --}}
            <div class="table-responsive assessment-table-wrapper">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-light">

                        <tr>
                            <th class="student-column">
                                Student
                            </th>

                            @foreach($activities as $activity)
                                <th class="activity-column text-center">
                                    {{ $activity->activity_name }}
                                </th>
                            @endforeach

                            <th class="remarks-column">
                                Teacher Remarks
                            </th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach($students as $student)

                            <tr>

                                {{-- Student Information --}}
                                <td class="student-info">

                                    <div class="student-name">
                                        {{ $student->name }}
                                    </div>

                                    <div class="student-details">

                                        @if(!empty($student->student_id))
                                            <span>
                                                ID: {{ $student->student_id }}
                                            </span>
                                        @endif

                                        @if(!empty($student->roll_number))
                                            <span>
                                                Roll No: {{ $student->roll_number }}
                                            </span>
                                        @endif

                                    </div>

                                </td>

                                {{-- Dynamic Activity Dropdowns --}}
                                @foreach($activities as $activity)

                                    @php
                                        $assessmentKey = $student->id . '-' . $activity->id;

                                        $savedAssessment = $existingAssessments
                                            ->get($assessmentKey);

                                        $selectedAssessment = old(
                                            'assessments.'
                                            . $student->id
                                            . '.'
                                            . $activity->id,
                                            $savedAssessment?->assessment
                                        );
                                    @endphp

                                    <td>

                                        <select
                                            name="assessments[{{ $student->id }}][{{ $activity->id }}]"
                                            class="form-select assessment-select"
                                        >

                                            <option value="">
                                                Select
                                            </option>

                                            @foreach($assessmentLevels as $level)

                                                <option
                                                    value="{{ $level }}"
                                                    {{ $selectedAssessment === $level ? 'selected' : '' }}
                                                >
                                                    {{ $level }}
                                                </option>

                                            @endforeach

                                        </select>

                                        @error(
                                            'assessments.'
                                            . $student->id
                                            . '.'
                                            . $activity->id
                                        )
                                            <small class="text-danger d-block mt-1">
                                                {{ $message }}
                                            </small>
                                        @enderror

                                    </td>

                                @endforeach

                                {{-- Teacher Remarks --}}
                                <td>

                                    @php
                                        $studentSavedAssessment =
                                            $existingAssessments
                                                ->firstWhere(
                                                    'student_id',
                                                    $student->id
                                                );

                                        $savedRemarks =
                                            $studentSavedAssessment?->remarks;
                                    @endphp

                                    <textarea
                                        name="remarks[{{ $student->id }}]"
                                        class="form-control remarks-input"
                                        rows="2"
                                        maxlength="1000"
                                        placeholder="Write remarks..."
                                    >{{ old(
                                        'remarks.' . $student->id,
                                        $savedRemarks
                                    ) }}</textarea>

                                    @error('remarks.' . $student->id)
                                        <small class="text-danger d-block mt-1">
                                            {{ $message }}
                                        </small>
                                    @enderror

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            {{-- Assessment Guide --}}
            <div class="assessment-guide mt-4">

                <h6 class="mb-3">
                    <i class="fas fa-star"></i>
                    Assessment Guide
                </h6>

                <div class="row g-2">

                    <div class="col-lg col-md-4 col-6">
                        <div class="guide-item">
                            <strong>Excellent</strong>
                            <span>★★★★★</span>
                        </div>
                    </div>

                    <div class="col-lg col-md-4 col-6">
                        <div class="guide-item">
                            <strong>Very Good</strong>
                            <span>★★★★☆</span>
                        </div>
                    </div>

                    <div class="col-lg col-md-4 col-6">
                        <div class="guide-item">
                            <strong>Good</strong>
                            <span>★★★☆☆</span>
                        </div>
                    </div>

                    <div class="col-lg col-md-4 col-6">
                        <div class="guide-item">
                            <strong>Satisfactory</strong>
                            <span>★★☆☆☆</span>
                        </div>
                    </div>

                    <div class="col-lg col-md-4 col-6">
                        <div class="guide-item">
                            <strong>Needs Improvement</strong>
                            <span>★☆☆☆☆</span>
                        </div>
                    </div>

                </div>

            </div>

            {{-- Form Actions --}}
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mt-4">

                <a
                    href="{{ route('nursery-assessments.index') }}"
                    class="btn btn-outline-secondary"
                >
                    <i class="fas fa-list"></i>
                    View Saved Assessments
                </a>

                <button
                    type="submit"
                    class="btn btn-success px-4"
                    id="saveAssessmentButton"
                >
                    <i class="fas fa-save"></i>
                    Save Assessments
                </button>

            </div>

        </form>

    </div>

</div>

@else

<div class="card shadow">

    <div class="card-body text-center py-5">

        <i class="fas fa-user-graduate fa-4x text-secondary mb-3"></i>

        <h5>No Students Loaded</h5>

        <p class="text-muted">
            Please select an Exam and Nursery Class, then click
            <strong>Load Students</strong>.
        </p>

    </div>

</div>

@endif

</div>

@endsection

@push('styles')

<style>

.assessment-table-wrapper{

    overflow-x:auto;

}

.assessment-table-wrapper table{

    min-width:1500px;

}

.student-column{

    min-width:220px;

    background:#f8f9fa;

}

.activity-column{

    min-width:150px;

    text-align:center;

}

.remarks-column{

    min-width:250px;

}

.student-info{

    font-size:14px;

}

.student-name{

    font-weight:700;

    color:#0d6efd;

}

.student-details{

    font-size:12px;

    color:#6c757d;

    margin-top:4px;

}

.student-details span{

    display:block;

}

.assessment-select{

    min-width:140px;

}

.remarks-input{

    resize:vertical;

}

.guide-item{

    background:#f8f9fa;

    border-radius:8px;

    padding:12px;

    text-align:center;

    border:1px solid #dee2e6;

}

.guide-item strong{

    display:block;

    margin-bottom:5px;

}

@media(max-width:768px){

    .assessment-table-wrapper table{

        min-width:1300px;

    }

}

</style>

@endpush


@push('scripts')

<script>

document.addEventListener("DOMContentLoaded",function(){

    const form=document.querySelector("form[action='{{ route('nursery-assessments.store') }}']");

    if(form){

        form.addEventListener("submit",function(){

            const btn=document.getElementById("saveAssessmentButton");

            btn.disabled=true;

            btn.innerHTML='<i class="fas fa-spinner fa-spin"></i> Saving...';

        });

    }

});

</script>

@endpush