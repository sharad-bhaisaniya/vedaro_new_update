<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <style>
        @font-face {
					font-family: "MyCustomFont";
					src: url("{{ asset('fonts/myfont.ttf') }}") format("truetype");
					font-weight: normal;
					font-style: normal;
					}
        body {
            font-family: "MyCustomFont", sans-serif;
            text-align: center;
            padding: 20px;
        }
        .status {
            color: green;
        }
    </style>
</head>
<body>
    <h1 class="status">Payment Successful!</h1>
    <p>Your payment was processed successfully.</p>
    <h3>Transaction Details:</h3>
    <pre>{{ json_encode($status, JSON_PRETTY_PRINT) }}</pre>
</body>
</html>
