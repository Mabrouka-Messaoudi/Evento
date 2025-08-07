<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Admin Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }
        body {
            display: flex;
            height: 100vh;
            background-color: #f4f4f4;
        }
        .sidebar {
            width: 250px;
            background-color: #1b1b18;
            color: white;
            padding: 20px;
        }
        .sidebar h2 {
            margin-bottom: 30px;
            font-size: 20px;
            text-align: center;
        }
        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            margin-bottom: 15px;
            font-size: 16px;
            padding: 10px;
            border-radius: 5px;
        }
        .sidebar a:hover {
            background-color: #3e3e3a;
        }
        .main-content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
        }
        .section {
            margin-bottom: 30px;
        }
        .section h3 {
            margin-bottom: 15px;
            font-size: 20px;
            color: #333;
        }
        .card {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
        }
        .card input,
        .card select,
        .card textarea,
        .card button {
            display: block;
            margin-top: 10px;
            width: 100%;
            padding: 10px;
            font-size: 14px;
        }
        .actions button {
            margin-right: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
        }
        .btn-delete {
            background-color: #e53e3e;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-delete:hover {
            background-color: #c53030;
        }
    </style>
</head>
<body>
    <nav class="bg-white shadow fixed w-full z-10 top-0 left-0">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
            <a href="/" class="text-xl font-bold"><img src="{{ asset('images/logo.png')}}" width="60px" height="60px"/></a>

            @auth
                <div class="flex items-center space-x-4">
                    <span>{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="text-red-500 hover:underline">Déconnexion</button>
                    </form>
                </div>
            @endauth

            @guest
                <div class="space-x-4">
                    <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Connexion</a>
                    <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Inscription</a>
                </div>
            @endguest
        </div>
    </nav>
    <div class="sidebar">
        <h2>Admin</h2>
        <a href="#categories">Gestion des Catégories</a>
        <a href="#users">Utilisateurs</a>
        <a href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Déconnexion</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
            @csrf
        </form>
    </div>
    <div class="main-content">
        @yield('content')
    </div>
</body>
</html>
