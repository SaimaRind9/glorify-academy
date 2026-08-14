@extends('layouts.admin')

@section('title', 'Nursery Assessments')

@section('content')

<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

        <div>
            <h1 class="h3 mb-1 text-gray-800">
                Nursery Activity Assessments
            </h1>

            <p class="text-muted mb-0">
                View and manage saved Nursery student assessments.
            </p>
        </div>

        <a href="{{ route('nursery-assessments.create') }}"
           class="btn btn-primary">

            <i class="fas fa-plus-circle me-1"></i>
            Enter Assessments

        </a>

    </div>


    {{-- Success Message --}}
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show"
             role="alert">

            <i class="fas fa-check-circle me-1"></i>
            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close">
            </button>

        </div>

    @endif


    {{-- Error Message --}}
    @if(session('error'))

        <div class="alert alert-danger alert-dismissible fade show"
             role="alert">

            <i class="fas fa-exclamation-circle me-1"></i>
            {{ session('error') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close">
            </button>

        </div>

    @endif


    {{-- Filter Card --}}
    <div class="card shadow-sm border-0 mb-4">

        <div class="card-header bg-white py-3">

            <h5 class="mb-0">
                <i class="fas fa-filter text-primary me-1"></i>
                Filter Assessments
            </h5>

        </div>

        <div class="card-body">

            <form method="GET"
                  action="{{ route('nursery-assessments.index') }}">

                <div class="row align-items-end">

                    {{-- Exam Filter --}}
                    <div class="col-lg-4 col-md-6 mb-3">

                        <label for="exam_id"
                               class="form-label fw-semibold">

                            Exam

                        </label>

                        <select name="exam_id"
                                id="exam_id"
                                class="form-select">

                            <option value="">
                                All Exams
                            </option>

                            @foreach($exams as $exam)

                                <option value="{{ $exam->id }}"
                                    {{ request('exam_id') == $exam->id ? 'selected' : '' }}>

                                    {{ $exam->exam_name }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Class Filter --}}
                    <div class="col-lg-4 col-md-6 mb-3">

                        <label for="class_room_id"
                               class="form-label fw-semibold">

                            Nursery Class

                        </label>

                        <select name="class_room_id"
                                id="class_room_id"
                                class="form-select"
                                onchange="this.form.submit()">

                            <option value="">
                                All Nursery Classes
                            </option>

                            @foreach($nurseryClasses as $class)

                                <option value="{{ $class->id }}"
                                    {{ request('class_room_id') == $class->id ? 'selected' : '' }}>

                                    {{ $class->class_name }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Student Filter --}}
                    <div class="col-lg-4 col-md-6 mb-3">

                        <label for="student_id"
                               class="form-label fw-semibold">

                            Student

                        </label>

                        <select name="student_id"
                                id="student_id"
                                class="form-select"
                                {{ $students->isEmpty() ? 'disabled' : '' }}>

                            <option value="">
                                All Students
                            </option>

                            @foreach($students as $student)

                                <option value="{{ $student->id }}"
                                    {{ request('student_id') == $student->id ? 'selected' : '' }}>

                                    {{ $student->name }}

                                    @if(!empty($student->student_id))
                                        — {{ $student->student_id }}
                                    @endif

                                </option>

                            @endforeach

                        </select>

                    </div>

                </div>


                <div class="d-flex flex-wrap gap-2">

                    <button type="submit"
                            class="btn btn-primary">

                        <i class="fas fa-search me-1"></i>
                        Apply Filters

                    </button>

                    <a href="{{ route('nursery-assessments.index') }}"
                       class="btn btn-outline-secondary">

                        <i class="fas fa-rotate-left me-1"></i>
                        Reset

                    </a>

                </div>

            </form>

        </div>

    </div>


    {{-- Assessment Records --}}
    <div class="card shadow-sm border-0">

        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">

            <h5 class="mb-0">
                <i class="fas fa-list text-primary me-1"></i>
                Saved Assessments
            </h5>

            <span class="badge bg-primary">
                {{ $assessmentRecords->count() }} Records
            </span>

        </div>

        <div class="card-body p-0">

            @if($assessmentRecords->count())

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">

                            <tr>
                                <th class="ps-4">#</th>
                                <th>Student</th>
                                <th>Class</th>
                                <th>Exam</th>
                                <th>Activities</th>
                                <th>Overall Performance</th>
                                <th>Status</th>
                                <th>Remarks</th>
                                <th class="text-center pe-4">Actions</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach($assessmentRecords as $records)

                                @php
                                    $firstRecord = $records->first();

                                    $scoreMap = [
                                        'Excellent' => 5,
                                        'Very Good' => 4,
                                        'Good' => 3,
                                        'Satisfactory' => 2,
                                        'Needs Improvement' => 1,
                                    ];

                                    $totalScore = $records->sum(function ($record) use ($scoreMap) {
                                        return $scoreMap[$record->assessment] ?? 0;
                                    });

                                    $averageScore = $records->count() > 0
                                        ? $totalScore / $records->count()
                                        : 0;

                                    if ($averageScore >= 4.5) {
                                        $overallPerformance = 'Excellent';
                                        $overallStars = '★★★★★';
                                        $badgeClass = 'success';
                                    } elseif ($averageScore >= 3.5) {
                                        $overallPerformance = 'Very Good';
                                        $overallStars = '★★★★☆';
                                        $badgeClass = 'primary';
                                    } elseif ($averageScore >= 2.5) {
                                        $overallPerformance = 'Good';
                                        $overallStars = '★★★☆☆';
                                        $badgeClass = 'info';
                                    } elseif ($averageScore >= 1.5) {
                                        $overallPerformance = 'Satisfactory';
                                        $overallStars = '★★☆☆☆';
                                        $badgeClass = 'warning';
                                    } else {
                                        $overallPerformance = 'Needs Improvement';
                                        $overallStars = '★☆☆☆☆';
                                        $badgeClass = 'danger';
                                    }

                                    $remarks = $records
                                        ->pluck('remarks')
                                        ->filter()
                                        ->first();
                                @endphp

                                <tr>

                                    <td class="ps-4">
                                        {{ $loop->iteration }}
                                    </td>


                                    {{-- Student --}}
                                    <td>

                                        <div class="fw-bold text-dark">
                                            {{ $firstRecord->student->name ?? 'N/A' }}
                                        </div>

                                        <div class="small text-muted">

                                            @if(!empty($firstRecord->student->student_id))
                                                ID: {{ $firstRecord->student->student_id }}
                                            @else
                                                Student record
                                            @endif

                                        </div>

                                    </td>


                                    {{-- Class --}}
                                    <td>

                                        <span class="badge bg-light text-dark border">
                                            {{ $firstRecord->classRoom->class_name ?? 'N/A' }}
                                        </span>

                                    </td>


                                    {{-- Exam --}}
                                    <td>
                                        {{ $firstRecord->exam->exam_name ?? 'N/A' }}
                                    </td>


                                    {{-- Activities --}}
                                    <td>

                                        <span class="fw-bold">
                                            {{ $records->count() }}
                                        </span>

                                        <span class="text-muted">
    / {{ $totalActivities }}
