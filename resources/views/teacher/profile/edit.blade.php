<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Teacher Profile
        </h2>
    </x-slot>

    <div class="py-8">

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="page-header">

                <div>
                    <h2>My Profile</h2>
                    <p>View and update your profile information</p>
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


            <div class="profile-card">

                <div class="profile-top">

                    <div class="profile-photo">

                        @if($teacher->photo)

                            <img
                                src="{{ asset('storage/' . $teacher->photo) }}"
                                alt="{{ $teacher->name }}"
                            >

                        @else

                            <span>
                                {{ strtoupper(substr($teacher->name, 0, 1)) }}
                            </span>

                        @endif

                    </div>


                    <div class="profile-summary">

                        <h3>
                            {{ $teacher->name }}
                        </h3>

                        <p>
                            {{ $teacher->teacher_id }}
                        </p>

                        <span class="status-badge">
                            {{ $teacher->status }}
                        </span>

                    </div>

                </div>


                <form action="{{ route('teacher.profile.update') }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf
                    @method('PUT')


                    <div class="form-grid">


                        <div class="form-group">

                            <label>
                                Teacher ID
                            </label>

                            <input type="text"
                                   value="{{ $teacher->teacher_id }}"
                                   readonly>

                        </div>


                        <div class="form-group">

                            <label>
                                Assigned Class
                            </label>

                            <input type="text"
                                   value="{{ $teacher->classRoom?->class_name ?? 'Not Assigned' }}"
                                   readonly>

                        </div>


                        <div class="form-group">

                            <label>
                                Name
                            </label>

                            <input type="text"
                                   name="name"
                                   value="{{ old('name', $teacher->name) }}"
                                   required>

                        </div>


                        <div class="form-group">

                            <label>
                                Email
                            </label>

                            <input type="email"
                                   name="email"
                                   value="{{ old('email', $teacher->email) }}"
                                   required>

                        </div>


                        <div class="form-group">

                            <label>
                                Phone
                            </label>

                            <input type="text"
                                   name="phone"
                                   value="{{ old('phone', $teacher->phone) }}"
                                   placeholder="Phone number">

                        </div>


                        <div class="form-group">

                            <label>
                                Qualification
                            </label>

                            <input type="text"
                                   name="qualification"
                                   value="{{ old('qualification', $teacher->qualification) }}"
                                   placeholder="Example: M.A English">

                        </div>


                        <div class="form-group">

                            <label>
                                Experience
                            </label>

                            <input type="text"
                                   name="experience"
                                   value="{{ old('experience', $teacher->experience) }}"
                                   placeholder="Example: 5 Years">

                        </div>


                        <div class="form-group">

                            <label>
                                Account Status
                            </label>

                            <input type="text"
                                   value="{{ $teacher->status }}"
                                   readonly>

                        </div>


                        <div class="form-group full-width">

                            <label>
                                Profile Photo
                            </label>

                            <input type="file"
                                   name="photo"
                                   accept=".jpg,.jpeg,.png,.webp">

                            <small>
                                JPG, JPEG, PNG or WEBP. Maximum 2MB.
                            </small>

                        </div>


                    </div>


                    <div class="info-box">

                        <i class="fa-solid fa-circle-info"></i>

                        <span>
                            Teacher ID, assigned class and account status can only be changed by the administrator.
                        </span>

                    </div>


                    <div class="form-footer">

                        <a href="{{ route('dashboard') }}"
                           class="cancel-btn">

                            Cancel

                        </a>


                        <button type="submit"
                                class="save-btn">

                            <i class="fa-solid fa-floppy-disk"></i>
                            Update Profile

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
            transition: .2s;
        }

        .back-btn:hover {
            background: #cbd5e1;
            color: #0f172a;
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

        .profile-card {
            padding: 28px;
            background: #fff;
            border: 1px solid #e8edf4;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(15, 23, 42, .05);
        }

        .profile-top {
            display: flex;
            align-items: center;
            gap: 18px;
            margin-bottom: 28px;
            padding-bottom: 22px;
            border-bottom: 1px solid #eef2f7;
        }

        .profile-photo {
            width: 90px;
            height: 90px;
            flex-shrink: 0;
            overflow: hidden;
            border-radius: 20px;
            background: #dbeafe;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            font-weight: 800;
        }

        .profile-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-summary h3 {
            margin: 0 0 5px;
            color: #0f172a;
            font-size: 21px;
            font-weight: 750;
        }

        .profile-summary p {
            margin: 0 0 8px;
            color: #64748b;
            font-size: 13px;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            background: #dcfce7;
            color: #15803d;
            font-size: 10px;
            font-weight: 700;
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

        .form-group input {
            width: 100%;
            height: 46px;
            padding: 9px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 11px;
            background: #fff;
            color: #0f172a;
            outline: none;
            font-size: 13px;
            transition: .2s;
        }

        .form-group input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .10);
        }

        .form-group input[readonly] {
            background: #f8fafc;
            color: #64748b;
        }

        .form-group input[type="file"] {
            height: auto;
            padding: 10px;
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
            min-width: 130px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 11px 18px;
            border-radius: 11px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 650;
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

            .profile-card {
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

            .profile-card {
                padding: 18px;
                border-radius: 15px;
            }

            .profile-top {
                flex-direction: column;
                text-align: center;
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