<x-app-layout>

    <x-slot name="header">
        <div class="fee-page-header">
            <div>
                <h2>Fee Challans</h2>
                <p>View your child’s fee challans and payment status</p>
            </div>

            <a href="{{ route('dashboard') }}" class="back-btn">
                <i class="fa-solid fa-arrow-left"></i>
                Dashboard
            </a>
        </div>
    </x-slot>


    <div class="fee-page">
        <div class="fee-container">

            {{-- Student --}}
            <div class="student-card">
                <div class="student-avatar">
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
                    <span class="student-label">STUDENT</span>

                    <h3>{{ $student->name }}</h3>

                    <p>
                        {{ $student->student_id }}
                        ·
                        {{ $student->classRoom?->class_name ?? 'No Class' }}
                    </p>
                </div>
            </div>


            {{-- Summary --}}
            <div class="summary-grid">

                <div class="summary-card">
                    <div class="summary-icon total-icon">
                        <i class="fa-solid fa-file-invoice"></i>
                    </div>

                    <div>
                        <span>Total Challans</span>
                        <strong>{{ $totalChallans }}</strong>
                        <small>Generated challans</small>
                    </div>
                </div>


                <div class="summary-card">
                    <div class="summary-icon amount-icon">
                        <i class="fa-solid fa-money-bill-wave"></i>
                    </div>

                    <div>
                        <span>Total Amount</span>
                        <strong>
                            Rs. {{ number_format($totalAmount, 2) }}
                        </strong>
                        <small>Total payable amount</small>
                    </div>
                </div>


                <div class="summary-card">
                    <div class="summary-icon paid-icon">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>

                    <div>
                        <span>Paid Amount</span>
                        <strong>
                            Rs. {{ number_format($paidAmount, 2) }}
                        </strong>
                        <small>Payment received</small>
                    </div>
                </div>


                <div class="summary-card">
                    <div class="summary-icon pending-icon">
                        <i class="fa-solid fa-clock"></i>
                    </div>

                    <div>
                        <span>Pending Amount</span>
                        <strong>
                            Rs. {{ number_format($pendingAmount, 2) }}
                        </strong>
                        <small>Remaining balance</small>
                    </div>
                </div>

            </div>


            {{-- Main Card --}}
            <div class="challan-card">

                <div class="card-heading">
                    <div>
                        <span class="section-label">FEES</span>
                        <h2>Fee Challan History</h2>
                        <p>View challans, due dates and payment information.</p>
                    </div>

                    <span class="record-count">
                        <i class="fa-solid fa-file-invoice-dollar"></i>
                        {{ $challans->total() }} Records
                    </span>
                </div>


                {{-- Filters --}}
                <form
                    method="GET"
                    action="{{ route('parent.fee-challans.index') }}"
                    class="filter-form"
                >

                    <div class="filter-group">
                        <label for="status">Status</label>

                        <select name="status" id="status">
                            <option value="">All Statuses</option>

                            @foreach(['Paid', 'Partial', 'Unpaid', 'Overdue'] as $status)
                                <option
                                    value="{{ $status }}"
                                    {{ request('status') === $status ? 'selected' : '' }}
                                >
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="filter-group">
                        <label for="year">Year</label>

                        <select name="year" id="year">
                            <option value="">All Years</option>

                            @foreach($years as $year)
                                <option
                                    value="{{ $year }}"
                                    {{ (string) request('year') === (string) $year ? 'selected' : '' }}
                                >
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="filter-actions">
                        <button type="submit" class="filter-btn">
                            <i class="fa-solid fa-filter"></i>
                            Filter
                        </button>

                        <a
                            href="{{ route('parent.fee-challans.index') }}"
                            class="reset-btn"
                        >
                            <i class="fa-solid fa-rotate-left"></i>
                            Reset
                        </a>
                    </div>

                </form>


                @if($challans->count())

                    <div class="challan-list">

                        @foreach($challans as $challan)

                            @php
                                $remaining = max(
                                    0,
                                    (float) $challan->total_amount -
                                    (float) $challan->paid_amount
                                );

                                $status = strtolower(
                                    (string) $challan->status
                                );
                            @endphp


                            <div class="challan-item">

                                <div class="challan-icon">
                                    <i class="fa-solid fa-file-invoice-dollar"></i>
                                </div>


                                <div class="challan-info">

                                    <div class="challan-title-row">

                                        <div>
                                            <span class="challan-number">
                                                {{ $challan->challan_no }}
                                            </span>

                                            <h3>
                                                {{ $challan->month }}
                                                {{ $challan->year }}
                                            </h3>
                                        </div>


                                        <span class="status-badge status-{{ $status }}">
                                            {{ $challan->status }}
                                        </span>

                                    </div>


                                    <div class="challan-details">

                                        <div>
                                            <span>Session</span>
                                            <strong>
                                                {{ $challan->academicSession?->session_name
                                                    ?? $challan->academicSession?->name
                                                    ?? 'N/A' }}
                                            </strong>
                                        </div>


                                        <div>
                                            <span>Issue Date</span>
                                            <strong>
                                                {{ $challan->issue_date?->format('d M Y') ?? 'N/A' }}
                                            </strong>
                                        </div>


                                        <div>
                                            <span>Due Date</span>
                                            <strong>
                                                {{ $challan->due_date?->format('d M Y') ?? 'N/A' }}
                                            </strong>
                                        </div>


                                        <div>
                                            <span>Total</span>
                                            <strong>
                                                Rs. {{ number_format((float) $challan->total_amount, 2) }}
                                            </strong>
                                        </div>


                                        <div>
                                            <span>Paid</span>
                                            <strong class="paid-text">
                                                Rs. {{ number_format((float) $challan->paid_amount, 2) }}
                                            </strong>
                                        </div>


                                        <div>
                                            <span>Balance</span>
                                            <strong class="{{ $remaining > 0 ? 'pending-text' : 'paid-text' }}">
                                                Rs. {{ number_format($remaining, 2) }}
                                            </strong>
                                        </div>

                                    </div>

                                </div>


                                <a
                                    href="{{ route(
                                        'parent.fee-challans.show',
                                        $challan
                                    ) }}"
                                    class="view-btn"
                                >
                                    <span>View</span>
                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>

                            </div>

                        @endforeach

                    </div>


                    <div class="pagination-wrapper">
                        {{ $challans->links() }}
                    </div>

                @else

                    <div class="empty-state">

                        <div class="empty-icon">
                            <i class="fa-solid fa-file-circle-xmark"></i>
                        </div>

                        <h3>No Fee Challans Found</h3>

                        <p>
                            There are no fee challans matching the selected
                            filters.
                        </p>

                        @if(request()->hasAny(['status', 'year']))
                            <a
                                href="{{ route('parent.fee-challans.index') }}"
                                class="clear-filter-btn"
                            >
                                Clear Filters
                            </a>
                        @endif

                    </div>

                @endif

            </div>

        </div>
    </div>


    <style>

        :root {
            --fee-bg: #f4f7fb;
            --fee-card: #ffffff;
            --fee-secondary: #f8fafc;
            --fee-text: #0f172a;
            --fee-muted: #64748b;
            --fee-soft: #94a3b8;
            --fee-border: #e2e8f0;
            --fee-primary: #2563eb;
            --fee-shadow:
                0 8px 25px rgba(15, 23, 42, .05);
        }

        html.dark-mode {
            --fee-bg: #090e1a;
            --fee-card: #111827;
            --fee-secondary: #172033;
            --fee-text: #f8fafc;
            --fee-muted: #a7b2c5;
            --fee-soft: #75829a;
            --fee-border: #253047;
            --fee-primary: #60a5fa;
            --fee-shadow:
                0 10px 30px rgba(0, 0, 0, .25);
        }

        body {
            background: var(--fee-bg);
        }

        .fee-page-header {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .fee-page-header h2 {
            margin: 0 0 4px;
            color: var(--fee-text);
            font-size: 21px;
            font-weight: 750;
        }

        .fee-page-header p {
            margin: 0;
            color: var(--fee-muted);
            font-size: 12px;
        }

        .back-btn {
            padding: 10px 15px;
            border-radius: 11px;
            background: var(--fee-secondary);
            color: var(--fee-muted);
            display: inline-flex;
            align-items: center;
            gap: 7px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 700;
            transition: transform .25s ease;
        }

        .back-btn:hover {
            transform: translateY(-2px);
        }

        .fee-page {
            min-height: calc(100vh - 70px);
            padding: 30px 20px 50px;
            background:
                radial-gradient(
                    circle at 10% 10%,
                    rgba(37, 99, 235, .05),
                    transparent 28%
                ),
                var(--fee-bg);
        }

        .fee-container {
            width: 100%;
            max-width: 1250px;
            margin: auto;
        }

        .student-card,
        .summary-card,
        .challan-card {
            border: 1px solid var(--fee-border);
            background: var(--fee-card);
            box-shadow: var(--fee-shadow);
            transition:
                background .35s ease,
                border-color .35s ease,
                transform .25s ease;
        }

        .student-card {
            margin-bottom: 18px;
            padding: 17px;
            border-radius: 17px;
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .student-avatar {
            width: 54px;
            height: 54px;
            flex-shrink: 0;
            overflow: hidden;
            border-radius: 14px;
            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #60a5fa
                );
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 19px;
            font-weight: 800;
        }

        .student-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .student-label {
            display: block;
            margin-bottom: 2px;
            color: var(--fee-primary);
            font-size: 8px;
            font-weight: 800;
            letter-spacing: 1px;
        }

        .student-card h3 {
            margin: 0 0 2px;
            color: var(--fee-text);
            font-size: 14px;
            font-weight: 750;
        }

        .student-card p {
            margin: 0;
            color: var(--fee-muted);
            font-size: 10px;
        }

        .summary-grid {
            margin-bottom: 18px;
            display: grid;
            grid-template-columns:
                repeat(4, minmax(0, 1fr));
            gap: 15px;
        }

        .summary-card {
            min-height: 105px;
            padding: 17px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .summary-card:hover {
            transform: translateY(-4px);
        }

        .summary-icon {
            width: 46px;
            height: 46px;
            flex-shrink: 0;
            border-radius: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .total-icon {
            color: #2563eb;
            background: #dbeafe;
        }

        .amount-icon {
            color: #7c3aed;
            background: #ede9fe;
        }

        .paid-icon {
            color: #15803d;
            background: #dcfce7;
        }

        .pending-icon {
            color: #c2410c;
            background: #ffedd5;
        }

        html.dark-mode .total-icon {
            color: #60a5fa;
            background: rgba(37, 99, 235, .16);
        }

        html.dark-mode .amount-icon {
            color: #c084fc;
            background: rgba(147, 51, 234, .15);
        }

        html.dark-mode .paid-icon {
            color: #4ade80;
            background: rgba(34, 197, 94, .14);
        }

        html.dark-mode .pending-icon {
            color: #fb923c;
            background: rgba(249, 115, 22, .14);
        }

        .summary-card span {
            display: block;
            margin-bottom: 2px;
            color: var(--fee-muted);
            font-size: 10px;
            font-weight: 600;
        }

        .summary-card strong {
            display: block;
            margin-bottom: 2px;
            color: var(--fee-text);
            font-size: 16px;
            font-weight: 800;
        }

        .summary-card small {
            color: var(--fee-soft);
            font-size: 8px;
        }

        .challan-card {
            overflow: hidden;
            border-radius: 19px;
        }

        .card-heading {
            padding: 21px 23px;
            border-bottom: 1px solid var(--fee-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
        }

        .section-label {
            display: block;
            margin-bottom: 3px;
            color: var(--fee-primary);
            font-size: 8px;
            font-weight: 800;
            letter-spacing: 1.2px;
        }

        .card-heading h2 {
            margin: 0 0 3px;
            color: var(--fee-text);
            font-size: 17px;
            font-weight: 750;
        }

        .card-heading p {
            margin: 0;
            color: var(--fee-soft);
            font-size: 10px;
        }

        .record-count {
            padding: 6px 10px;
            border-radius: 20px;
            color: #2563eb;
            background: #dbeafe;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 9px;
            font-weight: 700;
            white-space: nowrap;
        }

        html.dark-mode .record-count {
            color: #60a5fa;
            background: rgba(37, 99, 235, .15);
        }

        .filter-form {
            padding: 17px 23px;
            border-bottom: 1px solid var(--fee-border);
            background: var(--fee-secondary);
            display: flex;
            align-items: flex-end;
            gap: 12px;
        }

        .filter-group {
            min-width: 180px;
        }

        .filter-group label {
            display: block;
            margin-bottom: 5px;
            color: var(--fee-muted);
            font-size: 9px;
            font-weight: 700;
        }

        .filter-group select {
            width: 100%;
            height: 39px;
            padding: 0 11px;
            border: 1px solid var(--fee-border);
            border-radius: 9px;
            outline: none;
            background: var(--fee-card);
            color: var(--fee-text);
            font-size: 11px;
        }

        .filter-actions {
            display: flex;
            gap: 7px;
        }

        .filter-btn,
        .reset-btn,
        .clear-filter-btn {
            min-height: 39px;
            padding: 0 13px;
            border-radius: 9px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            text-decoration: none;
            font-size: 10px;
            font-weight: 700;
            cursor: pointer;
        }

        .filter-btn {
            border: none;
            background: #2563eb;
            color: white;
        }

        .reset-btn {
            border: 1px solid var(--fee-border);
            background: var(--fee-card);
            color: var(--fee-muted);
        }

        .challan-list {
            padding: 18px;
        }

        .challan-item {
            margin-bottom: 12px;
            padding: 16px;
            border: 1px solid var(--fee-border);
            border-radius: 14px;
            background: var(--fee-secondary);
            display: flex;
            align-items: center;
            gap: 14px;
            transition:
                transform .25s ease,
                box-shadow .25s ease,
                border-color .25s ease;
        }

        .challan-item:last-child {
            margin-bottom: 0;
        }

        .challan-item:hover {
            transform: translateY(-3px);
            border-color: rgba(37, 99, 235, .25);
            box-shadow:
                0 10px 25px rgba(15, 23, 42, .07);
        }

        .challan-icon {
            width: 48px;
            height: 48px;
            flex-shrink: 0;
            border-radius: 13px;
            color: #7c3aed;
            background: #ede9fe;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        html.dark-mode .challan-icon {
            color: #c084fc;
            background: rgba(147, 51, 234, .15);
        }

        .challan-info {
            min-width: 0;
            flex: 1;
        }

        .challan-title-row {
            margin-bottom: 11px;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
        }

        .challan-number {
            display: block;
            margin-bottom: 2px;
            color: var(--fee-soft);
            font-size: 8px;
            font-weight: 700;
        }

        .challan-title-row h3 {
            margin: 0;
            color: var(--fee-text);
            font-size: 13px;
            font-weight: 750;
        }

        .challan-details {
            display: grid;
            grid-template-columns:
                repeat(6, minmax(0, 1fr));
            gap: 10px;
        }

        .challan-details span,
        .challan-details strong {
            display: block;
        }

        .challan-details span {
            margin-bottom: 2px;
            color: var(--fee-soft);
            font-size: 8px;
        }

        .challan-details strong {
            color: var(--fee-text);
            font-size: 9px;
            font-weight: 650;
        }

        .paid-text {
            color: #15803d !important;
        }

        .pending-text {
            color: #dc2626 !important;
        }

        html.dark-mode .paid-text {
            color: #4ade80 !important;
        }

        html.dark-mode .pending-text {
            color: #f87171 !important;
        }

        .status-badge {
            padding: 5px 9px;
            border-radius: 20px;
            font-size: 8px;
            font-weight: 750;
            white-space: nowrap;
        }

        .status-paid {
            color: #15803d;
            background: #dcfce7;
        }

        .status-partial {
            color: #a16207;
            background: #fef9c3;
        }

        .status-unpaid,
        .status-overdue {
            color: #b91c1c;
            background: #fee2e2;
        }

        html.dark-mode .status-paid {
            color: #4ade80;
            background: rgba(34, 197, 94, .14);
        }

        html.dark-mode .status-partial {
            color: #facc15;
            background: rgba(234, 179, 8, .14);
        }

        html.dark-mode .status-unpaid,
        html.dark-mode .status-overdue {
            color: #f87171;
            background: rgba(239, 68, 68, .14);
        }

        .view-btn {
            padding: 9px 11px;
            flex-shrink: 0;
            border-radius: 9px;
            background: #2563eb;
            color: white;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            font-size: 9px;
            font-weight: 700;
            transition: transform .25s ease;
        }

        .view-btn:hover {
            transform: translateX(3px);
        }

        .pagination-wrapper {
            padding: 17px 22px;
            border-top: 1px solid var(--fee-border);
        }

        .empty-state {
            padding: 60px 20px;
            text-align: center;
        }

        .empty-icon {
            width: 65px;
            height: 65px;
            margin: 0 auto 13px;
            border-radius: 18px;
            background: var(--fee-secondary);
            color: var(--fee-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .empty-state h3 {
            margin: 0 0 5px;
            color: var(--fee-text);
            font-size: 16px;
        }

        .empty-state p {
            margin: 0;
            color: var(--fee-muted);
            font-size: 11px;
        }

        .clear-filter-btn {
            margin-top: 13px;
            background: #2563eb;
            color: white;
        }

        @media (max-width: 1000px) {
            .summary-grid {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }

            .challan-details {
                grid-template-columns:
                    repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 650px) {
            .fee-page {
                padding: 20px 12px 35px;
            }

            .fee-page-header {
                flex-direction: column;
                align-items: stretch;
            }

            .back-btn {
                width: 100%;
                justify-content: center;
            }

            .summary-grid {
                grid-template-columns: 1fr 1fr;
                gap: 10px;
            }

            .summary-card {
                min-height: 95px;
                padding: 13px;
            }

            .summary-icon {
                width: 39px;
                height: 39px;
                font-size: 15px;
            }

            .summary-card strong {
                font-size: 13px;
            }

            .summary-card small {
                display: none;
            }

            .card-heading {
                align-items: flex-start;
                padding: 18px;
            }

            .filter-form {
                padding: 15px;
                flex-direction: column;
                align-items: stretch;
            }

            .filter-group {
                width: 100%;
                min-width: 0;
            }

            .filter-actions {
                width: 100%;
            }

            .filter-btn,
            .reset-btn {
                flex: 1;
            }

            .challan-list {
                padding: 12px;
            }

            .challan-item {
                align-items: flex-start;
                flex-wrap: wrap;
            }

            .challan-info {
                width: calc(100% - 65px);
            }

            .challan-details {
                grid-template-columns: 1fr 1fr;
            }

            .view-btn {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 420px) {
            .summary-grid {
                grid-template-columns: 1fr;
            }

            .challan-details {
                grid-template-columns: 1fr;
            }
        }

    </style>

</x-app-layout>