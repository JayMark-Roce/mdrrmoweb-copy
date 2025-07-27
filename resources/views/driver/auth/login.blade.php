<!DOCTYPE html>
<html>
<head>
    <title>Driver Login</title>
</head>
<body>
    <h2>🚑 Driver Login</h2>
    <form method="POST" action="{{ route('driver.login') }}">
        @csrf
        <input type="email" name="email" placeholder="Email" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <button type="submit">Login</button>
    </form>

    @if ($errors->any())
        <div style="color:red;">{{ $errors->first() }}</div>
    @endif
</body>
</html>
