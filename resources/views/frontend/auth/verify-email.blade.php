
<h1>Email Verification Mail</h1>
<p>Please verify your email with the link below:</p>
<button style="background-color: #f38630; color: #fff; padding: 10px 20px; border: none; border-radius: 5px; text-decoration: none;">
    <a href="{{ route('user.verify', $token) }}" style="color: inherit; text-decoration: none;">Verify Email</a>
</button>