</span>

                                        <div class="small text-muted">
                                            assessed
                                        </div>

                                    </td>


                                    {{-- Overall --}}
<td>

    <span class="badge bg-{{ $badgeClass }} mb-1">
        {{ $overallPerformance }}
    </span>

    <div class="assessment-stars">
        {{ $overallStars }}
    </div>

</td>


{{-- Status --}}
<td>

    @if($firstRecord->publish_status == 'Published')

        <span class="badge bg-success">
            Published
        </span>

    @else

        <span class="badge bg-warning text-dark">
            Draft
        </span>

    @endif

</td>


{{-- Remarks --}}
<td class="remarks-cell">

    @if($remarks)

        <span title="{{ $remarks }}">
            {{ \Illuminate\Support\Str::limit($remarks, 45) }}
        </span>

    @else

        <span class="text-muted">
            No remarks
        </span>

    @endif

</td>
                                    {{-- Actions --}}
                                    <td class="text-center pe-4">

                                        <div class="d-flex justify-content-center gap-2">



                                        <a href="{{ route('nursery-results.show',[
    $firstRecord->student_id,
    $firstRecord->exam_id
]) }}"
class="btn btn-sm btn-outline-success"
title="View Result">

    <i class="fas fa-eye"></i>

</a>

                                            {{-- Edit --}}
                                            <a href="{{ route('nursery-assessments.create', [
                                                    'exam_id' => $firstRecord->exam_id,
                                                    'class_room_id' => $firstRecord->class_room_id
                                                ]) }}"
                                               class="btn btn-sm btn-outline-primary"
                                               title="Edit Assessment">

                                                <i class="fas fa-edit"></i>

                                            </a>





                                            @if($firstRecord->publish_status == 'Draft')

