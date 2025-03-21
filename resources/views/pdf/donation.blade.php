<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Donation PDF</title>
    <style>
        /* Base styles */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f9fa;
        }

        h1, h2 {
            color: #333;
            text-align: center;
        }

        .logo {
            position: absolute;
            top: 10px;
            left: 10px;
            width: 180px;  /* Adjust the size as necessary */
            height: 150px;
        }

        /* Table styles */
        table {
            border-collapse: collapse;
            width: 90%;
            margin: 20px auto;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1);
        }

        th {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            font-size: 10px; /* Adjusted font size */
            text-transform: uppercase;
            text-align: center;
            vertical-align: middle;
        }

        td {
            padding: 10px;
            font-size: 13px;
            color: #555;
            border-bottom: 1px solid #ddd;
            text-align: center;
            vertical-align: middle;
        }

        /* Alternating row colors for readability */
        tbody tr:nth-child(odd) {
            background-color: #f2f2f2;
        }

        tbody tr:nth-child(even) {
            background-color: #ffffff;
        }

        .personal-info-table th {
            background-color: #ED3E34;
        }

        .total-row td {
            font-weight: bold;
            color: #333;
            background-color: #f7f9fa;
            border-top: 2px solid #4CAF50;
        }
    </style>
</head>
<body>
    <img src="logo.jpg" class="logo" alt="Logo">

    <table class="personal-info-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Supervisor</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Note</th>
                <th>Items</th> <!-- New column for items -->
            </tr>
        </thead>
        <tbody>
            @php
                $totalAmount = 0;
            @endphp
            @foreach ($models as $model)
                <tr>
                    <td>{{ $model->beneficiary->name ?? '' }}</td>
                    <td>{{ $model->superviser->name ?? '' }}</td>
                    <td>{{ number_format($model->amount, 0, '.', ',') }}</td>
                    <td>{{ $model->date ? \Carbon\Carbon::parse($model->date)->format('Y-m-d') : '' }}</td>
                    <td>{{ $model->note }}</td>

                    {{-- New column for storage items --}}
                    <td>
                        @if($model->storages->count() > 0)
                            @php
                                $items = $model->storages->pluck('item_name')->join(' - ');
                            @endphp
                            {{ $items }}
                        @else
                             <!-- No items if none available -->
                        @endif
                    </td>
                </tr>
                @php
                    $totalAmount += $model->amount;
                @endphp
            @endforeach

            <!-- Total Row -->
            <tr class="total-row">
                <td colspan="3">Total Amount</td>
                <td colspan="6">{{ number_format($totalAmount, 0, '.', ',') }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
