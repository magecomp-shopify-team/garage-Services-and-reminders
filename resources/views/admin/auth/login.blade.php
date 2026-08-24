<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GaragePro Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1a1d20;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .login-card {
            background-color: #2b3035;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.5);
            padding: 30px;
            width: 100%;
            max-width: 400px;
        }
        .btn-primary {
            background-color: #ff4757;
            border: none;
        }
        .btn-primary:hover {
            background-color: #ff6b81;
        }
        .form-control {
            background-color: #212529;
            border: 1px solid #495057;
            color: #fff;
        }
        .form-control:focus {
            background-color: #212529;
            color: #fff;
            border-color: #ff4757;
            box-shadow: 0 0 0 0.25rem rgba(255, 71, 87, 0.25);
        }
    </style>
</head>
<body>
    <div class="login-card">
        <h2 class="text-center mb-4 text-white">GaragePro Admin</h2>
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ url('/admin/login') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label" for="remember">Remember me</label>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
</body>
</html>
