@extends('layouts.admin')

@section('title', 'Fee Challan')

@section('content')

@php

    $student = $feeChallan->student;

    $months = [
        1 => 'January',
        2 => 'February',
        3 => 'March',
        4 => 'April',
        5 => 'May',
        6 => 'June',
        7 => 'July',
        8 => 'August',
        9 => 'September',
        10 => 'October',
        11 => 'November',
        12 => 'December',
    ];

    $monthName = $months[$feeChallan->month] ?? '';

    /*
    |--------------------------------------------------------------------------
    | Simple Amount To Words
    |--------------------------------------------------------------------------
    */

    $numberToWords = function ($number) {

        $number = (int) round($number);

        if ($number === 0) {
            return 'Zero';
        }

        $ones = [
            0 => '',
            1 => 'One',
            2 => 'Two',
            3 => 'Three',
            4 => 'Four',
            5 => 'Five',
            6 => 'Six',
            7 => 'Seven',
            8 => 'Eight',
            9 => 'Nine',
            10 => 'Ten',
            11 => 'Eleven',
            12 => 'Twelve',
            13 => 'Thirteen',
            14 => 'Fourteen',
            15 => 'Fifteen',
            16 => 'Sixteen',
            17 => 'Seventeen',
            18 => 'Eighteen',
            19 => 'Nineteen',
        ];

        $tens = [
            2 => 'Twenty',
            3 => 'Thirty',
            4 => 'Forty',
            5 => 'Fifty',
            6 => 'Sixty',
            7 => 'Seventy',
            8 => 'Eighty',
            9 => 'Ninety',
        ];

        $convertBelowThousand = function ($num) use ($ones, $tens) {

            $words = [];

            if ($num >= 100) {
                $words[] = $ones[intdiv($num, 100)] . ' Hundred';
                $num %= 100;
            }

            if ($num >= 20) {
                $words[] = $tens[intdiv($num, 10)];

                if ($num % 10) {
                    $words[] = $ones[$num % 10];
                }
            } elseif ($num > 0) {
                $words[] = $ones[$num];
            }

            return implode(' ', $words);
        };

        $parts = [];

        if ($number >= 10000000) {
            $crore = intdiv($number, 10000000);

            $parts[] = $convertBelowThousand($crore) . ' Crore';

            $number %= 10000000;
        }

        if ($number >= 100000) {
            $lakh = intdiv($number, 100000);

            $parts[] = $convertBelowThousand($lakh) . ' Lakh';

            $number %= 100000;
        }

        if ($number >= 1000) {
            $thousand = intdiv($number, 1000);

            $parts[] = $convertBelowThousand($thousand) . ' Thousand';

            $number %= 1000;
        }

        if ($number > 0) {
            $parts[] = $convertBelowThousand($number);
        }

        return implode(' ', $parts);
    };

    $amountInWords =
        $numberToWords($feeChallan->total_amount)
        . ' Rupees Only';

@endphp


