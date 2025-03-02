<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .menu { background: #007bff; padding: 10px; color: white; }
        .menu a { color: white; text-decoration: none; margin-right: 10px; }
        .container { margin-top: 20px; }
    </style>
</head>
<body>

    <div class="menu">
        <h2>Dashboard | {{ $user->nama}}</h2>
        <a href="{{ route('dashboard') }}">Home</a>
        
        @if($user->user_level === 'admin')
            <a href="{{ route('manage-users') }}">Manage Users</a>
            <a href="#">Manage Products</a>
            <a href="#">View Reports</a>
        @endif
        
        @if($user->user_level === 'officer')
            <a href="#">Create Transaction</a>
            <a href="#">Scan Barcode</a>
        @endif
        
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
        <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
            @csrf
        </form>
    </div>

    <div class="container">
        <h3>Selamat Datang, {{ $user->nama }}</h3>
        <p>Anda login sebagai <strong>{{ ucfirst($user->user_level) }}</strong></p>
    </div>

</body>
</html>
