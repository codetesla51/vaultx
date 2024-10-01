<!-- resources/views/auth/verify.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email Address</title>
</head>
<body>
    <h1>Verify Your Email</h1>
    <p>Please check your email and click the verification link to proceed.</p>
    <p>If you didn't receive an email, click the button below to request another.</p>
    
    <!-- Form to request another verification email -->
    <form action="{{ route('verification.send') }}" method="POST">
        @csrf
        <button type="submit">Resend Verification Email</button>
    </form>
</body>
</html>