<!DOCTYPE html>
<html>
<head>
    <title>Test Login Debug</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        form { margin: 10px 0; padding: 10px; border: 1px solid #ccc; }
        input, button { margin: 5px; padding: 8px; }
        a { display: inline-block; margin: 5px; padding: 8px; background: #007bff; color: white; text-decoration: none; }
    </style>
</head>
<body>
    <h2>Test Login Debug</h2>
    
    <h3>Direct Links (No CSRF needed)</h3>
    <a href="/login-guru">Direct Guru Login</a>
    <a href="/login-siswa/siswa1">Direct Siswa Login</a>
    <a href="/login-admin">Direct Admin Login</a>
    
    <h3>Form Login (With CSRF)</h3>
    <form action="/login" method="POST">
        @csrf
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
    </form>
    
    <h3>Quick Guru Login</h3>
    <form action="/login" method="POST">
        @csrf
        <input type="hidden" name="username" value="guru1">
        <input type="hidden" name="password" value="guru123">
        <button type="submit">Login as Guru</button>
    </form>
    
    <h3>Quick Siswa Login</h3>
    <form action="/login" method="POST">
        @csrf
        <input type="hidden" name="username" value="siswa1">
        <input type="hidden" name="password" value="siswa123">
        <button type="submit">Login as Siswa</button>
    </form>
    
    <h3>Current Session Info</h3>
    <p>CSRF Token: {{ csrf_token() }}</p>
    <p>Session ID: {{ session()->getId() }}</p>
    @if(Auth::check())
        <p>Logged in as: {{ Auth::user()->nama }} ({{ Auth::user()->role }})</p>
        <form action="/logout" method="POST">
            @csrf
            <button type="submit">Logout</button>
        </form>
    @else
        <p>Not logged in</p>
    @endif
</body>
</html>