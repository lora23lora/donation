<!DOCTYPE html>
<html>

<head>
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
            width: 80px;  /* Adjust the size as necessary */
            height: auto;
        }
        .logoName{
            position: absolute;
            top: 120px;
            left: 20px;
            font-family: 'Arial', sans-serif;
            font-size: 15px;
            color: #0d6f9c;
        }

        /* Table styles */
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }

        /* Table header styles */
        th {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            font-size: 14px;
            text-transform: uppercase;
            text-align: center; /* Center the text inside th */
            vertical-align: middle;
        }

        /* Table data cell styles */
        td {
            padding: 10px;
            font-size: 13px;
            color: #555;
            border-bottom: 1px solid #ddd;
            text-align: center; /* Center the text inside td */
            vertical-align: middle;
        }

        /* Alternating row colors for readability */
        tbody tr:nth-child(odd) {
            background-color: #f2f2f2;
        }

        tbody tr:nth-child(even) {
            background-color: #ffffff;
        }

        /* Table border and spacing */
        table {
            width: 90%;
            margin: 20px auto;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1);
        }

        /* Remove borders from specific table cells for clean design */
        td:first-child, th:first-child {
            border-left: none;
        }

        td:last-child, th:last-child {
            border-right: none;
        }

        /* Additional styling */
        .personal-info-table th {
            background-color: #ED3E34; /* More distinct color for the top table */
        }

        .items-table th {
            background-color: #33a8cf; /* Different color for the items section */
        }

        /* Section headers for readability */
        .section-header {
            font-size: 18px;
            color: #333;
            text-transform: uppercase;
            text-align: center;
            margin-top: 40px;
            margin-bottom: 10px;
        }

    </style>
</head>

<body>
    <img src="logo.jpeg" class="logo" alt="Logo">
<div class="logoName">ڕێکخراوی بژێوی مرۆیی</div>
    @foreach ($models as $model)
        <!-- Personal Information Section -->
        <div class="section-header">Personal Details زانیاری کەسی</div>
        <table class="personal-info-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Amount</th>
                    <th>Birthdate</th>
                    <th>Address</th>
                    <th>Tel1</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $rowColor = $loop->iteration % 2 == 0 ? '#ffffff' : '#ecf5fb';
                @endphp
                <tr style="background-color: {{ $rowColor }}">
                    <td>{{ $model->beneficiary->name }}</td>
                    <td>{{ number_format($model->amount, 0, '.', ',') }}</td>
                    <td>{{ $model->beneficiary->birthdate }}</td>
                    <td>{{ $model->beneficiary->address }}</td>
                    <td>{{ $model->beneficiary->Tel1 }}</td>
                    <td>{{ $model->date ? \Carbon\Carbon::parse($model->date)->format('Y-m-d') : ' ' }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Items Section -->
        @if($model->storages->isNotEmpty())
            <div class="section-header">Items بابەتەکان</div>
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($model->storages as $storage)
                    <tr>
                        <td>{{ $storage->item_name }}</td>
                        <td>{{ $storage->pivot->amount }}</td>
                        <td>{{ number_format($storage->pivot->price, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @endforeach

</body>

</html>
