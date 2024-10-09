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
            vertical-align: middle; /* Align vertically to the middle */
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
            background-color: #f2994a; /* More distinct color for the top table */
        }

        .items-table th {
            background-color: #56ccf2; /* Different color for the items section */
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

        /* Signature area styling */
        .signature-section {
            margin-top: 40px;
            text-align: center;
        }

        .supervisor-table {
            width: 80%;
            margin: 30px auto;
        }

        .supervisor-table td {
            padding: 20px;
            text-align: center;
            font-weight: bold;
            vertical-align: bottom;
        }

        .signature-line {
            margin-top: 40px;
            border-top: 1px solid #000;
            width: 200px;
            margin-left: auto;
            margin-right: auto;
        }

        footer {
            text-align: center;
            padding: 10px;
            font-size: 12px;
            color: #888;
            border-top: 1px solid #ddd;
            margin-top: 30px;
        }
    </style>
</head>

<body>

    <h1>Donation Summary</h1>

    @foreach ($models as $model)
        <!-- Personal Information Section -->
        <div class="section-header">Beneficiary Details</div>
        <table class="personal-info-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>Birthdate</th>
                    <th>Tel1</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $rowColor = $loop->iteration % 2 == 0 ? '#ffffff' : '#ecf5fb';
                    $statusArray = is_array($model->beneficiary->status)
                        ? $model->beneficiary->status
                        : json_decode($model->beneficiary->status);
                @endphp
                <tr style="background-color: {{ $rowColor }}">
                    <td>{{ $model->beneficiary->name }}</td>
                    <td>{{ $model->beneficiary->address }}</td>
                    <td>{{ $model->beneficiary->city->city_name }}</td>
                    <td>{{ $model->beneficiary->birthdate }}</td>
                    <td>{{ $model->beneficiary->Tel1 }}</td>
                    <td>{{ $model->date ? \Carbon\Carbon::parse($model->date)->format('Y-m-d') : ' ' }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Items Section -->
        <div class="section-header">Donation Items</div>
        <table class="items-table">
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Has Item</th>
                    <th>Does Not Have</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($model->storages as $storage)
                <tr>
                    <td>{{ $storage->item_name }}</td>
                    <td>{{ $storage->pivot->amount }}</td>
                    <td>{{ number_format($storage->pivot->price, 2) }}</td>
                    <td><input type="checkbox" {{ $storage->has_item ? 'checked' : '' }}></td>
                    <td><input type="checkbox" {{ !$storage->has_item ? 'checked' : '' }}></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach

    <!-- Signature Section -->
    <div class="signature-section">
        <div class="section-header">Supervisors and Signatures</div>
        <table class="supervisor-table">
            <tr>
                <td>ئەندام<br><div class="signature-line"></div></td>
                <td>ئەندام<br><div class="signature-line"></div></td>
                <td>سەرپەرشتیار<br><div class="signature-line"></div></td>
            </tr>
        </table>
    </div>



</body>

</html>
