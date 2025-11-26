<!DOCTYPE html>
<html>
<head>
    <title>Test Login</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 50px; }
        .form-group { margin-bottom: 15px; }
        input, select { padding: 10px; width: 200px; }
        button { padding: 10px 20px; background: #007bff; color: white; border: none; cursor: pointer; }
        .error { color: red; margin-top: 10px; }
        .success { color: green; margin-top: 10px; }
    </style>
</head>
<body>
    <h2>Test Login</h2>
    
    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif
    
    @if($errors->any())
        <div class="error">
            @foreach($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
    @endif
    
    <form method="POST" action="/login">
        @csrf
        <div class="form-group">
            <label>Username:</label><br>
            <input type="text" name="username" value="{{ old('username') }}" required>
        </div>
        
        <div class="form-group">
            <label>Password:</label><br>
            <input type="password" name="password" required>
        </div>
        
        <button type="submit">Login</button>
    </form>
    
    <hr>
    
    <h3>Test Accounts:</h3>
    <ul>
        <li>Admin: username = <strong>admin</strong>, password = <strong>admin123</strong></li>
        <li>Guru: username = <strong>guru1</strong>, password = <strong>guru123</strong></li>
        <li>Siswa: username = <strong>siswa1</strong>, password = <strong>siswa123</strong></li>
    </ul>
    
    <hr>
    
    <h2>Test Register</h2>
    <form method="POST" action="/register">
        @csrf
        <div class="form-group">
            <label>Nama:</label><br>
            <input type="text" name="nama" required>
        </div>
        
        <div class="form-group">
            <label>Username:</label><br>
            <input type="text" name="username" required>
        </div>
        
        <div class="form-group">
            <label>Password:</label><br>
            <input type="password" name="password" required>
        </div>
        
        <div class="form-group">
            <label>Confirm Password:</label><br>
            <input type="password" name="password_confirmation" required>
        </div>
        
        <div class="form-group">
            <label>Role:</label><br>
            <select name="role" required>
                <option value="">Pilih Role</option>
                <option value="admin">Admin</option>
                <option value="guru">Guru</option>
                <option value="siswa">Siswa</option>
            </select>
        </div>
        
        <button type="submit">Register</button>
    </form>
</body>
</html>