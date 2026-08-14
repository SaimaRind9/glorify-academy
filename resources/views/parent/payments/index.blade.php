<x-app-layout>

    <x-slot name="header">
        <div class="payment-page-header">

            <div>
                <h2>Payment History</h2>
                <p>View your child’s fee payments and receipts</p>
            </div>

            <a href="{{ route('dashboard') }}" class="back-btn">
                <i class="fa-solid fa-arrow-left"></i>
                Dashboard
            </a>

        </div>
    </x-slot>


    <div class="payment-page">

        <div class="payment-container">


            {{-- Student Card --}}
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

                    <span class="student-label">
                        STUDENT
                    </span>

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


            {{-- Summary --}}
            <div class="summary-grid">

                <div class="summary-card">

                    <div class="summary-icon receipt-icon">
                        <i class="fa-solid fa-receipt"></i>
                    </div>

                    <div>

                        <span>
                            Total Payments
                        </span>

                        <strong>
                            {{ $totalPayments }}
                        </strong>

                        <small>
                            Recorded transactions
                        </small>

                    </div>

                </div>


                <div class="summary-card">

                    <div class="summary-icon paid-icon">
                        <i class="fa-solid fa-money-bill-wave"></i>
                    </div>

                    <div>

                        <span>
                            Total Paid
                        </span>

                        <strong>
                            Rs. {{ number_format($totalPaid, 2) }}
                        </strong>

                        <small>
                            Amount received
                        </small>

                    </div>

                </div>

            </div>


            {{-- Main Payment Card --}}
            <div class="payments-card">

                <div class="card-heading">

                    <div>

                        <span class="section-label">
                            PAYMENTS
                        </span>

                        <h2>
                            Payment & Receipt History
                        </h2>

                        <p>
                            View payment dates, methods and printable receipts.
                        </p>

                    </div>


                    <span class="record-count">

                        <i class="fa-solid fa-wallet"></i>

                        {{ $payments->total() }}
                        Records

                    </span>

                </div>


                {{-- Filters --}}
                <form
                    method="GET"
                    action="{{ route('parent.payments.index') }}"
                    class="filter-form"
                >

                    <div class="filter-group">

                        <label for="payment_method">
                            Payment Method
                        </label>

                        <select
                            name="payment_method"
                            id="payment_method"
                        >

                            <option value="">
                                All Methods
                            </option>

                            @foreach($paymentMethods as $method)

                                <option
                                    value="{{ $method }}"
                                    {{ request('payment_method') === $method ? 'selected' : '' }}
                                >
                                    {{ $method }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    <div class="filter-group">

                        <label for="year">
                            Year
                        </label>

                        <select
                            name="year"
                            id="year"
                        >

                            <option value="">
                                All Years
                            </option>

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

                        <button
                            type="submit"
                            class="filter-btn"
                        >
                            <i class="fa-solid fa-filter"></i>
                            Filter
                        </button>

                        <a
                            href="{{ route('parent.payments.index') }}"
                            class="reset-btn"
                        >
                            <i class="fa-solid fa-rotate-left"></i>
                            Reset
                        </a>

                    </div>

                </form>


                @if($payments->count())

                    <div class="payment-list">

                        @foreach($payments as $payment)

                            <div class="payment-item">


                                <div class="payment-icon">
                                    <i class="fa-solid fa-receipt"></i>
                                </div>


                                <div class="payment-info">

                                    <div class="payment-title-row">

                                        <div>

                                            <span class="receipt-number">
                                                {{ $payment->receipt_no }}
                                            </span>

                                            <h3>
                                                Rs.
                                                {{ number_format(
                                                    (float) $payment->amount,
                                                    2
                                                ) }}
                                            </h3>

                                        </div>


                                        <span class="method-badge">
                                            {{ $payment->payment_method ?? 'N/A' }}
                                        </span>

                                    </div>


                                    <div class="payment-details">

                                        <div>

                                            <span>
                                                Payment Date
                                            </span>

                                            <strong>
                                                {{ $payment->payment_date?->format('d M Y') ?? 'N/A' }}
                                            </strong>

                                        </div>


                                        <div>

                                            <span>
                                                Challan No
                                            </span>

                                            <strong>
                                                {{ $payment->challan?->challan_no ?? 'N/A' }}
                                            </strong>

                                        </div>


                                        <div>

                                            <span>
                                                Month
                                            </span>

                                            <strong>
                                                {{ $payment->challan?->month ?? 'N/A' }}
                                                {{ $payment->challan?->year ?? '' }}
                                            </strong>

                                        </div>


                                        <div>

                                            <span>
                                                Reference
                                            </span>

                                            <strong>
                                                {{ $payment->reference_no ?? '-' }}
                                            </strong>

                                        </div>


                                        <div>

                                            <span>
                                                Received By
                                            </span>

                                            <strong>
                                                {{ $payment->receiver?->name ?? 'N/A' }}
                                            </strong>

                                        </div>

                                    </div>

                                </div>


                                <a
                                    href="{{ route(
                                        'parent.payments.show',
                                        $payment
                                    ) }}"
                                    class="view-btn"
                                >
                                    <span>
                                        Receipt
                                    </span>

                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>

                            </div>

                        @endforeach

                    </div>


                    <div class="pagination-wrapper">
                        {{ $payments->links() }}
                    </div>


                @else

                    <div class="empty-state">

                        <div class="empty-icon">
                            <i class="fa-solid fa-receipt"></i>
                        </div>

                        <h3>
                            No Payments Found
                        </h3>

                        <p>
                            No payment records match the selected filters.
                        </p>

                        @if(request()->hasAny([
                            'payment_method',
                            'year'
                        ]))

                            <a
                                href="{{ route('parent.payments.index') }}"
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
            --payment-bg: #f4f7fb;
            --payment-card: #ffffff;
            --payment-secondary: #f8fafc;
            --payment-text: #0f172a;
            --payment-muted: #64748b;
            --payment-soft: #94a3b8;
            --payment-border: #e2e8f0;
            --payment-primary: #2563eb;
            --payment-shadow:
                0 8px 25px rgba(15, 23, 42, .05);
        }

        html.dark-mode {
            --payment-bg: #090e1a;
            --payment-card: #111827;
            --payment-secondary: #172033;
            --payment-text: #f8fafc;
            --payment-muted: #a7b2c5;
            --payment-soft: #75829a;
            --payment-border: #253047;
            --payment-primary: #60a5fa;
            --payment-shadow:
                0 10px 30px rgba(0, 0, 0, .25);
        }

        body {
            background: var(--payment-bg);
        }

        .payment-page-header {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .payment-page-header h2 {
            margin: 0 0 4px;
            color: var(--payment-text);
            font-size: 21px;
            font-weight: 750;
        }

        .payment-page-header p {
            margin: 0;
            color: var(--payment-muted);
            font-size: 12px;
        }

        .back-btn {
            padding: 10px 15px;
            border-radius: 11px;
            background: var(--payment-secondary);
            color: var(--payment-muted);
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

        .payment-page {
            min-height: calc(100vh - 70px);
            padding: 30px 20px 50px;
            background:
                radial-gradient(
                    circle at 10% 10%,
                    rgba(37, 99, 235, .05),
                    transparent 28%
                ),
                var(--payment-bg);
        }

        .payment-container {
            width: 100%;
            max-width: 1250px;
            margin: auto;
        }

        .student-card,
        .summary-card,
        .payments-card {
            border: 1px solid var(--payment-border);
            background: var(--payment-card);
            box-shadow: var(--payment-shadow);
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
            color: var(--payment-primary);
            font-size: 8px;
            font-weight: 800;
            letter-spacing: 1px;
        }

        .student-card h3 {
            margin: 0 0 2px;
            color: var(--payment-text);
            font-size: 14px;
            font-weight: 750;
        }

        .student-card p {
            margin: 0;
            color: var(--payment-muted);
            font-size: 10px;
        }

        .summary-grid {
            margin-bottom: 18px;
            display: grid;
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
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

        .receipt-icon {
            color: #0891b2;
            background: #cffafe;
        }

        .paid-icon {
            color: #15803d;
            background: #dcfce7;
        }

        html.dark-mode .receipt-icon {
            color: #22d3ee;
            background: rgba(6, 182, 212, .14);
        }

        html.dark-mode .paid-icon {
            color: #4ade80;
            background: rgba(34, 197, 94, .14);
        }

        .summary-card span {
            display: block;
            margin-bottom: 2px;
            color: var(--payment-muted);
            font-size: 10px;
            font-weight: 600;
        }

        .summary-card strong {
            display: block;
            margin-bottom: 2px;
            color: var(--payment-text);
            font-size: 16px;
            font-weight: 800;
        }

        .summary-card small {
            color: var(--payment-soft);
            font-size: 8px;
        }

        .payments-card {
            overflow: hidden;
            border-radius: 19px;
        }

        .card-heading {
            padding: 21px 23px;
            border-bottom: 1px solid var(--payment-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
        }

        .section-label {
            display: block;
            margin-bottom: 3px;
            color: var(--payment-primary);
            font-size: 8px;
            font-weight: 800;
            letter-spacing: 1.2px;
        }

        .card-heading h2 {
            margin: 0 0 3px;
            color: var(--payment-text);
            font-size: 17px;
            font-weight: 750;
        }

        .card-heading p {
            margin: 0;
            color: var(--payment-soft);
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
            border-bottom: 1px solid var(--payment-border);
            background: var(--payment-secondary);
            display: flex;
            align-items: flex-end;
            gap: 12px;
        }

        .filter-group {
            min-width: 190px;
        }

        .filter-group label {
            display: block;
            margin-bottom: 5px;
            color: var(--payment-muted);
            font-size: 9px;
            font-weight: 700;
        }

        .filter-group select {
            width: 100%;
            height: 39px;
            padding: 0 11px;
            border: 1px solid var(--payment-border);
            border-radius: 9px;
            outline: none;
            background: var(--payment-card);
            color: var(--payment-text);
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
            border: 1px solid var(--payment-border);
            background: var(--payment-card);
            color: var(--payment-muted);
        }

        .payment-list {
            padding: 18px;
        }

        .payment-item {
            margin-bottom: 12px;
            padding: 16px;
            border: 1px solid var(--payment-border);
            border-radius: 14px;
            background: var(--payment-secondary);
            display: flex;
            align-items: center;
            gap: 14px;
            transition:
                transform .25s ease,
                box-shadow .25s ease,
                border-color .25s ease;
        }

        .payment-item:last-child {
            margin-bottom: 0;
        }

        .payment-item:hover {
            transform: translateY(-3px);
            border-color: rgba(37, 99, 235, .25);
            box-shadow:
                0 10px 25px rgba(15, 23, 42, .07);
        }

        .payment-icon {
            width: 48px;
            height: 48px;
            flex-shrink: 0;
            border-radius: 13px;
            color: #0891b2;
            background: #cffafe;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        html.dark-mode .payment-icon {
            color: #22d3ee;
            background: rgba(6, 182, 212, .14);
        }

        .payment-info {
            min-width: 0;
            flex: 1;
        }

        .payment-title-row {
            margin-bottom: 11px;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
        }

        .receipt-number {
            display: block;
            margin-bottom: 2px;
            color: var(--payment-soft);
            font-size: 8px;
            font-weight: 700;
        }

        .payment-title-row h3 {
            margin: 0;
            color: #15803d;
            font-size: 14px;
            font-weight: 800;
        }

        html.dark-mode .payment-title-row h3 {
            color: #4ade80;
        }

        .method-badge {
            padding: 5px 9px;
            border-radius: 20px;
            color: #0891b2;
            background: #cffafe;
            font-size: 8px;
            font-weight: 750;
            white-space: nowrap;
        }

        html.dark-mode .method-badge {
            color: #22d3ee;
            background: rgba(6, 182, 212, .14);
        }

        .payment-details {
            display: grid;
            grid-template-columns:
                repeat(5, minmax(0, 1fr));
            gap: 10px;
        }

        .payment-details span,
        .payment-details strong {
            display: block;
        }

        .payment-details span {
            margin-bottom: 2px;
            color: var(--payment-soft);
            font-size: 8px;
        }

        .payment-details strong {
            color: var(--payment-text);
            font-size: 9px;
            font-weight: 650;
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
            border-top: 1px solid var(--payment-border);
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
            background: var(--payment-secondary);
            color: var(--payment-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .empty-state h3 {
            margin: 0 0 5px;
            color: var(--payment-text);
            font-size: 16px;
        }

        .empty-state p {
            margin: 0;
            color: var(--payment-muted);
            font-size: 11px;
        }

        .clear-filter-btn {
            margin-top: 13px;
            background: #2563eb;
            color: white;
        }

        @media (max-width: 950px) {

            .payment-details {
                grid-template-columns:
                    repeat(3, minmax(0, 1fr));
            }

        }

        @media (max-width: 650px) {

            .payment-page {
                padding: 20px 12px 35px;
            }

            .payment-page-header {
                flex-direction: column;
                align-items: stretch;
            }

            .back-btn {
                width: 100%;
            }

            .summary-grid {
                grid-template-columns: 1fr;
            }

            .summary-card {
                min-height: 95px;
                padding: 13px;
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

            .payment-list {
                padding: 12px;
            }

            .payment-item {
                align-items: flex-start;
                flex-wrap: wrap;
            }

            .payment-info {
                width: calc(100% - 65px);
            }

            .payment-details {
                grid-template-columns: 1fr 1fr;
            }

            .view-btn {
                width: 100%;
                justify-content: center;
            }

        }

        @media (max-width: 420px) {

            .payment-details {
                grid-template-columns: 1fr;
            }

        }

    </style>

</x-app-layout>