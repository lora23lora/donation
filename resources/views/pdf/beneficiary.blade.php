<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Beneficiary PDF</title>
    <style>
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
            width: 180px;
            height: 150px;
        }

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
            font-size: 10px;
            text-transform: uppercase;
            text-align: center;
        }

        td {
            padding: 10px;
            font-size: 13px;
            color: #555;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }

        tbody tr:nth-child(odd) {
            background-color: #f2f2f2;
        }

        tbody tr:nth-child(even) {
            background-color: #ffffff;
        }
    </style>
</head>
<body>
    <img src="logo.jpg" class="logo" alt="Logo">

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Address</th>
                <th>Family Members</th>
                <th>City</th>
                <th>Birthdate</th>
                <th>Status</th>
                <th>Tel1</th>
                <th>Tel2</th>
                <th>Supervisor</th>
                <th>Date</th>
                <th>Note</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($models as $model)
                @php
                    $statusArray = is_array($model->status) ? $model->status : json_decode($model->status);
                @endphp
                <tr>
                    <td>{{ $model->id }}</td>
                    <td>{{ $model->name ?? '' }}</td>
                    <td>{{ $model->address ?? '' }}</td>
                    <td>{{ $model->familyMembers ?? '' }}</td>
                    <td>{{ $model->city->city_name ?? '' }}</td>
                    <td>{{ $model->birthdate ?? '' }}</td>
                    <td>
                        @if(is_array($statusArray))
                            {{ implode(', ', \App\Models\Status::whereIn('status_id', $statusArray)->pluck('name')->toArray()) }}
                        @else
                            {{ optional(\App\Models\Status::find($statusArray))->name ?? '' }}
                        @endif
                    </td>
                    <td>{{ $model->Tel1 ?? '' }}</td>
                    <td>{{ $model->Tel2 ?? '' }}</td>
                    <td>{{ optional($model->superviser)->name ?? '' }}</td>
                    <td>{{ $model->date ? \Carbon\Carbon::parse($model->date)->format('Y-m-d') : '' }}</td>
                    <td>{{ $model->note ?? '' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
