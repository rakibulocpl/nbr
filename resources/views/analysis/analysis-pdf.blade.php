<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Analysis Report - {{ $analysis->taxpayer_name }}</title>
    <style>
        @page {
            margin-top: 60px; /* prevents header overlap */
            margin-bottom: 40px;
            margin-left: 20px;
            margin-right: 20px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            color: #333;
            font-size: 12px;
            line-height: 1.4;
            margin-top: 20px;
        }

        h1, h2, h3, h4 {
            margin: 0;
            color: #222;
        }

        .container {
            width: 100%;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #444;
            margin-bottom: 20px;
            padding-bottom: 10px;
            position: relative;
        }

        .section {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        table, th, td {
            border: 1px solid #999;
        }

        th {
            background: #f2f2f2;
        }

        th, td {
            padding: 6px;
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            border-top: 1px solid #aaa;
            padding-top: 10px;
            font-size: 11px;
            color: #666;
            margin-top: 40px;
            text-align: center;
        }

        .bank-section {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 6px;
            page-break-inside: avoid;
        }
    </style>
</head>
<body>

<div class="container">
    {{-- Header --}}
    <div class="header">
        <h2>Taxpayer Analysis Report</h2>
        <p><strong>Taxpayer Name:</strong> {{ $analysis->taxpayer_name }}</p>
        <p><strong>TIN No:</strong> {{ $analysis->tin_no }}</p>
    </div>

    {{-- Bank Files --}}
    @foreach ($analysis->files as $file)
        <div class="bank-section">
            <h3>{{ $file->bank->name ?? 'Unknown Bank' }} ({{ $file->bank->short_name ?? '-' }})</h3>

            <table>
                <tr>
                    <th>Account No</th>
                    <td>{{ $file->acc_no ?? '-' }}</td>
                    <th>Account Type</th>
                    <td>{{ $file->acc_type ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Opening Balance</th>
                    <td>{{ number_format($file->opening_balance, 2) }}</td>
                    <th>Closing Balance</th>
                    <td>{{ number_format($file->closing_balance, 2) }}</td>
                </tr>
            </table>

            @if($file->yearlySummaries->count())
                <h4 style="margin-top: 10px;">Yearly Summary</h4>
                <table>
                    <thead>
                    <tr>
                        <th>Fiscal Year</th>
                        <th>Total Debit</th>
                        <th>Total Credit</th>
                        <th>Credit Interest</th>
                        <th>Source Tax</th>
                        <th>Year-End Balance</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($file->yearlySummaries as $summary)
                        <tr>
                            <td>{{ $summary->fiscal_year }}</td>
                            <td class="text-right">{{ number_format($summary->total_debit, 2) }}</td>
                            <td class="text-right">{{ number_format($summary->total_credit, 2) }}</td>
                            <td class="text-right">{{ number_format($summary->credit_interest, 2) }}</td>
                            <td class="text-right">{{ number_format($summary->source_tax, 2) }}</td>
                            <td class="text-right">{{ number_format($summary->yearend_balance, 2) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p><em>No yearly summary available.</em></p>
            @endif
        </div>
    @endforeach

    {{-- Footer --}}
    <div class="footer">
        <p><strong>Created at:</strong> {{ $analysis->created_at->format('d M Y, h:i A') }}</p>
        <p><strong>Last updated:</strong> {{ $analysis->updated_at->format('d M Y, h:i A') }}</p>
    </div>
</div>

</body>
</html>
