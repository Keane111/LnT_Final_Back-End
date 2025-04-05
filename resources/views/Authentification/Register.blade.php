<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register Page</title>
</head>
<body>

    <div class="d-flex justify-content-center align-items-center vh-100" style="background-color: #2e2e2e;">
        <div class="card p-4 shadow-lg" style="width: 400px;">
            <h4 class="text-center mb-4">Register to <strong>ChipiChapa</strong></h4>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" name="name" id="name" class="form-control" required autofocus>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                </div>

                <button type="submit" class="btn w-100 text-dark" style="background-color: #ffc107;">Register</button>

                <div class="text-center mt-3">
                    <small class="text-muted">Already have an account? <a href="{{ route('login') }}">Login here</a></small>
                </div>
            </form>
        </div>
    </div>


</body>
</html>