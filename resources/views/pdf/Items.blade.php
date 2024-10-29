<!DOCTYPE html>
<html>

<head>
    <title>Storage PDF</title>
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

        /* Logo styles */
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
            background-color: #ED3E34;
            color: white;
            padding: 10px;
            font-size: 14px;
            text-transform: uppercase;
            text-align: center; /* Center the text inside th */
            vertical-align: middle;
        }
        .item{
            background-color: #1fb7fd;
        }

        /* Table data cell styles */
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

        /* Table border and spacing */
        table {
            width: 90%;
            margin: 20px auto;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1);
        }

        /* Personal info table styling with larger cell height */
        .personal-info-table td {
            height: 50px; /* Adjust this value to your preference */
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


    <img src="logo.jpeg" class="logo" alt="Logo">
<div class="logoName">ڕێکخراوی بژێوی مرۆیی</div>
    <div class="section-header">Personal Information  زانیاری کەسی</div>
    <table class="personal-info-table items-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Amount</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td></td>
                <td></td>
                <td>{{ date('Y-m-d') }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Items Section -->
    <div class="section-header">Items  بابەتەکان</div>
    <table class="items-table">
        <thead>
            <tr>
                <th class="item">Item Name</th>
                <th class="item">Has Item</th>
                <th class="item">Does Not Have</th>
                <th class="item">Quantity</th>
                <th class="item">Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($models as $model)
            <tr>
                <td>{{ $model->item_name }}</td>
                <td><input type="checkbox" {{ $model->has_item ? 'checked' : '' }}></td>
                <td><input type="checkbox" {{ !$model->has_item ? 'checked' : '' }}></td>
                <td></td> <!-- Empty Quantity -->
                <td></td> <!-- Empty Price -->
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Signature Section -->
    <div class="signature-section">
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
