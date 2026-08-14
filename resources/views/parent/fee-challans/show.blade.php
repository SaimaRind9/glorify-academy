<x-app-layout>

    <x-slot name="header">
        <div class="challan-header">

            <div>
                <h2>Fee Challan</h2>

                <p>
                    {{ $feeChallan->challan_no }}
                    ·
                    {{ $student->name }}
                </p>
            </div>

            <div class="header-actions">

                <a
                    href="{{ route('parent.fee-challans.index') }}"
                    class="back-btn"
                >
                    <i class="fa-solid fa-arrow-left"></i>
                    Back
                </a>

                <button
                    type="button"
                    onclick="window.print()"
                    class="print-btn"
                >
                    <i class="fa-solid fa-print"></i>
                    Print Challan
                </button>

            </div>

        </div>
    </x-slot>


    <div class="challan-page">

        <div class="challan-container">

            <div class="challan-sheet">

                {{-- Academy Header --}}
                <div class="academy-header">

                    <div class="academy-logo">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>

                    <div>
                        <h1>THE GLORIFY ACADEMY</h1>
                        <p>Student Fee Challan</p>
                    </div>

                </div>


                {{-- Challan Title --}}
                <div class="challan-title">

                    <h2>
                        Fee Challan
                    </h2>

                    <span>
                        Challan No:
                        <strong>{{ $feeChallan->challan_no }}</strong>
                    </span>

                </div>


                {{-- Student + Challan Info --}}
                <div class="info-grid">

                    <div class="info-card">

                        <span>Student Name</span>
                        <strong>{{ $student->name }}</strong>

                    </div>

                    <div class="info-card">

                        <span>Student ID</span>
                        <strong>{{ $student->student_id }}</strong>

                    </div>

                    <div class="info-card">

                        <span>Class</span>
                        <strong>
                            {{ $student->classRoom?->class_name ?? 'N/A' }}
                        </strong>

                    </div>

                    <div class="info-card">

                        <span>Academic Session</span>
                        <strong>
                            {{ $feeChallan->academicSession?->session_name
                                ?? $feeChallan->academicSession?->name
                                ?? 'N/A' }}
                        </strong>

                    </div>

                    <div class="info-card">

                        <span>Month / Year</span>
                        <strong>
                            {{ $feeChallan->month }}
                            {{ $feeChallan->year }}
                        </strong>

                    </div>

                    <div class="info-card">

                        <span>Issue Date</span>
                        <strong>
                            {{ $feeChallan->issue_date?->format('d M Y') ?? 'N/A' }}
                        </strong>

                    </div>

                    <div class="info-card">

                        <span>Due Date</span>
                        <strong>
                            {{ $feeChallan->due_date?->format('d M Y') ?? 'N/A' }}
                        </strong>

                    </div>

                    <div class="info-card">

                        <span>Status</span>

                        @php
                            $status = strtolower((string) $feeChallan->status);
                        @endphp

                        <strong>
                            <span class="status-badge status-{{ $status }}">
                                {{ $feeChallan->status }}
                            </span>
                        </strong>

                    </div>

                </div>


                {{-- Fee Items --}}
                <div class="section-title">
                    Fee Details
                </div>

                <div class="table-wrapper">

                    <table class="fee-table">

                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Fee Type</th>
                                <th>Description</th>
                                <th>Amount</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($feeChallan->items as $item)

                                <tr>

                                    <td data-label="#">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td data-label="Fee Type">
                                        {{ $item->fee_name
                                            ?? $item->fee_type
                                            ?? $item->title
                                            ?? 'Fee Item' }}
                                    </td>

                                    <td data-label="Description">
                                        {{ $item->description ?? '-' }}
                                    </td>

                                    <td data-label="Amount">
                                        Rs.
                                        {{ number_format(
                                            (float) (
                                                $item->amount
                                                ?? $item->fee_amount
                                                ?? 0
                                            ),
                                            2
                                        ) }}
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="4" class="empty-row">
                                        No fee items found for this challan.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


                {{-- Amount Summary --}}
                <div class="amount-summary">

                    <div class="amount-row">
                        <span>Subtotal</span>
                        <strong>
                            Rs. {{ number_format((float) $feeChallan->subtotal, 2) }}
                        </strong>
                    </div>

                    <div class="amount-row">
                        <span>Late Fine</span>
                        <strong>
                            Rs. {{ number_format((float) $feeChallan->late_fine, 2) }}
                        </strong>
                    </div>

                    <div class="amount-row total-row">
                        <span>Total Amount</span>
                        <strong>
                            Rs. {{ number_format((float) $feeChallan->total_amount, 2) }}
                        </strong>
                    </div>

                    <div class="amount-row paid-row">
                        <span>Paid Amount</span>
                        <strong>
                            Rs. {{ number_format((float) $feeChallan->paid_amount, 2) }}
                        </strong>
                    </div>

                    <div class="amount-row balance-row">
                        <span>Remaining Balance</span>
                        <strong>
                            Rs. {{ number_format((float) $remainingAmount, 2) }}
                        </strong>
                    </div>

                </div>


                {{-- Payments --}}
                <div class="section-title">
                    Payment History
                </div>

                @if($feeChallan->payments->count())

                    <div class="table-wrapper">

                        <table class="payment-table">

                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Method</th>
                                    <th>Reference</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach($feeChallan->payments as $payment)

                                    <tr>

                                        <td data-label="#">
                                            {{ $loop->iteration }}
                                        </td>

                                        <td data-label="Date">
                                            {{ $payment->payment_date?->format('d M Y')
                                                ?? $payment->created_at?->format('d M Y')
                                                ?? 'N/A' }}
                                        </td>

                                        <td data-label="Amount">
                                            Rs.
                                            {{ number_format(
                                                (float) (
                                                    $payment->amount
                                                    ?? $payment->paid_amount
                                                    ?? 0
                                                ),
                                                2
                                            ) }}
                                        </td>

                                        <td data-label="Method">
                                            {{ $payment->payment_method
                                                ?? $payment->method
                                                ?? 'N/A' }}
                                        </td>

                                        <td data-label="Reference">
                                            {{ $payment->reference_no
                                                ?? $payment->transaction_id
                                                ?? '-' }}
                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @else

                    <div class="no-payment">
                        <i class="fa-solid fa-circle-info"></i>
                        No payment has been recorded for this challan yet.
                    </div>

                @endif


                {{-- Remarks --}}
                @if($feeChallan->remarks)

                    <div class="remarks-section">

                        <div class="section-title">
                            Remarks
                        </div>

                        <div class="remarks-box">
                            {{ $feeChallan->remarks }}
                        </div>

                    </div>

                @endif


                {{-- Signatures --}}
                <div class="signature-area">

                    <div>
                        <div class="signature-line"></div>
                        <span>Parent / Guardian</span>
                    </div>

                    <div>
                        <div class="signature-line"></div>
                        <span>Accounts Office</span>
                    </div>

                </div>


                <div class="challan-footer">
                    Generated by The Glorify Academy Management System
                </div>

            </div>

        </div>

    </div>


    <style>

        :root {
            --challan-bg: #f4f7fb;
            --challan-card: #ffffff;
            --challan-secondary: #f8fafc;
            --challan-text: #0f172a;
            --challan-muted: #64748b;
            --challan-soft: #94a3b8;
            --challan-border: #e2e8f0;
            --challan-primary: #2563eb;
            --challan-shadow:
                0 10px 30px rgba(15, 23, 42, .06);
        }

        html.dark-mode {
            --challan-bg: #090e1a;
            --challan-card: #111827;
            --challan-secondary: #172033;
            --challan-text: #f8fafc;
            --challan-muted: #a7b2c5;
            --challan-soft: #75829a;
            --challan-border: #253047;
            --challan-primary: #60a5fa;
            --challan-shadow:
                0 12px 35px rgba(0, 0, 0, .28);
        }

        body {
            background: var(--challan-bg);
        }

        .challan-header {
            width: 100%;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 20px;
        }

        .challan-header h2 {
            margin: 0 0 4px;

            color: var(--challan-text);

            font-size: 21px;
            font-weight: 750;
        }

        .challan-header p {
            margin: 0;

            color: var(--challan-muted);

            font-size: 12px;
        }

        .header-actions {
            display: flex;
            gap: 9px;
        }

        .back-btn,
        .print-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 7px;

            padding: 10px 15px;

            border-radius: 11px;

            font-size: 12px;
            font-weight: 700;

            text-decoration: none;

            cursor: pointer;
        }

        .back-btn {
            background: var(--challan-secondary);
            color: var(--challan-muted);
        }

        .print-btn {
            border: none;

            background: #2563eb;
            color: white;
        }

        .challan-page {
            min-height: calc(100vh - 70px);

            padding: 30px 20px 50px;

            background:
                radial-gradient(
                    circle at 10% 10%,
                    rgba(37, 99, 235, .05),
                    transparent 30%
                ),
                var(--challan-bg);
        }

        .challan-container {
            width: 100%;
            max-width: 1100px;

            margin: auto;
        }

        .challan-sheet {
            padding: 30px;

            border: 1px solid var(--challan-border);
            border-radius: 20px;

            background: var(--challan-card);

            box-shadow: var(--challan-shadow);
        }


        /* Academy */

        .academy-header {
            padding-bottom: 18px;

            border-bottom: 3px solid #2563eb;

            display: flex;
            align-items: center;
            justify-content: center;

            gap: 14px;

            text-align: center;
        }

        .academy-logo {
            width: 62px;
            height: 62px;

            border-radius: 17px;

            background: #eff6ff;
            color: #2563eb;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 27px;
        }

        html.dark-mode .academy-logo {
            background: rgba(37, 99, 235, .16);
            color: #60a5fa;
        }

        .academy-header h1 {
            margin: 0 0 3px;

            color: var(--challan-text);

            font-size: 24px;
            font-weight: 900;
        }

        .academy-header p {
            margin: 0;

            color: var(--challan-muted);

            font-size: 11px;
        }


        /* Title */

        .challan-title {
            padding: 17px 0;

            text-align: center;
        }

        .challan-title h2 {
            margin: 0 0 4px;

            color: var(--challan-text);

            font-size: 20px;
            font-weight: 750;
        }

        .challan-title span {
            color: var(--challan-muted);

            font-size: 11px;
        }


        /* Info */

        .info-grid {
            margin-bottom: 20px;

            display: grid;

            grid-template-columns:
                repeat(4, minmax(0, 1fr));

            gap: 10px;
        }

        .info-card {
            padding: 12px;

            border: 1px solid var(--challan-border);
            border-radius: 11px;

            background: var(--challan-secondary);
        }

        .info-card > span {
            display: block;

            margin-bottom: 4px;

            color: var(--challan-soft);

            font-size: 8px;

            text-transform: uppercase;

            letter-spacing: .4px;
        }

        .info-card > strong {
            display: block;

            color: var(--challan-text);

            font-size: 11px;
            font-weight: 700;
        }


        /* Sections */

        .section-title {
            margin-top: 18px;

            padding: 8px 11px;

            border-radius: 7px 7px 0 0;

            background: #172554;
            color: white;

            font-size: 11px;
            font-weight: 750;
        }


        /* Tables */

        .table-wrapper {
            overflow-x: auto;
        }

        .fee-table,
        .payment-table {
            width: 100%;

            border-collapse: collapse;
        }

        .fee-table th,
        .payment-table th {
            padding: 10px 11px;

            border: 1px solid var(--challan-border);

            background: var(--challan-secondary);
            color: var(--challan-muted);

            text-align: left;

            font-size: 9px;
            font-weight: 750;
        }

        .fee-table td,
        .payment-table td {
            padding: 10px 11px;

            border: 1px solid var(--challan-border);

            color: var(--challan-text);

            font-size: 10px;
        }

        .empty-row {
            padding: 25px !important;

            color: var(--challan-muted) !important;

            text-align: center;
        }


        /* Amounts */

        .amount-summary {
            width: 100%;
            max-width: 430px;

            margin: 20px 0 0 auto;

            border: 1px solid var(--challan-border);
            border-radius: 12px;

            overflow: hidden;
        }

        .amount-row {
            padding: 10px 13px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 15px;

            border-bottom: 1px solid var(--challan-border);

            background: var(--challan-secondary);

            font-size: 10px;
        }

        .amount-row:last-child {
            border-bottom: none;
        }

        .amount-row span {
            color: var(--challan-muted);
        }

        .amount-row strong {
            color: var(--challan-text);
        }

        .total-row {
            background: #eff6ff;
        }

        .total-row strong {
            color: #2563eb;
        }

        .paid-row strong {
            color: #15803d;
        }

        .balance-row strong {
            color: #dc2626;
        }

        html.dark-mode .total-row {
            background: rgba(37, 99, 235, .14);
        }

        html.dark-mode .total-row strong {
            color: #60a5fa;
        }

        html.dark-mode .paid-row strong {
            color: #4ade80;
        }

        html.dark-mode .balance-row strong {
            color: #f87171;
        }


        /* Status */

        .status-badge {
            display: inline-flex;

            padding: 5px 9px;

            border-radius: 20px;

            font-size: 8px;
            font-weight: 750;
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


        /* No payment */

        .no-payment {
            padding: 16px;

            border: 1px solid var(--challan-border);
            border-top: none;

            color: var(--challan-muted);
            background: var(--challan-secondary);

            display: flex;
            align-items: center;

            gap: 7px;

            font-size: 10px;
        }


        /* Remarks */

        .remarks-box {
            padding: 14px;

            border: 1px solid var(--challan-border);
            border-top: none;

            border-radius: 0 0 8px 8px;

            color: var(--challan-muted);

            font-size: 10px;
            line-height: 1.6;
        }


        /* Signatures */

        .signature-area {
            margin-top: 60px;

            display: grid;

            grid-template-columns:
                repeat(2, minmax(0, 1fr));

            gap: 100px;

            text-align: center;
        }

        .signature-line {
            border-top:
                1px solid var(--challan-muted);
        }

        .signature-area span {
            display: block;

            margin-top: 5px;

            color: var(--challan-muted);

            font-size: 9px;
        }


        /* Footer */

        .challan-footer {
            margin-top: 28px;

            padding-top: 11px;

            border-top:
                1px solid var(--challan-border);

            color: var(--challan-soft);

            text-align: center;

            font-size: 8px;
        }


        /* Responsive */

        @media (max-width: 850px) {

            .info-grid {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }

        }

        @media (max-width: 600px) {

            .challan-header {
                flex-direction: column;
                align-items: stretch;
            }

            .header-actions {
                width: 100%;
            }

            .back-btn,
            .print-btn {
                flex: 1;
            }

            .challan-page {
                padding: 20px 12px 35px;
            }

            .challan-sheet {
                padding: 17px;

                border-radius: 15px;
            }

            .academy-header {
                flex-direction: column;
            }

            .academy-header h1 {
                font-size: 20px;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .amount-summary {
                max-width: none;
            }

            .signature-area {
                gap: 35px;
            }

            .table-wrapper {
                overflow: visible;
            }

            .fee-table,
            .fee-table tbody,
            .fee-table tr,
            .fee-table td,
            .payment-table,
            .payment-table tbody,
            .payment-table tr,
            .payment-table td {
                display: block;

                width: 100%;
            }

            .fee-table thead,
            .payment-table thead {
                display: none;
            }

            .fee-table tr,
            .payment-table tr {
                margin-bottom: 12px;

                overflow: hidden;

                border: 1px solid var(--challan-border);
                border-radius: 12px;
            }

            .fee-table td,
            .payment-table td {
                position: relative;

                min-height: 37px;

                padding:
                    9px 10px
                    9px 43%;

                border-width:
                    0 0 1px;
            }

            .fee-table td:last-child,
            .payment-table td:last-child {
                border-bottom: 0;
            }

            .fee-table td::before,
            .payment-table td::before {
                content: attr(data-label);

                position: absolute;

                top: 9px;
                left: 10px;

                width: 35%;

                color: var(--challan-soft);

                font-size: 8px;
                font-weight: 750;
            }

            .empty-row {
                padding: 20px !important;
            }

            .empty-row::before {
                display: none;
            }

        }


        /* Print */

        @media print {

            @page {
                size: A4 portrait;
                margin: 8mm;
            }

            body {
                margin: 0 !important;

                background: white !important;

                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            body * {
                visibility: hidden;
            }

            .challan-sheet,
            .challan-sheet * {
                visibility: visible;
            }

            .challan-sheet {
                position: absolute;

                top: 0;
                left: 0;

                width: 100%;

                padding: 5mm;

                border: none;
                border-radius: 0;

                background: white !important;

                box-shadow: none;
            }

            .academy-header h1,
            .challan-title h2,
            .info-card strong,
            .fee-table td,
            .payment-table td,
            .amount-row strong {
                color: #000 !important;
            }

            .info-card,
            .fee-table th,
            .payment-table th,
            .amount-row {
                background: #fff !important;
            }

            .fee-table th,
            .fee-table td,
            .payment-table th,
            .payment-table td {
                padding: 6px;

                font-size: 8px;
            }

            .info-grid {
                gap: 5px;
            }

            .info-card {
                padding: 7px;
            }

            .signature-area {
                margin-top: 38px;
            }

        }

    </style>

</x-app-layout>