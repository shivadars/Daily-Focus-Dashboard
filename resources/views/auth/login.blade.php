<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

    <h1>Login</h1>

    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <form action="/logincheck" method="POST">
        @csrf

        <div>
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}">
        </div>

        <br>

        <div>
            <label>Password</label>
            <input type="password" name="password">
        </div>

        <br>

        <button type="submit">
            Login
        </button>

    </form>

</body>
</html>