<div class="container-fluid challan-page">

    {{-- Screen Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4 no-print">

        <div>

            <h2 class="fw-bold mb-1">
                Fee Challan
            </h2>

            <p class="text-muted mb-0">

                Challan No:
                <strong>{{ $feeChallan->challan_no }}</strong>

            </p>

        </div>


        <div class="d-flex gap-2">

            <a href="{{ route('fee-challans.index') }}"
               class="btn btn-secondary">

                <i class="fa-solid fa-arrow-left"></i>
                Back

            </a>


            <button type="button"
                    class="btn btn-primary"
                    onclick="window.print()">

                <i class="fa-solid fa-print"></i>
                Print Challan

            </button>

        </div>

    </div>


    {{-- Three Copies --}}
    <div class="challan-sheet">

        @foreach([
            'OFFICE COPY',
            'ACCOUNTS COPY',
            'STUDENT COPY'
        ] as $copyName)

            <div class="challan-copy">


                {{-- Header --}}
                <div class="challan-header">

                    <div class="logo-area">

                        <img src="{{ asset('images/logo.png') }}"
                             alt="Logo"
                             class="academy-logo"
                             onerror="this.style.display='none'">

                    </div>


                    <div class="academy-info">

                        <h2>
                            THE GLORIFY ACADEMY
                        </h2>

                        <p>
                            Umerkot
                        </p>

                        <div class="challan-title">
                            FEE CHALLAN
                        </div>

                    </div>

                </div>


                <div class="copy-label">
                    {{ $copyName }}
                </div>


                {{-- Challan Basic Information --}}
                <table class="info-table">

                    <tr>

                        <td class="label">
                            Challan No
                        </td>

                        <td>
                            {{ $feeChallan->challan_no }}
                        </td>

                    </tr>


                    <tr>

                        <td class="label">
                            Date
                        </td>

                        <td>
                            {{ date(
                                'd-m-Y',
                                strtotime($feeChallan->issue_date)
                            ) }}
                        </td>

                    </tr>


                    <tr>

                        <td class="label">
                            Due Date
                        </td>

                        <td>
                            {{ date(
                                'd-m-Y',
                                strtotime($feeChallan->due_date)
                            ) }}
                        </td>

                    </tr>


                    <tr>

                        <td class="label">
                            Month
                        </td>

                        <td>
                            {{ $monthName }}
                            {{ $feeChallan->year }}
                        </td>

                    </tr>


                    <tr>

                        <td class="label">
                            Session
                        </td>

                        <td>
                            {{ $feeChallan->academicSession->session_name ?? 'N/A' }}
                        </td>

                    </tr>

                </table>


                {{-- Account Information --}}
                <div class="section-title">
                    Account Information
                </div>

                <table class="info-table">

                    <tr>

                        <td class="label">
                            Account Title
                        </td>

                        <td>
                            The Glorify Academy
                        </td>

                    </tr>


                    <tr>

                        <td class="label">
                            Account No
                        </td>

                        <td>
                            ______________________
                        </td>

                    </tr>

                </table>


                {{-- Student Information --}}
                <div class="section-title">
                    Student Information
                </div>

                <table class="info-table">

                    <tr>

                        <td class="label">
                            Student Name
                        </td>

                        <td>
                            {{ $student->name ?? 'N/A' }}
                        </td>

                    </tr>


                    <tr>

                        <td class="label">
                            Father Name
                        </td>

                        <td>
                            {{ $student->father_name ?? 'N/A' }}
                        </td>

                    </tr>


                    <tr>

                        <td class="label">
                            Class / Grade
                        </td>

                        <td>
                            {{ $student->classRoom->class_name ?? 'N/A' }}
                        </td>

                    </tr>


                    <tr>

                        <td class="label">
                            Shift
                        </td>

                        <td>
                            {{ $student->shift->name ?? 'N/A' }}
                        </td>

                    </tr>


                    <tr>

                        <td class="label">
                            Student ID
                        </td>

                        <td>
                            {{ $student->student_id ?? 'N/A' }}
                        </td>

                    </tr>


                    <tr>

                        <td class="label">
                            Contact No
                        </td>

                        <td>
                            {{ $student->contact ?? 'N/A' }}
                        </td>

                    </tr>


                    <tr>

                        <td class="label">
                            Address
                        </td>

                        <td>
                            {{ $student->address ?? 'N/A' }}
                        </td>

                    </tr>

                </table>


                {{-- Fee Details --}}
                <div class="section-title">
                    Fee Details
                </div>

                <table class="fee-table">

                    <thead>

                        <tr>

                            <th>
                                Description
                            </th>

                            <th class="amount-column">
                                Amount
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($feeChallan->items as $item)

                            <tr>

                                <td>
                                    {{ $item->description }}
                                </td>

                                <td class="amount-column">

                                    Rs.
                                    {{ number_format(
                                        $item->amount,
                                        0
                                    ) }}

                                </td>

                            </tr>

                        @endforeach


                        @if($feeChallan->late_fine > 0)

                            <tr>

                                <td>
                                    Late Fine
                                </td>

                                <td class="amount-column">

                                    Rs.
                                    {{ number_format(
                                        $feeChallan->late_fine,
                                        0
                                    ) }}

                                </td>

                            </tr>

                        @endif


                        <tr class="total-row">

                            <td>
                                Total Amount
                            </td>

                            <td class="amount-column">

                                Rs.
                                {{ number_format(
                                    $feeChallan->total_amount,
                                    0
                                ) }}

                            </td>

                        </tr>

                    </tbody>

                </table>


                {{-- Amount Words --}}
                <div class="amount-words">

                    <strong>
                        Rupees in Words:
                    </strong>

                    {{ $amountInWords }}

                </div>


                {{-- Status --}}
                <div class="status-box">

                    <strong>Status:</strong>

                    {{ $feeChallan->status }}

                </div>


                {{-- Signatures --}}
                <div class="signature-area">

                    <div class="signature">

                        <div class="signature-line"></div>

                        <span>
                            Student / Parent
                        </span>

                    </div>


                    <div class="signature">

                        <div class="signature-line"></div>

                        <span>
                            Office Signature
                        </span>

                    </div>

                </div>


                {{-- Footer --}}
                <div class="challan-footer">

                    Please keep this challan safe for your record.

                </div>

            </div>

        @endforeach

    </div>

</div>

@endsection


@push('styles')

<style>

    .challan-page {
        padding-bottom: 40px;
    }


    .challan-sheet {

        display: grid;

        grid-template-columns:
            repeat(3, minmax(0, 1fr));

        gap: 10px;

        max-width: 1450px;

        margin: 0 auto;

    }


    .challan-copy {

        background: #fff;

        border: 1.5px solid #222;

        padding: 14px;

        font-size: 11px;

        color: #111;

    }


    .challan-copy:not(:last-child) {

        border-right:
            2px dashed #777;

    }


    .challan-header {

        display: flex;

        align-items: center;

        gap: 8px;

        padding-bottom: 8px;

        border-bottom:
            2px solid #174ea6;

    }


    .logo-area {

        width: 55px;

        flex-shrink: 0;

    }


    .academy-logo {

        width: 52px;

        height: 52px;

        object-fit: contain;

    }


    .academy-info {

        flex: 1;

        text-align: center;

    }


    .academy-info h2 {

        margin: 0;

        font-size: 17px;

        font-weight: 900;

        color: #174ea6;

    }


    .academy-info p {

        margin: 2px 0;

        font-size: 10px;

    }


    .challan-title {

        font-weight: 800;

        font-size: 11px;

        letter-spacing: 1px;

    }


    .copy-label {

        margin: 8px 0;

        padding: 5px;

        text-align: center;

        font-weight: 900;

        background: #eef3f8;

        border: 1px solid #aab7c4;

        letter-spacing: .6px;

    }


    .section-title {

        margin-top: 8px;

        padding: 4px 6px;

        font-weight: 800;

        background: #174ea6;

        color: white;

        font-size: 10px;

    }


    .info-table,
    .fee-table {

        width: 100%;

        border-collapse: collapse;

    }


    .info-table td {

        padding: 4px 5px;

        border: 1px solid #bfc7cf;

        vertical-align: top;

    }


    .info-table .label {

        width: 37%;

        font-weight: 700;

        background: #f7f8fa;

    }


    .fee-table th,
    .fee-table td {

        padding: 5px;

        border: 1px solid #919ba5;

    }


    .fee-table th {

        background: #f1f3f5;

        font-weight: 800;

    }


    .amount-column {

        width: 34%;

        text-align: right;

        white-space: nowrap;

    }


    .total-row td {

        font-weight: 900;

        background: #eaf1fb;

    }


    .amount-words {

        min-height: 40px;

        margin-top: 7px;

        padding: 7px;

        border: 1px solid #bfc7cf;

        line-height: 1.4;

    }


    .status-box {

        margin-top: 7px;

        padding: 6px;

        border: 1px solid #bfc7cf;

    }


    .signature-area {

        display: grid;

        grid-template-columns:
            repeat(2, 1fr);

        gap: 35px;

        margin-top: 38px;

    }


    .signature {

        text-align: center;

    }


    .signature-line {

        border-top:
            1px solid #222;

    }


    .signature span {

        display: block;

        margin-top: 4px;

        font-size: 9px;

        font-weight: 700;

    }


    .challan-footer {

        margin-top: 12px;

        padding-top: 7px;

        border-top:
            1px solid #bfc7cf;

        text-align: center;

        font-size: 8px;

        color: #555;

    }


    @media(max-width: 1100px) {

        .challan-sheet {

            grid-template-columns: 1fr;

        }

    }


    @media print {

        @page {

            size: A4 landscape;

            margin: 5mm;

        }


        body {

            margin: 0 !important;

            padding: 0 !important;

            background: white !important;

            -webkit-print-color-adjust:
                exact !important;

            print-color-adjust:
                exact !important;

        }


        body * {

            visibility: hidden;

        }


        .challan-sheet,
        .challan-sheet * {

            visibility: visible;

        }


        .no-print {

            display: none !important;

        }


        .challan-sheet {

            position: absolute;

            top: 0;

            left: 0;

            width: 100%;

            display: grid !important;

            grid-template-columns:
                repeat(3, 1fr) !important;

            gap: 2mm;

            margin: 0;

        }


        .challan-copy {

            page-break-inside: avoid;

            padding: 3mm;

            font-size: 8px;

            border: 1px solid #222;

        }


        .challan-header {

            padding-bottom: 4px;

        }


        .logo-area {

            width: 40px;

        }


        .academy-logo {

            width: 38px;

            height: 38px;

        }


        .academy-info h2 {

            font-size: 12px;

        }


        .academy-info p {

            font-size: 7px;

        }


        .challan-title {

            font-size: 8px;

        }


        .copy-label {

            margin: 4px 0;

            padding: 3px;

            font-size: 8px;

        }


        .section-title {

            margin-top: 4px;

            padding: 2px 4px;

            font-size: 7px;

        }


        .info-table td,
        .fee-table th,
        .fee-table td {

            padding: 2.5px 3px;

            font-size: 7px;

        }


        .amount-words {

            min-height: 25px;

            margin-top: 4px;

            padding: 4px;

            font-size: 7px;

        }


        .status-box {

            margin-top: 4px;

            padding: 3px;

            font-size: 7px;

        }


        .signature-area {

            gap: 20px;

            margin-top: 22px;

        }


        .signature span {

            font-size: 6.5px;

        }


        .challan-footer {

            margin-top: 6px;

            padding-top: 4px;

            font-size: 6px;

        }

    }

</style>

@endpush