<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Request</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
            color: #333;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .email-header h1 {
            color: #4CAF50;
            font-size: 24px;
        }
        .email-content {
            font-size: 16px;
            line-height: 1.6;
        }
        .reset-button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            text-align: center;
            color: #777;
        }
    </style>
</head>
<body>

<div class="email-container">
    <div class="email-header">
        <h1>Password Reset Request</h1>
    </div>
    <div class="email-content">
        <p>Dear {{ $username }},</p>
        <p>We received a request to reset the password for your account associated with the email address <strong>{{ $email }}</strong>.</p>
        <p>If you did not make this request, please ignore this email. Otherwise, you can reset your password by clicking the button below:</p>
        <a href="{{ url('password/reset/' . $token) }}" class="reset-button">Reset Password</a>
        <p>If the button doesn't work, you can copy and paste the following URL into your browser:</p>
        <p>{{ url('password/reset/' . $token) }}</p>
    </div>
    <div class="footer">
        <p>&copy; {{ date('Y') }} Your Company. All Rights Reserved.</p>
    </div>
</div>

</body>
</html>
