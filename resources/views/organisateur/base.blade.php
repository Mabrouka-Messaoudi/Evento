<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Organisateur Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Tailwind CSS via CDN (or use Vite if your project is set up that way) --}}
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
            height: 100vh;
            position: fixed;
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
            margin-left: 250px;
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

        .reservation-actions button {
            margin-right: 10px;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800">

    <!-- Navbar (full width) -->
    <nav class="bg-white shadow fixed w-full z-10 top-0 left-0">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
            <a href="/" class="text-xl font-bold">Evento</a>

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

    <!-- Sidebar fixed -->
    <div class="sidebar">
        <h2>Organisateur</h2>
        <a href="#events">Mes Événements</a>
        <a href="#create">Créer un Événement</a>
        <a href="#reservations">Réservations</a>
        <a href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Déconnexion</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
    <div class="main-content">
        @yield('content')
    </div>
</body>
</html>
