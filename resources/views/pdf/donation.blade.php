<!DOCTYPE html>
<html>
<head>
    <title>Donation PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            /* Add more styles as needed */
        }
        /* Define CSS styles for the table */
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            text-align: left;
            padding: 8px;
            border: 1px solid rgb(39, 39, 70); /* Set border for each cell */
        }
        th {
            background-color: #b4b0b0; /* Set background color for header cells */
        }
        /* Set specific borders */
        td:first-child,
        th:first-child {
            border-left: none; /* Remove left border for first column */
        }
        td:last-child,
        th:last-child {
            border-right: none; /* Remove right border for last column */
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
                <th>Superviser</th>
                <th>Date</th>
                <th>Note</th>
                <!-- Add table headers for other fields -->
            </tr>
        </thead>
        <tbody>
            @foreach($models as $model)
                <tr>
                    <td>{{ $model->id }}</td>
                    <td>{{ $model->name }}</td>
                    <td>{{ $model->address }}</td>
                    <td>{{ $model->familyMembers }}</td>
                    <td>{{ $model->city->city_name }}</td>
                    <td>{{ $model->birthdate }}</td>
                    <td>{{ $model->status }}</td>
                    <td>{{ $model->amount }}</td>
                    <td>{{ $model->Tel1 }}</td>
                    <td>{{ $model->Tel2 }}</td>
                    <td>{{ $model->superviser->name }}</td>
                    <td>{{ $model->date }}</td>
                    <td>{{ $model->note }}</td>
                    <!-- Display other fields within the loop -->
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
