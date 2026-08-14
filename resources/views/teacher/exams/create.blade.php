<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Exam
        </h2>
    </x-slot>

    <div class="py-8">

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="exam-header">

                <div>
                    <h2>Add New Exam</h2>

                    <p>
                        Create exam for
                        <strong>
                            {{ $teacher->classRoom?->class_name ?? 'Assigned Class' }}
                        </strong>
                    </p>
                </div>

                <a href="{{ route('teacher.exams.index') }}"
                   class="back-btn">

                    <i class="fa-solid fa-arrow-left"></i>
                    Back

                </a>

            </div>


            @if($errors->any())

                <div class="error-box">

                    <div class="error-title">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        Please fix the following:
                    </div>

                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                </div>

            @endif


            <div class="exam-form-card">

                <div class="card-heading">

                    <div class="heading-icon">
                        <i class="fa-solid fa-file-circle-plus"></i>
                    </div>

                    <div>
                        <h3>Exam Information</h3>
                        <p>Enter the exam details below</p>
                    </div>

                </div>


                <form action="{{ route('teacher.exams.store') }}"
                      method="POST">

                    @csrf


                    <div class="form-grid">


                        <div class="form-group">

                            <label>
                                Exam Name
                            </label>

                            <input type="text"
                                   name="exam_name"
                                   value="{{ old('exam_name') }}"
                                   placeholder="Example: Mid Term Exam"
                                   required>

                        </div>


                        <div class="form-group">

                            <label>
                                Assigned Class
                            </label>

                            <input type="text"
                                   value="{{ $teacher->classRoom?->class_name ?? 'Not Assigned' }}"
                                   readonly>

                            <small>
                                Your assigned class is selected automatically.
                            </small>

                        </div>


                        <div class="form-group">

                            <label>
                                Academic Session
                            </label>

                            <input type="text"
                                   name="session"
                                   value="{{ old('session') }}"
                                   placeholder="Example: 2026-2027"
                                   required>

                        </div>


                        <div class="form-group">

                            <label>
                                Status
                            </label>

                            <select name="status"
                                    required>

                                <option value="1"
                                    {{ old('status', '1') == '1' ? 'selected' : '' }}>

                                    Active

                                </option>

                                <option value="0"
                                    {{ old('status') == '0' ? 'selected' : '' }}>

                                    Inactive

                                </option>

                            </select>

                        </div>


                        <div class="form-group">

                            <label>
                                Start Date
                            </label>

                            <input type="date"
                                   name="start_date"
                                   value="{{ old('start_date') }}"
                                   required>

                        </div>


                        <div class="form-group">

                            <label>
                                End Date
                            </label>

                            <input type="date"
                                   name="end_date"
                                   value="{{ old('end_date') }}"
                                   required>

                        </div>


                    </div>


                    <div class="form-footer">

                        <a href="{{ route('teacher.exams.index') }}"
                           class="cancel-btn">

                            Cancel

                        </a>

                        <button type="submit"
                                class="save-btn">

                            <i class="fa-solid fa-save"></i>
                            Save Exam

                        </button>

                    </div>

                </form>

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

        .error-box {
            margin-bottom: 20px;
            padding: 16px 18px;
            border-radius: 13px;
            background: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
            font-size: 13px;
        }

        .error-title {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
            font-weight: 700;
        }

        .error-box ul {
            margin: 0;
            padding-left: 20px;
        }

        .exam-form-card {
            padding: 28px;
            background: #ffffff;
            border: 1px solid #e8edf4;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(15, 23, 42, 0.06);
        }

        .card-heading {
            display: flex;
            align-items: center;
            gap: 13px;
            margin-bottom: 26px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eef2f7;
        }

        .heading-icon {
            width: 48px;
            height: 48px;
            border-radius: 13px;
            background: #eff6ff;
            color: #2563eb;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 20px;
            flex-shrink: 0;
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

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 7px;
            color: #334155;
            font-size: 13px;
            font-weight: 650;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            height: 46px;
            padding: 9px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 11px;
            background: #ffffff;
            color: #0f172a;
            outline: none;
            font-size: 13px;
            transition: .2s;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .10);
        }

        .form-group input[readonly] {
            background: #f8fafc;
            color: #64748b;
        }

        .form-group small {
            display: block;
            margin-top: 6px;
            color: #94a3b8;
            font-size: 11px;
        }

        .form-footer {
            margin-top: 28px;
            padding-top: 20px;
            border-top: 1px solid #eef2f7;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .cancel-btn,
        .save-btn {
            min-width: 125px;
            padding: 11px 18px;
            border-radius: 11px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 650;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            transition: .2s;
        }

        .cancel-btn {
            background: #f1f5f9;
            color: #475569;
        }

        .cancel-btn:hover {
            background: #e2e8f0;
            color: #0f172a;
        }

        .save-btn {
            border: none;
            background: #2563eb;
            color: #ffffff;
            cursor: pointer;
        }

        .save-btn:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
            box-shadow: 0 8px 18px rgba(37, 99, 235, .16);
        }

        @media (max-width: 768px) {

            .form-grid {
                grid-template-columns: 1fr;
            }

            .exam-form-card {
                padding: 22px;
            }

        }

        @media (max-width: 576px) {

            .exam-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .back-btn {
                width: 100%;
            }

            .exam-header h2 {
                font-size: 22px;
            }

            .exam-form-card {
                padding: 18px;
                border-radius: 15px;
            }

            .form-footer {
                flex-direction: column-reverse;
            }

            .cancel-btn,
            .save-btn {
                width: 100%;
            }

        }

    </style>

</x-app-layout>