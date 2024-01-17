<!DOCTYPE html>
<html>

<head>
    <title>Donation PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            text-align: left;
            padding: 8px;
            border: 1px solid rgba(211, 213, 214, 0.89);
        }

        th {
            background-color: #67a0c4;
            color: white;
        }

        td:first-child,
        th:first-child {
            border-left: none;
        }

        td:last-child,
        th:last-child {
            border-right: none;
        }

        tbody tr:nth-child(odd) {
            background-color: #ecf5fb;
        }

        tbody tr:nth-child(even) {
            background-color: #ffffff;
        }
    </style>
</head>

<body>
    <div class="title">Donation Information</div>
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
                <th>Amount</th>
                <th>Tel1</th>
                <th>Tel2</th>
                <th>Supervisor</th>
                <th>Date</th>
                <th>Note</th>
                <th>Item</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($models as $model)
                @php
                    $rowColor = $loop->iteration % 2 == 0 ? '#ffffff' : '#ecf5fb';
                    $itemId = $model->line_items[0]['attributes']['items'];
                @endphp
                <tr style="background-color: {{ $rowColor }}">
                    <td>{{ $model->id }}</td>
                    <td>{{ $model->beneficiary->name }}</td>
                    <td>{{ $model->beneficiary->address }}</td>
                    <td>{{ $model->beneficiary->familyMembers }}</td>
                    <td>{{ $model->beneficiary->city->city_name }}</td>
                    <td>{{ $model->beneficiary->birthdate }}</td>
                    <td>{{ $model->beneficiary->statuses }}</td>
                    <td>{{ $model->amount }}</td>
                    <td>{{ $model->beneficiary->Tel1 }}</td>
                    <td>{{ $model->beneficiary->Tel2 }}</td>
                    <td>{{ $model->beneficiary->superviser->name }}</td>
                    <td>{{ $model->date }}</td>
                    <td>{{ $model->note }}</td>
                    <td>{{ $itemId }}</td>
                    {{--
                         [
                        {
                        "layout":"wysiwyg",
                        "key":"cLTQ44yrbmaz7K6C",
                        "attributes":{"items":null,"qty":null}
                         }
                        ]
                         --}}
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
<tbody>

</tbody>