<form
    action="{{ route('nursery-assessments.publish',[
        $firstRecord->student_id,
        $firstRecord->exam_id
    ]) }}"
    method="POST"
>

    @csrf

    <button
        class="btn btn-success btn-sm"
        title="Publish Result"
    >

        <i class="fas fa-upload"></i>

    </button>

</form>

@else

<form
    action="{{ route('nursery-assessments.unpublish',[
        $firstRecord->student_id,
        $firstRecord->exam_id
    ]) }}"
    method="POST"
>

    @csrf

    <button
        class="btn btn-warning btn-sm"
        title="Move to Draft"
    >

        <i class="fas fa-download"></i>

    </button>

</form>

@endif

                                            {{-- Delete --}}
                                            <form method="POST"
                                                  action="{{ route(
                                                      'nursery-assessments.destroy',
                                                      $firstRecord->student_id
                                                  ) }}"
                                                  class="delete-assessment-form">

                                                @csrf
                                                @method('DELETE')

                                                <input type="hidden"
                                                       name="exam_id"
                                                       value="{{ $firstRecord->exam_id }}">

                                                <button type="submit"
                                                        class="btn btn-sm btn-outline-danger"
                                                        title="Delete Assessment">

                                                    <i class="fas fa-trash"></i>

                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="text-center py-5">

                    <div class="empty-icon mb-3">
                        <i class="fas fa-clipboard-list"></i>
                    </div>

                    <h5>No Assessments Found</h5>

                    <p class="text-muted mb-4">
                        No Nursery activity assessments match the selected filters.
                    </p>

                    <a href="{{ route('nursery-assessments.create') }}"
                       class="btn btn-primary">

                        <i class="fas fa-plus-circle me-1"></i>
                        Enter First Assessment

                    </a>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection


@push('styles')

<style>

    .assessment-stars {
        color: #f4b400;
        font-size: 17px;
        letter-spacing: 1px;
        white-space: nowrap;
    }

    .remarks-cell {
        min-width: 180px;
        max-width: 250px;
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f1f5f9;
        color: #64748b;
        font-size: 32px;
    }

    .table thead th {
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        white-space: nowrap;
    }

    .table tbody td {
        vertical-align: middle;
    }

</style>

@endpush


@push('scripts')

<script>

    document.addEventListener('DOMContentLoaded', function () {

        const deleteForms = document.querySelectorAll(
            '.delete-assessment-form'
        );

        deleteForms.forEach(function (form) {

            form.addEventListener('submit', function (event) {

                const confirmed = confirm(
                    'Are you sure you want to delete all activity assessments for this student and exam?'
                );

                if (!confirmed) {
                    event.preventDefault();
                }

            });

        });

    });

</script>

@endpush