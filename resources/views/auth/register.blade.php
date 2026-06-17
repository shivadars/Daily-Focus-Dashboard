<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>

    <h1>Register</h1>

    <form action="/register" method="POST">
        @csrf

        <div>
            <label>Name</label>
            <input type="text" name="name">
        </div>

        <br>

        <div>
            <label>Email</label>
            <input type="email" name="email">
        </div>

        <br>

        <div>
            <label>Password</label>
            <input type="password" name="password">
        </div>

        <br>

        <div>
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation">
        </div>

        <br>

        <button type="submit">
            Register
        </button>
    </form>

</body>
</html>