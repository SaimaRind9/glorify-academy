<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            My Subjects
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="page-header">
                <div>
                    <h2>My Subjects</h2>
                    <p>
                        Class:
                        <strong>
                            {{ $teacher->classRoom?->class_name ?? 'Assigned Class' }}
                        </strong>
                    </p>
                </div>

                <div class="header-actions">
                    <a href="{{ route('dashboard') }}" class="back-btn">
                        <i class="fa-solid fa-arrow-left"></i>
                        Dashboard
                    </a>

                    <a href="{{ route('teacher.subjects.create') }}"
                       class="add-btn">
                        <i class="fa-solid fa-plus"></i>
                        Add Subject
                    </a>
                </div>
            </div>


            @if(session('success'))
                <div class="success-box">
                    <i class="fa-solid fa-circle-check"></i>
                    {{ session('success') }}
                </div>
            @endif


            <div class="subjects-card">

                <div class="card-heading">
                    <div>
                        <h3>Subject List</h3>
                        <p>
                            Subjects created for your assigned class
                        </p>
                    </div>

                    <span class="subject-count">
                        {{ $classSubjects->count() }}
                        {{ $classSubjects->count() === 1 ? 'Subject' : 'Subjects' }}
                    </span>
                </div>


                @if($classSubjects->count())

                    <div class="table-wrapper">

                        <table class="subjects-table">

                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Subject</th>
                                    <th>Course Code</th>
                                    <th>Type</th>
                                    <th>Full Marks</th>
                                    <th>Pass Marks</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach($classSubjects as $classSubject)

                                    <tr>

                                        <td data-label="#">
                                            {{ $loop->iteration }}
                                        </td>

                                        <td data-label="Subject">
                                            <div class="subject-info">

                                                <div class="subject-icon">
                                                    <i class="fa-solid fa-book-open"></i>
                                                </div>

                                                <div>
                                                    <strong>
                                                        {{ $classSubject->subject?->subject_name ?? 'N/A' }}
                                                    </strong>

                                                    @if($classSubject->subject?->description)
                                                        <span>
                                                            {{ \Illuminate\Support\Str::limit(
                                                                $classSubject->subject->description,
                                                                45
                                                            ) }}
                                                        </span>
                                                    @endif
                                                </div>

                                            </div>
                                        </td>

                                        <td data-label="Course Code">
                                            <span class="code-badge">
                                                {{ $classSubject->subject?->subject_code ?? 'N/A' }}
                                            </span>
                                        </td>

                                        <td data-label="Type">
                                            {{ $classSubject->subject_type ?? 'N/A' }}
                                        </td>

                                        <td data-label="Full Marks">
                                            <strong>
                                                {{ $classSubject->full_marks }}
                                            </strong>
                                        </td>

                                        <td data-label="Pass Marks">
                                            {{ $classSubject->pass_marks }}
                                        </td>

                                        <td data-label="Status">

                                            @if(
                                                $classSubject->status &&
                                                $classSubject->subject?->status
                                            )
                                                <span class="status-badge active-status">
                                                    Active
                                                </span>
                                            @else
                                                <span class="status-badge inactive-status">
                                                    Inactive
                                                </span>
                                            @endif

                                        </td>

                                        <td data-label="Action">

                                            <a
                                                href="{{ route(
                                                    'teacher.subjects.edit',
                                                    $classSubject->subject_id
                                                ) }}"
                                                class="edit-btn"
                                            >
                                                <i class="fa-solid fa-pen-to-square"></i>
                                                Edit
                                            </a>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @else

                    <div class="empty-state">

                        <div class="empty-icon">
                            <i class="fa-solid fa-book"></i>
                        </div>

                        <h3>No Subjects Added Yet</h3>

                        <p>
                            Create the first subject for your assigned class.
                        </p>

                        <a href="{{ route('teacher.subjects.create') }}"
                           class="empty-add-btn">
                            <i class="fa-solid fa-plus"></i>
                            Add First Subject
                        </a>

                    </div>

                @endif

            </div>

        </div>
    </div>


    <style>

        body {
            background: #f8fafc;
        }

        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 24px;
        }

        .page-header h2 {
            margin: 0 0 5px;
            color: #0f172a;
            font-size: 26px;
            font-weight: 750;
        }

        .page-header p {
            margin: 0;
            color: #64748b;
            font-size: 14px;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .back-btn,
        .add-btn,
        .empty-add-btn,
        .edit-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            text-decoration: none;
            font-weight: 650;
            transition: .2s ease;
        }

        .back-btn {
            padding: 10px 15px;
            border-radius: 11px;
            background: #e2e8f0;
            color: #334155;
            font-size: 12px;
        }

        .back-btn:hover {
            background: #cbd5e1;
            color: #0f172a;
        }

        .add-btn,
        .empty-add-btn {
            padding: 10px 16px;
            border-radius: 11px;
            background: #2563eb;
            color: #fff;
            font-size: 12px;
        }

        .add-btn:hover,
        .empty-add-btn:hover {
            background: #1d4ed8;
            color: #fff;
            transform: translateY(-1px);
        }

        .success-box {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
            padding: 14px 17px;
            border: 1px solid #a7f3d0;
            border-radius: 12px;
            background: #ecfdf5;
            color: #047857;
            font-size: 13px;
        }

        .subjects-card {
            overflow: hidden;
            background: #fff;
            border: 1px solid #e8edf4;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(15, 23, 42, .05);
        }

        .card-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            padding: 22px 24px;
            border-bottom: 1px solid #eef2f7;
        }

        .card-heading h3 {
            margin: 0 0 4px;
            color: #0f172a;
            font-size: 18px;
            font-weight: 700;
        }

        .card-heading p {
            margin: 0;
            color: #94a3b8;
            font-size: 12px;
        }

        .subject-count {
            padding: 6px 11px;
            border-radius: 20px;
            background: #eff6ff;
            color: #2563eb;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        .subjects-table {
            width: 100%;
            border-collapse: collapse;
        }

        .subjects-table thead {
            background: #f8fafc;
        }

        .subjects-table th {
            padding: 13px 14px;
            border-bottom: 1px solid #e8edf4;
            color: #64748b;
            text-align: left;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        .subjects-table td {
            padding: 14px;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
            font-size: 12px;
            vertical-align: middle;
        }

        .subjects-table tbody tr:last-child td {
            border-bottom: none;
        }

        .subjects-table tbody tr:hover {
            background: #fafcff;
        }

        .subject-info {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 190px;
        }

        .subject-icon {
            width: 40px;
            height: 40px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 11px;
            background: #eff6ff;
            color: #2563eb;
            font-size: 15px;
        }

        .subject-info strong,
        .subject-info span {
            display: block;
        }

        .subject-info strong {
            color: #0f172a;
            font-size: 12px;
        }

        .subject-info span {
            max-width: 220px;
            margin-top: 3px;
            color: #94a3b8;
            font-size: 10px;
        }

        .code-badge {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 8px;
            background: #f3e8ff;
            color: #7e22ce;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .3px;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
        }

        .active-status {
            background: #dcfce7;
            color: #15803d;
        }

        .inactive-status {
            background: #fee2e2;
            color: #b91c1c;
        }

        .edit-btn {
            padding: 7px 11px;
            border-radius: 9px;
            background: #fff7ed;
            color: #c2410c;
            font-size: 11px;
            white-space: nowrap;
        }

        .edit-btn:hover {
            background: #ffedd5;
            color: #9a3412;
        }

        .empty-state {
            padding: 65px 20px;
            text-align: center;
        }

        .empty-icon {
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            border-radius: 20px;
            background: #eff6ff;
            color: #2563eb;
            font-size: 27px;
        }

        .empty-state h3 {
            margin: 0 0 7px;
            color: #0f172a;
            font-size: 18px;
            font-weight: 700;
        }

        .empty-state p {
            margin: 0 0 18px;
            color: #94a3b8;
            font-size: 12px;
        }


        @media (max-width: 650px) {

            .page-header {
                flex-direction: column;
                align-items: stretch;
            }

            .page-header h2 {
                font-size: 22px;
            }

            .header-actions {
                width: 100%;
            }

            .back-btn,
            .add-btn {
                flex: 1;
            }

            .card-heading {
                padding: 18px;
            }

            .table-wrapper {
                padding: 12px;
                overflow: visible;
            }

            .subjects-table,
            .subjects-table tbody,
            .subjects-table tr,
            .subjects-table td {
                display: block;
                width: 100%;
            }

            .subjects-table thead {
                display: none;
            }

            .subjects-table tr {
                margin-bottom: 14px;
                overflow: hidden;
                border: 1px solid #e8edf4;
                border-radius: 14px;
                background: #fff;
            }

            .subjects-table tr:last-child {
                margin-bottom: 0;
            }

            .subjects-table td {
                position: relative;
                min-height: 42px;
                padding: 10px 12px 10px 42%;
            }

            .subjects-table td::before {
                content: attr(data-label);
                position: absolute;
                top: 11px;
                left: 12px;
                width: 34%;
                color: #64748b;
                font-size: 10px;
                font-weight: 700;
            }

            .subject-info {
                min-width: 0;
            }

            .subject-icon {
                display: none;
            }

            .subject-info span {
                max-width: none;
            }

            .edit-btn {
                width: 100%;
            }

        }

    </style>

</x-app-layout>