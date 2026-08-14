<x-app-layout>

    <x-slot name="header">
        <div class="profile-page-header">

            <div>
                <h2>Parent Profile</h2>
                <p>Manage your account and view linked child information</p>
            </div>

            <a href="{{ route('dashboard') }}" class="back-btn">
                <i class="fa-solid fa-arrow-left"></i>
                Dashboard
            </a>

        </div>
    </x-slot>


    <div class="profile-page">

        <div class="profile-container">

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


            <div class="profile-layout">


                {{-- Parent Account --}}
                <div class="profile-card">

                    <div class="card-heading">

                        <div class="heading-icon parent-icon">
                            <i class="fa-solid fa-user-gear"></i>
                        </div>

                        <div>
                            <span class="section-label">ACCOUNT</span>

                            <h2>Parent Information</h2>

                            <p>
                                Update your login account information
                            </p>
                        </div>

                    </div>


                    <div class="parent-summary">

                        <div class="parent-avatar">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>

                        <div>
                            <h3>{{ $user->name }}</h3>
                            <p>{{ $user->email }}</p>

                            <span class="status-badge">
                                {{ ucfirst($user->status) }}
                            </span>
                        </div>

                    </div>


                    <form
                        method="POST"
                        action="{{ route('parent.profile.update') }}"
                    >

                        @csrf
                        @method('PUT')


                        <div class="form-grid">

                            <div class="form-group">

                                <label>
                                    Parent Name
                                </label>

                                <input
                                    type="text"
                                    name="name"
                                    value="{{ old('name', $user->name) }}"
                                    required
                                >

                            </div>


                            <div class="form-group">

                                <label>
                                    Email Address
                                </label>

                                <input
                                    type="email"
                                    name="email"
                                    value="{{ old('email', $user->email) }}"
                                    required
                                >

                            </div>


                            <div class="form-group">

                                <label>
                                    Account Role
                                </label>

                                <input
                                    type="text"
                                    value="{{ ucfirst($user->role) }}"
                                    readonly
                                >

                            </div>


                            <div class="form-group">

                                <label>
                                    Account Status
                                </label>

                                <input
                                    type="text"
                                    value="{{ ucfirst($user->status) }}"
                                    readonly
                                >

                            </div>

                        </div>


                        <div class="info-box">

                            <i class="fa-solid fa-circle-info"></i>

                            <span>
                                Account role, status and linked child can only
                                be changed by the administrator.
                            </span>

                        </div>


                        <div class="form-footer">

                            <a
                                href="{{ route('dashboard') }}"
                                class="cancel-btn"
                            >
                                Cancel
                            </a>

                            <button
                                type="submit"
                                class="save-btn"
                            >
                                <i class="fa-solid fa-floppy-disk"></i>
                                Update Profile
                            </button>

                        </div>

                    </form>

                </div>



                {{-- Linked Child --}}
                <div class="child-card">

                    <div class="card-heading">

                        <div class="heading-icon child-icon">
                            <i class="fa-solid fa-user-graduate"></i>
                        </div>

                        <div>
                            <span class="section-label">LINKED STUDENT</span>

                            <h2>My Child</h2>

                            <p>
                                Student connected with this parent account
                            </p>
                        </div>

                    </div>


                    @if($student)

                        <div class="child-summary">

                            <div class="child-avatar">

                                @if($student->photo)

                                    <img
                                        src="{{ asset('storage/' . $student->photo) }}"
                                        alt="{{ $student->name }}"
                                    >

                                @else

                                    {{ strtoupper(substr($student->name, 0, 1)) }}

                                @endif

                            </div>


                            <div>

                                <h3>
                                    {{ $student->name }}
                                </h3>

                                <p>
                                    {{ $student->student_id }}
                                    ·
                                    {{ $student->classRoom?->class_name ?? 'No Class' }}
                                </p>

                            </div>

                        </div>


                        <div class="child-details">


                            <div class="detail-row">

                                <span>
                                    <i class="fa-solid fa-user"></i>
                                    Student Name
                                </span>

                                <strong>
                                    {{ $student->name }}
                                </strong>

                            </div>


                            <div class="detail-row">

                                <span>
                                    <i class="fa-regular fa-id-card"></i>
                                    Student ID
                                </span>

                                <strong>
                                    {{ $student->student_id }}
                                </strong>

                            </div>


                            <div class="detail-row">

                                <span>
                                    <i class="fa-solid fa-school"></i>
                                    Class
                                </span>

                                <strong>
                                    {{ $student->classRoom?->class_name ?? 'Not Assigned' }}
                                </strong>

                            </div>


                            <div class="detail-row">

                                <span>
                                    <i class="fa-solid fa-venus-mars"></i>
                                    Gender
                                </span>

                                <strong>
                                    {{ $student->gender ?? 'Not Available' }}
                                </strong>

                            </div>


                            <div class="detail-row">

                                <span>
                                    <i class="fa-solid fa-phone"></i>
                                    Contact
                                </span>

                                <strong>
                                    {{ $student->contact_no
                                        ?? $student->phone
                                        ?? 'Not Available' }}
                                </strong>

                            </div>


                            <div class="detail-row">

                                <span>
                                    <i class="fa-solid fa-location-dot"></i>
                                    Address
                                </span>

                                <strong>
                                    {{ $student->address ?? 'Not Available' }}
                                </strong>

                            </div>


                            <div class="detail-row">

                                <span>
                                    <i class="fa-solid fa-droplet"></i>
                                    Blood Group
                                </span>

                                <strong>
                                    {{ $student->blood_group ?? 'Not Available' }}
                                </strong>

                            </div>

                        </div>


                        <div class="child-actions">

                            <a
                                href="{{ route('parent.results.index') }}"
                                class="child-action-btn result-btn"
                            >
                                <i class="fa-solid fa-chart-column"></i>
                                Results
                            </a>

                            <a
                                href="{{ route('parent.fee-challans.index') }}"
                                class="child-action-btn fee-btn"
                            >
                                <i class="fa-solid fa-file-invoice-dollar"></i>
                                Fee Challans
                            </a>

                        </div>


                    @else

                        <div class="empty-state">

                            <div class="empty-icon">
                                <i class="fa-solid fa-user-xmark"></i>
                            </div>

                            <h3>No Child Linked</h3>

                            <p>
                                This parent account is not currently linked
                                with a student.
                            </p>

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>


    <style>

        :root {
            --profile-bg: #f4f7fb;
            --profile-card: #ffffff;
            --profile-secondary: #f8fafc;
            --profile-text: #0f172a;
            --profile-muted: #64748b;
            --profile-soft: #94a3b8;
            --profile-border: #e2e8f0;
            --profile-primary: #2563eb;
            --profile-shadow:
                0 8px 25px rgba(15, 23, 42, .05);
        }

        html.dark-mode {
            --profile-bg: #090e1a;
            --profile-card: #111827;
            --profile-secondary: #172033;
            --profile-text: #f8fafc;
            --profile-muted: #a7b2c5;
            --profile-soft: #75829a;
            --profile-border: #253047;
            --profile-primary: #60a5fa;
            --profile-shadow:
                0 10px 30px rgba(0, 0, 0, .25);
        }

        body {
            background: var(--profile-bg);
        }

        .profile-page-header {
            width: 100%;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 20px;
        }

        .profile-page-header h2 {
            margin: 0 0 4px;

            color: var(--profile-text);

            font-size: 21px;
            font-weight: 750;
        }

        .profile-page-header p {
            margin: 0;

            color: var(--profile-muted);

            font-size: 12px;
        }

        .back-btn {
            padding: 10px 15px;

            border-radius: 11px;

            background: var(--profile-secondary);
            color: var(--profile-muted);

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 7px;

            text-decoration: none;

            font-size: 12px;
            font-weight: 700;

            transition: transform .25s ease;
        }

        .back-btn:hover {
            transform: translateY(-2px);
        }

        .profile-page {
            min-height: calc(100vh - 70px);

            padding: 30px 20px 50px;

            background:
                radial-gradient(
                    circle at 10% 10%,
                    rgba(37, 99, 235, .05),
                    transparent 28%
                ),
                var(--profile-bg);
        }

        .profile-container {
            width: 100%;
            max-width: 1200px;

            margin: auto;
        }

        .profile-layout {
            display: grid;

            grid-template-columns:
                1.05fr .95fr;

            gap: 22px;
        }

        .profile-card,
        .child-card {
            padding: 25px;

            border: 1px solid var(--profile-border);
            border-radius: 20px;

            background: var(--profile-card);

            box-shadow: var(--profile-shadow);

            transition:
                background .35s ease,
                border-color .35s ease;
        }

        .card-heading {
            margin-bottom: 22px;

            display: flex;
            align-items: center;

            gap: 12px;
        }

        .heading-icon {
            width: 47px;
            height: 47px;

            flex-shrink: 0;

            border-radius: 13px;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 18px;
        }

        .parent-icon {
            color: #2563eb;
            background: #dbeafe;
        }

        .child-icon {
            color: #7c3aed;
            background: #ede9fe;
        }

        html.dark-mode .parent-icon {
            color: #60a5fa;

            background:
                rgba(37,99,235,.16);
        }

        html.dark-mode .child-icon {
            color: #c084fc;

            background:
                rgba(147,51,234,.15);
        }

        .section-label {
            display: block;

            margin-bottom: 2px;

            color: var(--profile-primary);

            font-size: 8px;
            font-weight: 800;

            letter-spacing: 1.2px;
        }

        .card-heading h2 {
            margin: 0 0 3px;

            color: var(--profile-text);

            font-size: 17px;
            font-weight: 750;
        }

        .card-heading p {
            margin: 0;

            color: var(--profile-soft);

            font-size: 10px;
        }

        .success-box {
            margin-bottom: 18px;

            padding: 13px 15px;

            border: 1px solid #a7f3d0;
            border-radius: 11px;

            background: #ecfdf5;
            color: #047857;

            display: flex;
            align-items: center;

            gap: 7px;

            font-size: 11px;
        }

        .error-box {
            margin-bottom: 18px;

            padding: 14px 16px;

            border: 1px solid #fecaca;
            border-radius: 11px;

            background: #fef2f2;
            color: #b91c1c;

            font-size: 11px;
        }

        .error-title {
            margin-bottom: 6px;

            display: flex;
            align-items: center;

            gap: 7px;

            font-weight: 700;
        }

        .error-box ul {
            margin: 0;

            padding-left: 18px;
        }

        html.dark-mode .success-box {
            border-color: rgba(34,197,94,.22);

            background:
                rgba(34,197,94,.10);

            color: #4ade80;
        }

        html.dark-mode .error-box {
            border-color: rgba(239,68,68,.22);

            background:
                rgba(239,68,68,.10);

            color: #f87171;
        }


        /* Parent summary */

        .parent-summary,
        .child-summary {
            margin-bottom: 22px;

            padding: 15px;

            border-radius: 15px;

            background: var(--profile-secondary);

            display: flex;
            align-items: center;

            gap: 12px;
        }

        .parent-avatar,
        .child-avatar {
            width: 55px;
            height: 55px;

            flex-shrink: 0;

            overflow: hidden;

            border-radius: 15px;

            display: flex;
            align-items: center;
            justify-content: center;

            color: white;

            font-size: 19px;
            font-weight: 800;
        }

        .parent-avatar {
            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #60a5fa
                );
        }

        .child-avatar {
            background:
                linear-gradient(
                    135deg,
                    #7c3aed,
                    #a78bfa
                );
        }

        .child-avatar img {
            width: 100%;
            height: 100%;

            object-fit: cover;
        }

        .parent-summary h3,
        .child-summary h3 {
            margin: 0 0 3px;

            color: var(--profile-text);

            font-size: 14px;
            font-weight: 750;
        }

        .parent-summary p,
        .child-summary p {
            margin: 0 0 5px;

            color: var(--profile-muted);

            font-size: 10px;
        }

        .status-badge {
            padding: 4px 8px;

            border-radius: 20px;

            background: #dcfce7;
            color: #15803d;

            font-size: 8px;
            font-weight: 700;
        }

        html.dark-mode .status-badge {
            background:
                rgba(34,197,94,.14);

            color: #4ade80;
        }


        /* Form */

        .form-grid {
            display: grid;

            grid-template-columns:
                repeat(2, minmax(0, 1fr));

            gap: 17px;
        }

        .form-group label {
            display: block;

            margin-bottom: 6px;

            color: var(--profile-muted);

            font-size: 10px;
            font-weight: 700;
        }

        .form-group input {
            width: 100%;
            height: 43px;

            padding: 8px 11px;

            border: 1px solid var(--profile-border);
            border-radius: 10px;

            background: var(--profile-card);
            color: var(--profile-text);

            outline: none;

            font-size: 11px;

            transition:
                border-color .2s ease,
                box-shadow .2s ease;
        }

        .form-group input:focus {
            border-color: #2563eb;

            box-shadow:
                0 0 0 3px rgba(37,99,235,.08);
        }

        .form-group input[readonly] {
            background: var(--profile-secondary);
            color: var(--profile-muted);
        }

        .info-box {
            margin-top: 20px;

            padding: 12px 14px;

            border-radius: 10px;

            background: #eff6ff;
            color: #1d4ed8;

            display: flex;
            align-items: flex-start;

            gap: 7px;

            font-size: 10px;
            line-height: 1.5;
        }

        html.dark-mode .info-box {
            background:
                rgba(37,99,235,.13);

            color: #60a5fa;
        }

        .form-footer {
            margin-top: 22px;

            padding-top: 18px;

            border-top:
                1px solid var(--profile-border);

            display: flex;
            justify-content: flex-end;

            gap: 9px;
        }

        .cancel-btn,
        .save-btn {
            min-width: 125px;

            padding: 10px 16px;

            border-radius: 10px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 6px;

            text-decoration: none;

            font-size: 10px;
            font-weight: 700;

            cursor: pointer;
        }

        .cancel-btn {
            background: var(--profile-secondary);
            color: var(--profile-muted);
        }

        .save-btn {
            border: none;

            background: #2563eb;
            color: white;
        }


        /* Child details */

        .detail-row {
            padding: 12px 0;

            border-bottom:
                1px solid var(--profile-border);

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 15px;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-row span {
            display: flex;
            align-items: center;

            gap: 7px;

            color: var(--profile-muted);

            font-size: 10px;
        }

        .detail-row span i {
            width: 14px;

            color: var(--profile-soft);

            text-align: center;
        }

        .detail-row strong {
            max-width: 58%;

            color: var(--profile-text);

            font-size: 10px;
            font-weight: 650;

            text-align: right;

            word-break: break-word;
        }

        .child-actions {
            margin-top: 20px;

            display: grid;

            grid-template-columns:
                repeat(2, minmax(0, 1fr));

            gap: 9px;
        }

        .child-action-btn {
            padding: 10px;

            border-radius: 10px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 6px;

            text-decoration: none;

            font-size: 9px;
            font-weight: 700;

            transition: transform .25s ease;
        }

        .child-action-btn:hover {
            transform: translateY(-2px);
        }

        .result-btn {
            color: #7c3aed;

            background: #ede9fe;
        }

        .fee-btn {
            color: #c2410c;

            background: #ffedd5;
        }

        html.dark-mode .result-btn {
            color: #c084fc;

            background:
                rgba(147,51,234,.15);
        }

        html.dark-mode .fee-btn {
            color: #fb923c;

            background:
                rgba(249,115,22,.14);
        }


        /* Empty */

        .empty-state {
            padding: 50px 20px;

            text-align: center;
        }

        .empty-icon {
            width: 64px;
            height: 64px;

            margin: 0 auto 12px;

            border-radius: 18px;

            background: var(--profile-secondary);
            color: var(--profile-primary);

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 23px;
        }

        .empty-state h3 {
            margin: 0 0 5px;

            color: var(--profile-text);

            font-size: 15px;
        }

        .empty-state p {
            margin: 0;

            color: var(--profile-muted);

            font-size: 10px;
        }


        /* Responsive */

        @media (max-width: 900px) {

            .profile-layout {
                grid-template-columns: 1fr;
            }

        }

        @media (max-width: 600px) {

            .profile-page {
                padding: 20px 12px 35px;
            }

            .profile-page-header {
                flex-direction: column;
                align-items: stretch;
            }

            .back-btn {
                width: 100%;
            }

            .profile-card,
            .child-card {
                padding: 18px;

                border-radius: 16px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-footer {
                flex-direction: column-reverse;
            }

            .cancel-btn,
            .save-btn {
                width: 100%;
            }

            .detail-row {
                align-items: flex-start;

                flex-direction: column;

                gap: 4px;
            }

            .detail-row strong {
                max-width: 100%;

                text-align: left;
            }

            .child-actions {
                grid-template-columns: 1fr;
            }

        }

    </style>

</x-app-layout>