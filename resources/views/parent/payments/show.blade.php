<x-app-layout>

    <x-slot name="header">
        <div class="receipt-page-header">

            <div>
                <h2>Payment Receipt</h2>
                <p>
                    Receipt #{{ $payment->receipt_no }}
                </p>
            </div>

            <div class="header-actions">

                <a
                    href="{{ route('parent.payments.index') }}"
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
                    Print Receipt
                </button>

            </div>

        </div>
    </x-slot>


    <div class="receipt-page">

        <div class="receipt-container">

            <div class="receipt-sheet">

                {{-- School Header --}}
                <div class="school-header">

                    <div class="school-logo">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>

                    <div>
                        <h1>THE GLORIFY ACADEMY</h1>
                        <p>Official Fee Payment Receipt</p>
                    </div>

                </div>


                {{-- Receipt Heading --}}
                <div class="receipt-heading">

                    <div>
                        <span class="small-label">
                            PAYMENT RECEIPT
                        </span>

                        <h2>
                            {{ $payment->receipt_no }}
                        </h2>
                    </div>


                    <div class="paid-stamp">
                        <i class="fa-solid fa-circle-check"></i>
                        PAID
                    </div>

                </div>


                {{-- Student Details --}}
                <div class="section-heading">
                    <i class="fa-solid fa-user-graduate"></i>
                    Student Information
                </div>


                <div class="info-grid">

                    <div class="info-card">
                        <span>Student Name</span>
                        <strong>
                            {{ $student->name }}
                        </strong>
                    </div>


                    <div class="info-card">
                        <span>Student ID</span>
                        <strong>
                            {{ $student->student_id }}
                        </strong>
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
                            {{ $payment->challan?->academicSession?->session_name
                                ?? $payment->challan?->academicSession?->name
                                ?? 'N/A' }}
                        </strong>
                    </div>

                </div>


                {{-- Payment Details --}}
                <div class="section-heading">
                    <i class="fa-solid fa-money-bill-wave"></i>
                    Payment Information
                </div>


                <div class="payment-grid">

                    <div class="detail-row">
                        <span>Receipt Number</span>
                        <strong>
                            {{ $payment->receipt_no }}
                        </strong>
                    </div>


                    <div class="detail-row">
                        <span>Payment Date</span>
                        <strong>
                            {{ $payment->payment_date?->format('d M Y') ?? 'N/A' }}
                        </strong>
                    </div>


                    <div class="detail-row">
                        <span>Payment Method</span>
                        <strong>
                            {{ $payment->payment_method ?? 'N/A' }}
                        </strong>
                    </div>


                    <div class="detail-row">
                        <span>Reference Number</span>
                        <strong>
                            {{ $payment->reference_no ?? '-' }}
                        </strong>
                    </div>


                    <div class="detail-row">
                        <span>Received By</span>
                        <strong>
                            {{ $payment->receiver?->name ?? 'School Accounts Office' }}
                        </strong>
                    </div>

                </div>


                {{-- Challan Information --}}
                <div class="section-heading">
                    <i class="fa-solid fa-file-invoice-dollar"></i>
                    Challan Information
                </div>


                <div class="challan-grid">

                    <div class="detail-row">
                        <span>Challan Number</span>
                        <strong>
                            {{ $payment->challan?->challan_no ?? 'N/A' }}
                        </strong>
                    </div>


                    <div class="detail-row">
                        <span>Fee Month</span>
                        <strong>
                            {{ $payment->challan?->month ?? 'N/A' }}
                            {{ $payment->challan?->year ?? '' }}
                        </strong>
                    </div>


                    <div class="detail-row">
                        <span>Issue Date</span>
                        <strong>
                            {{ $payment->challan?->issue_date?->format('d M Y') ?? 'N/A' }}
                        </strong>
                    </div>


                    <div class="detail-row">
                        <span>Due Date</span>
                        <strong>
                            {{ $payment->challan?->due_date?->format('d M Y') ?? 'N/A' }}
                        </strong>
                    </div>

                </div>


                {{-- Amount Box --}}
                <div class="amount-box">

                    <div class="amount-label">
                        Amount Paid
                    </div>

                    <div class="amount-value">
                        <span>Rs.</span>

                        {{ number_format(
                            (float) $payment->amount,
                            2
                        ) }}
                    </div>

                    <div class="amount-note">
                        Payment successfully received
                    </div>

                </div>


                {{-- Challan Financial Summary --}}
                @if($payment->challan)

                    @php
                        $challanTotal =
                            (float) $payment->challan->total_amount;

                        $challanPaid =
                            (float) $payment->challan->paid_amount;

                        $remaining =
                            max(
                                0,
                                $challanTotal - $challanPaid
                            );
                    @endphp


                    <div class="financial-summary">

                        <div>
                            <span>
                                Challan Total
                            </span>

                            <strong>
                                Rs.
                                {{ number_format(
                                    $challanTotal,
                                    2
                                ) }}
                            </strong>
                        </div>


                        <div>
                            <span>
                                Total Paid
                            </span>

                            <strong class="green-text">
                                Rs.
                                {{ number_format(
                                    $challanPaid,
                                    2
                                ) }}
                            </strong>
                        </div>


                        <div>
                            <span>
                                Remaining
                            </span>

                            <strong class="{{ $remaining > 0 ? 'red-text' : 'green-text' }}">
                                Rs.
                                {{ number_format(
                                    $remaining,
                                    2
                                ) }}
                            </strong>
                        </div>

                    </div>

                @endif


                {{-- Remarks --}}
                @if($payment->remarks)

                    <div class="remarks-section">

                        <span>
                            Remarks
                        </span>

                        <p>
                            {{ $payment->remarks }}
                        </p>

                    </div>

                @endif


                {{-- Signatures --}}
                <div class="signature-section">

                    <div class="signature-box">
                        <div class="signature-line"></div>
                        <span>
                            Parent / Guardian
                        </span>
                    </div>


                    <div class="signature-box">
                        <div class="signature-line"></div>
                        <span>
                            Accounts Officer
                        </span>
                    </div>

                </div>


                {{-- Footer --}}
                <div class="receipt-footer">

                    <i class="fa-solid fa-circle-check"></i>

                    This is an official payment receipt generated by
                    The Glorify Academy Management System.

                </div>

            </div>

        </div>

    </div>


    <style>

        :root {
            --receipt-bg: #f4f7fb;
            --receipt-card: #ffffff;
            --receipt-secondary: #f8fafc;
            --receipt-text: #0f172a;
            --receipt-muted: #64748b;
            --receipt-soft: #94a3b8;
            --receipt-border: #e2e8f0;
            --receipt-primary: #2563eb;
            --receipt-shadow:
                0 12px 35px rgba(15, 23, 42, .07);
        }


        html.dark-mode {
            --receipt-bg: #090e1a;
            --receipt-card: #111827;
            --receipt-secondary: #172033;
            --receipt-text: #f8fafc;
            --receipt-muted: #a7b2c5;
            --receipt-soft: #75829a;
            --receipt-border: #253047;
            --receipt-primary: #60a5fa;
            --receipt-shadow:
                0 15px 40px rgba(0, 0, 0, .28);
        }


        body {
            background: var(--receipt-bg);
        }


        /* Header */

        .receipt-page-header {
            width: 100%;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 20px;
        }


        .receipt-page-header h2 {
            margin: 0 0 4px;

            color: var(--receipt-text);

            font-size: 21px;
            font-weight: 750;
        }


        .receipt-page-header p {
            margin: 0;

            color: var(--receipt-muted);

            font-size: 12px;
        }


        .header-actions {
            display: flex;

            gap: 9px;
        }


        .back-btn,
        .print-btn {
            padding: 10px 15px;

            border-radius: 11px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 7px;

            text-decoration: none;

            font-size: 11px;
            font-weight: 700;

            cursor: pointer;

            transition:
                transform .25s ease,
                box-shadow .25s ease;
        }


        .back-btn {
            background: var(--receipt-secondary);

            color: var(--receipt-muted);
        }


        .print-btn {
            border: none;

            background: #2563eb;

            color: white;
        }


        .back-btn:hover,
        .print-btn:hover {
            transform: translateY(-2px);
        }


        /* Page */

        .receipt-page {
            min-height: calc(100vh - 70px);

            padding: 30px 20px 50px;

            background:
                radial-gradient(
                    circle at 10% 10%,
                    rgba(37, 99, 235, .05),
                    transparent 28%
                ),
                var(--receipt-bg);
        }


        .receipt-container {
            width: 100%;
            max-width: 900px;

            margin: auto;
        }


        .receipt-sheet {
            position: relative;

            overflow: hidden;

            padding: 32px;

            border: 1px solid var(--receipt-border);

            border-radius: 20px;

            background: var(--receipt-card);

            box-shadow: var(--receipt-shadow);
        }


        .receipt-sheet::before {
            content: "";

            position: absolute;

            top: 0;
            left: 0;

            width: 100%;
            height: 5px;

            background:
                linear-gradient(
                    90deg,
                    #2563eb,
                    #06b6d4,
                    #22c55e
                );
        }


        /* School */

        .school-header {
            padding: 10px 0 22px;

            border-bottom:
                1px solid var(--receipt-border);

            display: flex;
            align-items: center;
            justify-content: center;

            gap: 14px;

            text-align: center;
        }


        .school-logo {
            width: 64px;
            height: 64px;

            border-radius: 17px;

            background: #eff6ff;

            color: #2563eb;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 27px;
        }


        html.dark-mode .school-logo {
            background:
                rgba(37, 99, 235, .16);

            color: #60a5fa;
        }


        .school-header h1 {
            margin: 0 0 3px;

            color: var(--receipt-text);

            font-size: 24px;
            font-weight: 900;

            letter-spacing: .4px;
        }


        .school-header p {
            margin: 0;

            color: var(--receipt-muted);

            font-size: 10px;
        }


        /* Receipt heading */

        .receipt-heading {
            padding: 20px 0;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 15px;
        }


        .small-label {
            display: block;

            margin-bottom: 3px;

            color: var(--receipt-primary);

            font-size: 8px;
            font-weight: 800;

            letter-spacing: 1.2px;
        }


        .receipt-heading h2 {
            margin: 0;

            color: var(--receipt-text);

            font-size: 18px;
            font-weight: 800;
        }


        .paid-stamp {
            padding: 8px 13px;

            border: 1px solid #86efac;

            border-radius: 9px;

            background: #dcfce7;

            color: #15803d;

            display: flex;
            align-items: center;

            gap: 6px;

            font-size: 10px;
            font-weight: 800;

            letter-spacing: .5px;
        }


        html.dark-mode .paid-stamp {
            border-color:
                rgba(34, 197, 94, .3);

            background:
                rgba(34, 197, 94, .14);

            color: #4ade80;
        }


        /* Sections */

        .section-heading {
            margin-top: 15px;

            padding: 8px 11px;

            border-radius: 8px 8px 0 0;

            background: #172554;

            color: white;

            display: flex;
            align-items: center;

            gap: 7px;

            font-size: 10px;
            font-weight: 750;
        }


        /* Info */

        .info-grid {
            padding: 13px;

            border:
                1px solid var(--receipt-border);

            display: grid;

            grid-template-columns:
                repeat(4, minmax(0, 1fr));

            gap: 10px;
        }


        .info-card {
            padding: 10px;

            border-radius: 9px;

            background: var(--receipt-secondary);
        }


        .info-card span,
        .detail-row span {
            display: block;

            margin-bottom: 3px;

            color: var(--receipt-soft);

            font-size: 8px;
        }


        .info-card strong,
        .detail-row strong {
            display: block;

            color: var(--receipt-text);

            font-size: 10px;
            font-weight: 700;
        }


        /* Details */

        .payment-grid,
        .challan-grid {
            border:
                1px solid var(--receipt-border);

            border-top: none;

            display: grid;

            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }


        .detail-row {
            padding: 12px;

            border-bottom:
                1px solid var(--receipt-border);
        }


        .detail-row:nth-child(odd) {
            border-right:
                1px solid var(--receipt-border);
        }


        /* Amount */

        .amount-box {
            margin: 25px 0;

            padding: 22px;

            border:
                1px solid #bbf7d0;

            border-radius: 15px;

            background:
                linear-gradient(
                    135deg,
                    #f0fdf4,
                    #dcfce7
                );

            text-align: center;
        }


        .amount-label {
            margin-bottom: 4px;

            color: #15803d;

            font-size: 9px;
            font-weight: 700;

            text-transform: uppercase;

            letter-spacing: .7px;
        }


        .amount-value {
            color: #166534;

            font-size: 29px;
            font-weight: 900;
        }


        .amount-value span {
            font-size: 14px;
        }


        .amount-note {
            margin-top: 3px;

            color: #16a34a;

            font-size: 8px;
        }


        html.dark-mode .amount-box {
            border-color:
                rgba(34, 197, 94, .25);

            background:
                rgba(34, 197, 94, .10);
        }


        html.dark-mode .amount-label,
        html.dark-mode .amount-value,
        html.dark-mode .amount-note {
            color: #4ade80;
        }


        /* Financial summary */

        .financial-summary {
            display: grid;

            grid-template-columns:
                repeat(3, minmax(0, 1fr));

            gap: 10px;
        }


        .financial-summary > div {
            padding: 13px;

            border:
                1px solid var(--receipt-border);

            border-radius: 10px;

            background: var(--receipt-secondary);
        }


        .financial-summary span {
            display: block;

            margin-bottom: 4px;

            color: var(--receipt-soft);

            font-size: 8px;
        }


        .financial-summary strong {
            color: var(--receipt-text);

            font-size: 11px;
        }


        .green-text {
            color: #15803d !important;
        }


        .red-text {
            color: #dc2626 !important;
        }


        html.dark-mode .green-text {
            color: #4ade80 !important;
        }


        html.dark-mode .red-text {
            color: #f87171 !important;
        }


        /* Remarks */

        .remarks-section {
            margin-top: 20px;

            padding: 13px;

            border:
                1px solid var(--receipt-border);

            border-radius: 10px;

            background: var(--receipt-secondary);
        }


        .remarks-section span {
            display: block;

            margin-bottom: 4px;

            color: var(--receipt-soft);

            font-size: 8px;
            font-weight: 700;
        }


        .remarks-section p {
            margin: 0;

            color: var(--receipt-muted);

            font-size: 10px;

            line-height: 1.6;
        }


        /* Signatures */

        .signature-section {
            margin-top: 65px;

            display: grid;

            grid-template-columns:
                repeat(2, minmax(0, 1fr));

            gap: 100px;
        }


        .signature-box {
            text-align: center;
        }


        .signature-line {
            border-top:
                1px solid var(--receipt-muted);
        }


        .signature-box span {
            display: block;

            margin-top: 6px;

            color: var(--receipt-muted);

            font-size: 9px;
        }


        /* Footer */

        .receipt-footer {
            margin-top: 30px;

            padding-top: 12px;

            border-top:
                1px solid var(--receipt-border);

            color: var(--receipt-soft);

            text-align: center;

            font-size: 8px;
        }


        .receipt-footer i {
            margin-right: 4px;

            color: #22c55e;
        }


        /* Responsive */

        @media (max-width: 700px) {

            .receipt-page-header {
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


            .receipt-page {
                padding: 20px 12px 35px;
            }


            .receipt-sheet {
                padding: 18px;

                border-radius: 15px;
            }


            .school-header {
                flex-direction: column;
            }


            .school-header h1 {
                font-size: 20px;
            }


            .info-grid {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }


            .financial-summary {
                grid-template-columns: 1fr;
            }


            .signature-section {
                gap: 35px;
            }

        }


        @media (max-width: 450px) {

            .receipt-heading {
                align-items: flex-start;
            }


            .info-grid {
                grid-template-columns: 1fr;
            }


            .payment-grid,
            .challan-grid {
                grid-template-columns: 1fr;
            }


            .detail-row:nth-child(odd) {
                border-right: none;
            }


            .amount-value {
                font-size: 24px;
            }

        }


        /* Print */

        @media print {

            @page {
                size: A4 portrait;
                margin: 10mm;
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


            .receipt-sheet,
            .receipt-sheet * {
                visibility: visible;
            }


            .receipt-sheet {
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


            .school-header h1,
            .receipt-heading h2,
            .info-card strong,
            .detail-row strong,
            .financial-summary strong {
                color: #000 !important;
            }


            .info-card,
            .financial-summary > div {
                background: #fff !important;
            }


            .amount-box {
                background: #f0fdf4 !important;
            }


            .signature-section {
                margin-top: 45px;
            }

        }

    </style>

</x-app-layout>