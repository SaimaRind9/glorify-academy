<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add Subject
        </h2>
    </x-slot>

    <div class="py-8">

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="page-header">

                <div>
                    <h2>Add New Subject</h2>

                    <p>
                        Create subject for
                        <strong>
                            {{ $teacher->classRoom?->class_name ?? 'Assigned Class' }}
                        </strong>
                    </p>
                </div>

                <a href="{{ route('teacher.subjects.index') }}"
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


            <div class="form-card">

                <div class="card-heading">

                    <div class="heading-icon">
                        <i class="fa-solid fa-book-open"></i>
                    </div>

                    <div>
                        <h3>Subject Information</h3>
                        <p>
                            Enter subject details and marks settings
                        </p>
                    </div>

                </div>


                <form action="{{ route('teacher.subjects.store') }}"
                      method="POST">

                    @csrf


                    <div class="form-grid">


                        <div class="form-group">

                            <label>
                                Subject Name
                            </label>

                            <input type="text"
                                   name="subject_name"
                                   value="{{ old('subject_name') }}"
                                   placeholder="Example: English"
                                   required>

                        </div>


                        <div class="form-group">

                            <label>
                                Course Code
                            </label>

                            <input type="text"
                                   name="subject_code"
                                   value="{{ old('subject_code') }}"
                                   placeholder="Example: ENG101"
                                   required>

                            <small>
                                Course code must be unique.
                            </small>

                        </div>


                        <div class="form-group">

                            <label>
                                Assigned Class
                            </label>

                            <input type="text"
                                   value="{{ $teacher->classRoom?->class_name ?? 'Not Assigned' }}"
                                   readonly>

                            <small>
                                Your class is selected automatically.
                            </small>

                        </div>


                        <div class="form-group">

                            <label>
                                Subject Type
                            </label>

                            <select name="subject_type"
                                    required>

                                <option value="">
                                    Select Type
                                </option>

                                <option value="Theory"
                                    {{ old('subject_type') === 'Theory' ? 'selected' : '' }}>
                                    Theory
                                </option>

                                <option value="Practical"
                                    {{ old('subject_type') === 'Practical' ? 'selected' : '' }}>
                                    Practical
                                </option>

                                <option value="Activity"
                                    {{ old('subject_type') === 'Activity' ? 'selected' : '' }}>
                                    Activity
                                </option>

                            </select>

                        </div>


                        <div class="form-group">

                            <label>
                                Full Marks
                            </label>

                            <input type="number"
                                   name="full_marks"
                                   value="{{ old('full_marks', 100) }}"
                                   min="1"
                                   step="0.01"
                                   required>

                        </div>


                        <div class="form-group">

                            <label>
                                Pass Marks
                            </label>

                            <input type="number"
                                   name="pass_marks"
                                   value="{{ old('pass_marks', 40) }}"
                                   min="0"
                                   step="0.01"
                                   required>

                        </div>


                        <div class="form-group full-width">

                            <label>
                                Description
                            </label>

                            <textarea name="description"
                                      rows="4"
                                      placeholder="Optional subject description">{{ old('description') }}</textarea>

                        </div>


                    </div>


                    <div class="info-box">

                        <i class="fa-solid fa-circle-info"></i>

                        <span>
                            This subject will automatically be assigned to your class after saving.
                        </span>

                    </div>


                    <div class="form-footer">

                        <a href="{{ route('teacher.subjects.index') }}"
                           class="cancel-btn">

                            Cancel

                        </a>


                        <button type="submit"
                                class="save-btn">

                            <i class="fa-solid fa-floppy-disk"></i>
                            Save Subject

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
            transition: .2s ease;
        }

        .back-btn:hover {
            background: #cbd5e1;
            color: #0f172a;
        }

        .error-box {
            margin-bottom: 20px;
            padding: 16px 18px;
            border: 1px solid #fecaca;
            border-radius: 13px;
            background: #fef2f2;
            color: #b91c1c;
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

        .form-card {
            padding: 28px;
            background: #fff;
            border: 1px solid #e8edf4;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(15, 23, 42, .05);
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
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 13px;
            background: #eff6ff;
            color: #2563eb;
            font-size: 20px;
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
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 11px;
            background: #fff;
            color: #0f172a;
            outline: none;
            font-size: 13px;
            transition: .2s ease;
        }

        .form-group input,
        .form-group select {
            height: 46px;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 110px;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
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

        .full-width {
            grid-column: 1 / -1;
        }

        .info-box {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 22px;
            padding: 13px 15px;
            border-radius: 11px;
            background: #eff6ff;
            color: #1d4ed8;
            font-size: 12px;
            line-height: 1.5;
        }

        .form-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 26px;
            padding-top: 20px;
            border-top: 1px solid #eef2f7;
        }

        .cancel-btn,
        .save-btn {
            min-width: 125px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 11px 18px;
            border-radius: 11px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 650;
            transition: .2s ease;
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
            color: #fff;
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

            .full-width {
                grid-column: auto;
            }

            .form-card {
                padding: 22px;
            }

        }

        @media (max-width: 576px) {

            .page-header {
                flex-direction: column;
                align-items: stretch;
            }

            .page-header h2 {
                font-size: 22px;
            }

            .back-btn {
                width: 100%;
            }

            .form-card {
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

            .info-box {
                align-items: flex-start;
            }

        }

    </style>

</x-app-layout>