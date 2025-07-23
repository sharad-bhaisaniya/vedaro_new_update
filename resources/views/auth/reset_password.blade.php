<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Request</title>
    <style>
        /* Styling for the email */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            padding: 20px;
        }
        .email-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 600px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
        }
        .header img {
            width: 150px; /* Replace with your own logo size */
        }
        .content {
            margin-top: 20px;
        }
        .button {
            display: inline-block;
            padding: 12px 25px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }
        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

     <div class="email-container">
        <div class="email-header">
            Welcome to Mahakaaal Creations
        </div>

        <div class="content">
            <p>Hello {{ $username }},</p> <!-- Use the username dynamically here -->

            <p>You are receiving this email because we received a password reset request for your account.</p>
            
            <p><a href="{{ url('password/reset', $token) }}" class="button">Reset Password</a></p>
            
            <p>This password reset link will expire in 60 minutes.</p>

            <p>If you did not request a password reset, no further action is required.</p>
        </div>
    </div>

</body>
</html>
