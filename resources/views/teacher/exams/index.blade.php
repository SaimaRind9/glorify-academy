<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            My Exams
        </h2>
    </x-slot>


    <div class="py-8">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="exam-header">

                <div>

                    <h2>
                        My Exams
                    </h2>

                    <p>
                        Manage exams for
                        <strong>
                            {{ $teacher->classRoom?->class_name ?? 'Assigned Class' }}
                        </strong>
                    </p>

                </div>


                <a href="{{ route('teacher.exams.create') }}"
                   class="add-exam-btn">

                    <i class="fa-solid fa-plus"></i>
                    Add Exam

                </a>

            </div>


            @if(session('success'))

                <div class="success-box">

                    <i class="fa-solid fa-circle-check"></i>

                    {{ session('success') }}

                </div>

            @endif


            <div class="exam-card">

                <div class="exam-card-heading">

                    <div>

                        <h3>
                            Exam List
                        </h3>

                        <p>
                            View and update your created exams
                        </p>

                    </div>

                    <span class="exam-count">

                        {{ $exams->count() }}
                        Exams

                    </span>

                </div>


                <div class="exam-table-wrapper">

                    <table class="exam-table">

                        <thead>

                            <tr>

                                <th>#</th>

                                <th>Exam Name</th>

                                <th>Session</th>

                                <th>Start Date</th>

                                <th>End Date</th>

                                <th>Status</th>

                                <th>Action</th>

                            </tr>

                        </thead>


                        <tbody>

                        @forelse($exams as $exam)

                            <tr>

                                <td data-label="#">
                                    {{ $loop->iteration }}
                                </td>


                                <td data-label="Exam Name">

                                    <div class="exam-name">

                                        <div class="exam-icon">

                                            <i class="fa-solid fa-file-pen"></i>

                                        </div>

                                        <div>

                                            <strong>
                                                {{ $exam->exam_name }}
                                            </strong>

                                            <span>
                                                {{ $teacher->classRoom?->class_name ?? 'Class' }}
                                            </span>

                                        </div>

                                    </div>

                                </td>


                                <td data-label="Session">

                                    {{ $exam->session }}

                                </td>


                                <td data-label="Start Date">

                                    {{ $exam->start_date
                                        ? $exam->start_date->format('d M Y')
                                        : 'N/A'
                                    }}

                                </td>


                                <td data-label="End Date">

                                    {{ $exam->end_date
                                        ? $exam->end_date->format('d M Y')
                                        : 'N/A'
                                    }}

                                </td>


                                <td data-label="Status">

                                    @if($exam->status)

                                        <span class="status-badge active-status">

                                            <i class="fa-solid fa-circle"></i>
                                            Active

                                        </span>

                                    @else

                                        <span class="status-badge inactive-status">

                                            <i class="fa-solid fa-circle"></i>
                                            Inactive

                                        </span>

                                    @endif

                                </td>


                                <td data-label="Action">

                                    <a href="{{ route(
                                            'teacher.exams.edit',
                                            $exam->id
                                        ) }}"
                                       class="edit-btn">

                                        <i class="fa-solid fa-pen-to-square"></i>
                                        Edit

                                    </a>

                                </td>

                            </tr>


                        @empty

                            <tr>

                                <td colspan="7">

                                    <div class="empty-state">

                                        <div class="empty-icon">

                                            <i class="fa-solid fa-file-circle-plus"></i>

                                        </div>

                                        <h3>
                                            No Exams Found
                                        </h3>

                                        <p>
                                            You haven't created any exams yet.
                                        </p>

                                        <a href="{{ route('teacher.exams.create') }}"
                                           class="add-exam-btn">

                                            <i class="fa-solid fa-plus"></i>
                                            Create First Exam

                                        </a>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                        </tbody>

                    </table>

                </div>

            </div>


            <div class="back-area">

                <a href="{{ route('dashboard') }}"
                   class="back-btn">

                    <i class="fa-solid fa-arrow-left"></i>
                    Back to Dashboard

                </a>

            </div>

        </div>

    </div>


    <style>

        body {
            background: #f8fafc;
        }


        .exam-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 24px;
        }


        .exam-header h2 {
            margin: 0 0 5px;
            color: #0f172a;
            font-size: 26px;
            font-weight: 750;
        }


        .exam-header p {
            margin: 0;
            color: #64748b;
            font-size: 14px;
        }


        .add-exam-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 11px 18px;
            background: #2563eb;
            color: white;
            border-radius: 11px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 650;
            transition: 0.2s ease;
            white-space: nowrap;
        }


        .add-exam-btn:hover {
            background: #1d4ed8;
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 8px 18px rgba(37, 99, 235, 0.18);
        }


        .success-box {
            margin-bottom: 20px;
            padding: 14px 17px;
            border-radius: 12px;
            background: #ecfdf5;
            color: #047857;
            border: 1px solid #a7f3d0;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 9px;
        }


        .exam-card {
            background: white;
            border: 1px solid #e8edf4;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(15, 23, 42, 0.05);
            overflow: hidden;
        }


        .exam-card-heading {
            padding: 22px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            border-bottom: 1px solid #eef2f7;
        }


        .exam-card-heading h3 {
            margin: 0 0 4px;
            color: #0f172a;
            font-size: 18px;
            font-weight: 700;
        }


        .exam-card-heading p {
            margin: 0;
            color: #94a3b8;
            font-size: 13px;
        }


        .exam-count {
            padding: 6px 11px;
            border-radius: 20px;
            background: #eff6ff;
            color: #2563eb;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }


        .exam-table-wrapper {
            width: 100%;
            overflow-x: auto;
        }


        .exam-table {
            width: 100%;
            border-collapse: collapse;
        }


        .exam-table thead {
            background: #f8fafc;
        }


        .exam-table th {
            padding: 13px 16px;
            text-align: left;
            color: #64748b;
            font-size: 12px;
            font-weight: 700;
            border-bottom: 1px solid #e8edf4;
            white-space: nowrap;
        }


        .exam-table td {
            padding: 15px 16px;
            color: #334155;
            font-size: 13px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }


        .exam-table tbody tr:hover {
            background: #fafcff;
        }


        .exam-table tbody tr:last-child td {
            border-bottom: none;
        }


        .exam-name {
            display: flex;
            align-items: center;
            gap: 11px;
            min-width: 180px;
        }


        .exam-icon {
            width: 40px;
            height: 40px;
            border-radius: 11px;
            background: #eff6ff;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }


        .exam-name strong,
        .exam-name span {
            display: block;
        }


        .exam-name strong {
            color: #0f172a;
            font-size: 13px;
        }


        .exam-name span {
            margin-top: 3px;
            color: #94a3b8;
            font-size: 11px;
        }


        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 9px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 650;
        }


        .status-badge i {
            font-size: 6px;
        }


        .active-status {
            background: #dcfce7;
            color: #15803d;
        }


        .inactive-status {
            background: #f1f5f9;
            color: #64748b;
        }


        .edit-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 11px;
            background: #fff7ed;
            color: #c2410c;
            border-radius: 9px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 650;
            transition: 0.2s;
        }


        .edit-btn:hover {
            background: #ffedd5;
            color: #9a3412;
        }


        .empty-state {
            padding: 55px 20px;
            text-align: center;
        }


        .empty-icon {
            width: 65px;
            height: 65px;
            margin: 0 auto 15px;
            border-radius: 18px;
            background: #eff6ff;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 27px;
        }


        .empty-state h3 {
            margin: 0 0 7px;
            color: #0f172a;
            font-size: 17px;
            font-weight: 700;
        }


        .empty-state p {
            margin: 0 0 18px;
            color: #94a3b8;
            font-size: 13px;
        }


        .back-area {
            margin-top: 22px;
        }


        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: #475569;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
        }


        .back-btn:hover {
            color: #2563eb;
        }


        /* Tablet */

        @media (max-width: 768px) {

            .exam-header {
                align-items: flex-start;
            }

            .exam-card-heading {
                padding: 18px;
            }

            .exam-table th,
            .exam-table td {
                padding: 12px;
            }
        }


        /* Mobile Responsive Cards */

        @media (max-width: 650px) {

            .exam-header {
                flex-direction: column;
            }

            .add-exam-btn {
                width: 100%;
            }

            .exam-card-heading {
                align-items: flex-start;
            }

            .exam-table-wrapper {
                overflow: visible;
            }

            .exam-table,
            .exam-table tbody,
            .exam-table tr,
            .exam-table td {
                display: block;
                width: 100%;
            }

            .exam-table thead {
                display: none;
            }

            .exam-table tbody {
                padding: 12px;
            }

            .exam-table tbody tr {
                margin-bottom: 14px;
                padding: 7px 0;
                border: 1px solid #e8edf4;
                border-radius: 14px;
                background: white;
                overflow: hidden;
            }

            .exam-table td {
                position: relative;
                padding: 10px 12px 10px 43%;
                border-bottom: 1px solid #f1f5f9;
                min-height: 42px;
            }

            .exam-table td:last-child {
                border-bottom: none;
            }

            .exam-table td::before {
                content: attr(data-label);
                position: absolute;
                left: 12px;
                top: 10px;
                width: 35%;
                color: #64748b;
                font-size: 11px;
                font-weight: 700;
            }

            .exam-name {
                min-width: 0;
            }

            .exam-icon {
                display: none;
            }

            .empty-state {
                padding: 40px 15px;
            }

            .exam-table td[colspan] {
                padding: 0;
            }

            .exam-table td[colspan]::before {
                display: none;
            }

        }

    </style>

</x-app-layout>