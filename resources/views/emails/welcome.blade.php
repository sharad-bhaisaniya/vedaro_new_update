<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Mahakaaal Creations</title>
    <style>

        .email-container {
            max-width: 700px;
            margin: 20px auto;
            background: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .email-header {
            background: #4caf50;
            color: #fff;
            padding: 20px;
            text-align: center;
            font-size: 24px;
        }
        .email-body {
            padding: 20px;
            line-height: 1.6;
        }
        .email-body h1 {
            color: #4caf50;
            font-size: 22px;
        }
        .email-body p {
            margin: 10px 0;
        }
        .email-footer {
            background: #f1f1f1;
            padding: 10px 20px;
            text-align: center;
            font-size: 14px;
            color: #555;
        }
        .button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #4caf50;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            color: #ffffff;
        }
        .button:hover {
            background: #45a049;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            Welcome to Mahakaaal Creations
        </div>
     
<p>Thank you for registering with us. Your OTP for verification is:</p>

<h3>{{ $otp }}</h3>

<p>Please use this OTP to complete your registration process.</p>
        <div class="email-footer">
            © {{ date('Y') }} Mahakaaal Creations. All rights reserved.
        </div>
    </div>
</body>
</html>
