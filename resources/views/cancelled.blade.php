<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed</title>
    <style>
        body {
                font-family: "MyCustomFont", sans-serif;
            text-align: center;
            padding: 20px;
        }
        .status {
            color: red;
        }
    </style>
</head>
<body>
    <h1 class="status">Payment Failed!</h1>
    <p>Unfortunately, your payment could not be processed.</p>
    <h3>Error Details:</h3>
    <pre>{{ json_encode($status, JSON_PRETTY_PRINT) }}</pre>
</body>
</html>
