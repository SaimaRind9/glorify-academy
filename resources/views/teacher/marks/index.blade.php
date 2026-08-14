<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Teacher Marks
        </h2>
    </x-slot>

    <div class="py-8">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="marks-header">

                <div>
                    <h2>Enter Student Marks</h2>

                    <p>
                        Class:
                        <strong>
                            {{ $teacher->classRoom?->class_name ?? 'Assigned Class' }}
                        </strong>
                    </p>
                </div>

                <a href="{{ route('dashboard') }}"
                   class="back-btn">

                    <i class="fa-solid fa-arrow-left"></i>
                    Back to Dashboard

                </a>

            </div>


            @if(session('success'))

                <div class="success-box">

                    <i class="fa-solid fa-circle-check"></i>

                    {{ session('success') }}

                </div>

            @endif


            @if(session('error'))

                <div class="error-box">

                    <i class="fa-solid fa-circle-exclamation"></i>

                    {{ session('error') }}

                </div>

            @endif


            @if($errors->any())

                <div class="error-box">

                    <div>

                        <strong>
                            Please fix the following:
                        </strong>

                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>

                    </div>

                </div>

            @endif


            {{-- Filters --}}

            <div class="filter-card">

                <div class="section-heading">

                    <div class="heading-icon">
                        <i class="fa-solid fa-filter"></i>
                    </div>

                    <div>
                        <h3>Select Exam & Subject</h3>
                        <p>Load students for marks entry</p>
                    </div>

                </div>


                <form method="GET"
                      action="{{ route('teacher.marks.index') }}">

                    <div class="filter-grid">

                        <div class="form-group">

                            <label>
                                Exam
                            </label>

                            <select name="exam_id"
                                    required>

                                <option value="">
                                    Select Exam
                                </option>

                                @foreach($exams as $exam)

                                    <option value="{{ $exam->id }}"
                                        {{ request('exam_id') == $exam->id ? 'selected' : '' }}>

                                        {{ $exam->exam_name }}
                                        - {{ $exam->session }}

                                    </option>

                                @endforeach

                            </select>

                        </div>


                        <div class="form-group">

                            <label>
                                Subject
                            </label>

                            <select name="class_subject_id"
                                    required>

                                <option value="">
                                    Select Subject
                                </option>

                                @foreach($classSubjects as $classSubject)

                                    <option value="{{ $classSubject->id }}"
                                        {{ request('class_subject_id') == $classSubject->id ? 'selected' : '' }}>

                                        {{ $classSubject->subject?->subject_name ?? 'Subject' }}

                                        @if($classSubject->subject_type)
                                            - {{ $classSubject->subject_type }}
                                        @endif

                                    </option>

                                @endforeach

                            </select>

                        </div>


                        <div class="filter-button-wrap">

                            <button type="submit"
                                    class="load-btn">

                                <i class="fa-solid fa-users"></i>
                                Load Students

                            </button>

                        </div>

                    </div>

                </form>

            </div>


            @if($selectedExam && $selectedClassSubject)

                {{-- Summary --}}

                <div class="summary-grid">

                    <div class="summary-card">

                        <span>Exam</span>

                        <strong>
                            {{ $selectedExam->exam_name }}
                        </strong>

                    </div>


                    <div class="summary-card">

                        <span>Subject</span>

                        <strong>
                            {{ $selectedClassSubject->subject?->subject_name ?? 'N/A' }}
                        </strong>

                    </div>


                    <div class="summary-card">

                        <span>Full Marks</span>

                        <strong>
                            {{ $selectedClassSubject->full_marks }}
                        </strong>

                    </div>


                    <div class="summary-card">

                        <span>Pass Marks</span>

                        <strong>
                            {{ $selectedClassSubject->pass_marks }}
                        </strong>

                    </div>

                </div>


                {{-- Marks Form --}}

                <div class="marks-card">

                    <div class="marks-card-heading">

                        <div>
                            <h3>Student Marks</h3>

                            <p>
                                Enter marks, mark absent students and add remarks
                            </p>
                        </div>

                        <span class="student-count">
                            {{ $students->count() }} Students
                        </span>

                    </div>


                    <form action="{{ route('teacher.marks.store') }}"
                          method="POST">

                        @csrf

                        <input type="hidden"
                               name="exam_id"
                               value="{{ $selectedExam->id }}">

                        <input type="hidden"
                               name="class_subject_id"
                               value="{{ $selectedClassSubject->id }}">


                        <div class="marks-table-wrapper">

                            <table class="marks-table">

                                <thead>

                                    <tr>
                                        <th>#</th>
                                        <th>Student</th>
                                        <th>Student ID</th>
                                        <th>Marks</th>
                                        <th>Absent</th>
                                        <th>Remarks</th>
                                        <th>Previous Result</th>
                                    </tr>

                                </thead>


                                <tbody>

                                @forelse($students as $student)

                                    @php
                                        $existing = $existingMarks->get($student->id);
                                    @endphp

                                    <tr>

                                        <td data-label="#">
                                            {{ $loop->iteration }}
                                        </td>


                                        <td data-label="Student">

                                            <div class="student-box">

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


                                                <div>

                                                    <strong>
                                                        {{ $student->name }}
                                                    </strong>

                                                    <span>
                                                        {{ $student->gender ?? '' }}
                                                    </span>

                                                </div>

                                            </div>

                                        </td>


                                        <td data-label="Student ID">

                                            {{ $student->student_id }}

                                        </td>


                                        <td data-label="Marks">

                                            <input type="number"
                                                   name="marks[{{ $student->id }}]"
                                                   class="marks-input"
                                                   min="0"
                                                   max="{{ $selectedClassSubject->full_marks }}"
                                                   step="0.01"
                                                   value="{{ old(
                                                       'marks.' . $student->id,
                                                       $existing?->obtained_marks
                                                   ) }}"
                                                   placeholder="0">

                                        </td>


                                        <td data-label="Absent">

                                            <label class="absent-check">

                                                <input type="checkbox"
                                                       name="absent[{{ $student->id }}]"
                                                       value="1"
                                                       {{ old(
                                                           'absent.' . $student->id,
                                                           $existing?->is_absent
                                                       ) ? 'checked' : '' }}>

                                                <span>
                                                    Absent
                                                </span>

                                            </label>

                                        </td>


                                        <td data-label="Remarks">

                                            <input type="text"
                                                   name="remarks[{{ $student->id }}]"
                                                   class="remarks-input"
                                                   value="{{ old(
                                                       'remarks.' . $student->id,
                                                       $existing?->remarks
                                                   ) }}"
                                                   placeholder="Optional">

                                        </td>


                                        <td data-label="Previous Result">

                                            @if($existing)

                                                @if($existing->is_absent)

                                                    <span class="result-badge absent-result">
                                                        Absent
                                                    </span>

                                                @elseif($existing->result_status === 'Pass')

                                                    <span class="result-badge pass-result">
                                                        Pass
                                                    </span>

                                                @elseif($existing->result_status === 'Fail')

                                                    <span class="result-badge fail-result">
                                                        Fail
                                                    </span>

                                                @else

                                                    <span class="result-badge pending-result">
                                                        Pending
                                                    </span>

                                                @endif

                                                @if($existing->grade)

                                                    <div class="grade-text">
                                                        Grade: {{ $existing->grade }}
                                                    </div>

                                                @endif

                                            @else

                                                <span class="text-muted-small">
                                                    Not entered
                                                </span>

                                            @endif

                                        </td>

                                    </tr>


                                @empty

                                    <tr>

                                        <td colspan="7">

                                            <div class="empty-state">

                                                <i class="fa-solid fa-user-graduate"></i>

                                                <h3>No Students Found</h3>

                                                <p>
                                                    No students are available in your assigned class.
                                                </p>

                                            </div>

                                        </td>

                                    </tr>

                                @endforelse

                                </tbody>

                            </table>

                        </div>


                        @if($students->count())

                            <div class="save-area">

                                <div class="save-note">

                                    <i class="fa-solid fa-circle-info"></i>

                                    Grades and Pass/Fail status will calculate automatically.

                                </div>


                                <button type="submit"
                                        class="save-btn">

                                    <i class="fa-solid fa-floppy-disk"></i>
                                    Save Marks

                                </button>

                            </div>

                        @endif

                    </form>

                </div>


            @else

                <div class="welcome-state">

                    <div class="welcome-icon">

                        <i class="fa-solid fa-clipboard-list"></i>

                    </div>

                    <h3>
                        Ready for Marks Entry
                    </h3>

                    <p>
                        Select an exam and subject above to load your class students.
                    </p>

                </div>

            @endif

        </div>

    </div>


    <style>

        body {
            background: #f8fafc;
        }


        .marks-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 24px;
        }


        .marks-header h2 {
            margin: 0 0 5px;
            color: #0f172a;
            font-size: 26px;
            font-weight: 750;
        }


        .marks-header p {
            margin: 0;
            color: #64748b;
            font-size: 14px;
        }


        .back-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 10px 16px;
            border-radius: 11px;
            background: #e2e8f0;
            color: #334155;
            text-decoration: none;
            font-size: 13px;
            font-weight: 650;
            transition: .2s;
        }


        .back-btn:hover {
            background: #cbd5e1;
            color: #0f172a;
        }


        .success-box,
        .error-box {
            margin-bottom: 20px;
            padding: 14px 17px;
            border-radius: 12px;
            display: flex;
            gap: 9px;
            align-items: flex-start;
            font-size: 13px;
        }


        .success-box {
            background: #ecfdf5;
            color: #047857;
            border: 1px solid #a7f3d0;
        }


        .error-box {
            background: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }


        .error-box ul {
            margin: 7px 0 0;
            padding-left: 20px;
        }


        .filter-card,
        .marks-card,
        .welcome-state,
        .summary-card {
            background: #ffffff;
            border: 1px solid #e8edf4;
            box-shadow: 0 8px 25px rgba(15, 23, 42, .05);
        }


        .filter-card {
            padding: 24px;
            border-radius: 20px;
            margin-bottom: 20px;
        }


        .section-heading {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 21px;
        }


        .heading-icon {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            background: #eff6ff;
            color: #2563eb;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 18px;
        }


        .section-heading h3 {
            margin: 0 0 3px;
            color: #0f172a;
            font-size: 17px;
            font-weight: 700;
        }


        .section-heading p {
            margin: 0;
            color: #94a3b8;
            font-size: 12px;
        }


        .filter-grid {
            display: grid;
            grid-template-columns: 1fr 1fr auto;
            gap: 18px;
            align-items: end;
        }


        .form-group label {
            display: block;
            margin-bottom: 7px;
            color: #334155;
            font-size: 13px;
            font-weight: 650;
        }


        .form-group select {
            width: 100%;
            height: 45px;
            padding: 8px 11px;
            border: 1px solid #cbd5e1;
            border-radius: 11px;
            background: #fff;
            color: #0f172a;
            outline: none;
            font-size: 13px;
        }


        .form-group select:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .10);
        }


        .load-btn,
        .save-btn {
            border: none;
            border-radius: 11px;
            background: #2563eb;
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 13px;
            font-weight: 650;
            cursor: pointer;
            transition: .2s;
        }


        .load-btn {
            height: 45px;
            padding: 0 18px;
        }


        .save-btn {
            padding: 11px 21px;
        }


        .load-btn:hover,
        .save-btn:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
        }


        .summary-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }


        .summary-card {
            padding: 18px;
            border-radius: 16px;
        }


        .summary-card span,
        .summary-card strong {
            display: block;
        }


        .summary-card span {
            margin-bottom: 5px;
            color: #94a3b8;
            font-size: 11px;
        }


        .summary-card strong {
            color: #0f172a;
            font-size: 15px;
        }


        .marks-card {
            border-radius: 20px;
            overflow: hidden;
        }


        .marks-card-heading {
            padding: 22px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            border-bottom: 1px solid #eef2f7;
        }


        .marks-card-heading h3 {
            margin: 0 0 4px;
            color: #0f172a;
            font-size: 18px;
            font-weight: 700;
        }


        .marks-card-heading p {
            margin: 0;
            color: #94a3b8;
            font-size: 12px;
        }


        .student-count {
            padding: 6px 11px;
            border-radius: 20px;
            background: #eff6ff;
            color: #2563eb;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }


        .marks-table-wrapper {
            width: 100%;
            overflow-x: auto;
        }


        .marks-table {
            width: 100%;
            border-collapse: collapse;
        }


        .marks-table thead {
            background: #f8fafc;
        }


        .marks-table th {
            padding: 13px 14px;
            text-align: left;
            color: #64748b;
            font-size: 11px;
            font-weight: 700;
            border-bottom: 1px solid #e8edf4;
            white-space: nowrap;
        }


        .marks-table td {
            padding: 13px 14px;
            color: #334155;
            font-size: 12px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }


        .marks-table tbody tr:hover {
            background: #fafcff;
        }


        .student-box {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 160px;
        }


        .student-avatar {
            width: 39px;
            height: 39px;
            border-radius: 11px;
            overflow: hidden;
            background: #dbeafe;
            color: #2563eb;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: 700;
            flex-shrink: 0;
        }


        .student-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }


        .student-box strong,
        .student-box span {
            display: block;
        }


        .student-box strong {
            color: #0f172a;
            font-size: 12px;
        }


        .student-box span {
            margin-top: 2px;
            color: #94a3b8;
            font-size: 10px;
        }


        .marks-input,
        .remarks-input {
            border: 1px solid #cbd5e1;
            border-radius: 9px;
            outline: none;
            font-size: 12px;
            padding: 7px 9px;
        }


        .marks-input {
            width: 90px;
        }


        .remarks-input {
            width: 150px;
        }


        .marks-input:focus,
        .remarks-input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 2px rgba(37, 99, 235, .08);
        }


        .absent-check {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #475569;
            font-size: 11px;
            cursor: pointer;
        }


        .absent-check input {
            width: 16px;
            height: 16px;
        }


        .result-badge {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
        }


        .pass-result {
            background: #dcfce7;
            color: #15803d;
        }


        .fail-result {
            background: #fee2e2;
            color: #b91c1c;
        }


        .absent-result {
            background: #ffedd5;
            color: #c2410c;
        }


        .pending-result {
            background: #f1f5f9;
            color: #64748b;
        }


        .grade-text {
            margin-top: 4px;
            color: #64748b;
            font-size: 10px;
        }


        .text-muted-small {
            color: #94a3b8;
            font-size: 11px;
        }


        .save-area {
            padding: 20px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            border-top: 1px solid #eef2f7;
            background: #fafcff;
        }


        .save-note {
            color: #64748b;
            font-size: 11px;
            display: flex;
            align-items: center;
            gap: 7px;
        }


        .welcome-state,
        .empty-state {
            text-align: center;
        }


        .welcome-state {
            padding: 60px 20px;
            border-radius: 20px;
        }


        .welcome-icon {
            width: 68px;
            height: 68px;
            margin: 0 auto 15px;
            border-radius: 19px;
            background: #eff6ff;
            color: #2563eb;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 28px;
        }


        .welcome-state h3,
        .empty-state h3 {
            margin: 0 0 7px;
            color: #0f172a;
            font-size: 17px;
            font-weight: 700;
        }


        .welcome-state p,
        .empty-state p {
            margin: 0;
            color: #94a3b8;
            font-size: 12px;
        }


        .empty-state {
            padding: 45px 20px;
        }


        .empty-state i {
            margin-bottom: 12px;
            color: #94a3b8;
            font-size: 30px;
        }


        @media (max-width: 900px) {

            .filter-grid {
                grid-template-columns: 1fr 1fr;
            }

            .filter-button-wrap {
                grid-column: 1 / -1;
            }

            .load-btn {
                width: 100%;
            }

            .summary-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

        }


        @media (max-width: 650px) {

            .marks-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .back-btn {
                width: 100%;
            }

            .marks-header h2 {
                font-size: 22px;
            }

            .filter-card {
                padding: 18px;
            }

            .filter-grid {
                grid-template-columns: 1fr;
            }

            .filter-button-wrap {
                grid-column: auto;
            }

            .summary-grid {
                grid-template-columns: 1fr 1fr;
            }

            .marks-card-heading {
                align-items: flex-start;
                padding: 18px;
            }

            .marks-table-wrapper {
                overflow: visible;
            }

            .marks-table,
            .marks-table tbody,
            .marks-table tr,
            .marks-table td {
                display: block;
                width: 100%;
            }

            .marks-table thead {
                display: none;
            }

            .marks-table tbody {
                padding: 12px;
            }

            .marks-table tbody tr {
                margin-bottom: 14px;
                padding: 7px 0;
                border: 1px solid #e8edf4;
                border-radius: 14px;
                background: white;
                overflow: hidden;
            }

            .marks-table td {
                position: relative;
                padding: 10px 12px 10px 42%;
                min-height: 42px;
            }

            .marks-table td::before {
                content: attr(data-label);
                position: absolute;
                left: 12px;
                top: 11px;
                width: 34%;
                color: #64748b;
                font-size: 10px;
                font-weight: 700;
            }

            .student-box {
                min-width: 0;
            }

            .student-avatar {
                display: none;
            }

            .marks-input,
            .remarks-input {
                width: 100%;
            }

            .save-area {
                flex-direction: column;
                align-items: stretch;
                padding: 18px;
            }

            .save-btn {
                width: 100%;
            }

            .save-note {
                line-height: 1.5;
            }

            .marks-table td[colspan] {
                padding: 0;
            }

            .marks-table td[colspan]::before {
                display: none;
            }

        }


        @media (max-width: 420px) {

            .summary-grid {
                grid-template-columns: 1fr;
            }

        }

    </style>

</x-app-layout>