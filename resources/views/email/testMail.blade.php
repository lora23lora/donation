<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h3>New Beneficiary has been added</h3>
<div>
Name: <p>{{ $donation->beneficiary->name }}</p>
City: <p>{{ $donation->beneficiary->city->city_name }}</p>
Superviser: <p>{{ $donation->beneficiary->superviser->name }}</p>
</div>
</body>
</html>
