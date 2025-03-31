<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Created</title>
</head>
<body style="font-family: Arial, sans-serif; padding: 20px;">
    <h2>Welcome to Our Platform, {{ $user->name }}!</h2>
    <p>Your account has been successfully created.</p>
    <p>You can now log in using your email: <strong>{{ $user->email }}</strong></p>
    <p><a href="" style="display: inline-block; padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px;">Login Now</a></p>
    <p>Thank you for joining us!</p>
</body>
</html>
