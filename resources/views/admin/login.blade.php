<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login</title>
    <style>
        body { font-family: system-ui, sans-serif; margin: 0; min-height: 100vh; display: flex; align-items: center; justify-content: center; background: #f1f5f9; }
        .card { background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,.1); width: 100%; max-width: 360px; }
        h1 { margin: 0 0 1.5rem; font-size: 1.25rem; }
        label { display: block; margin-bottom: 0.25rem; font-size: 0.875rem; }
        input { width: 100%; padding: 0.5rem 0.75rem; margin-bottom: 1rem; border: 1px solid #e2e8f0; border-radius: 4px; box-sizing: border-box; }
        button { width: 100%; padding: 0.75rem; background: #0f172a; color: white; border: none; border-radius: 4px; cursor: pointer; }
        .error { color: #dc2626; font-size: 0.875rem; margin-top: 0.5rem; }
    </style>
</head>
<body>
    <div class="card">
        <h1>Admin Login</h1>
        @if ($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif
        <form method="POST" action="{{ route('admin.login') }}">
            @csrf
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required>
            <label><input type="checkbox" name="remember"> Remember me</label>
            <button type="submit">Log in</button>
        </form>
    </div>
</body>
</html>
