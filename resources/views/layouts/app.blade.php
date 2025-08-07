<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Événementiel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js']) {{-- If you're using Laravel Vite --}}
</head>
<body class="bg-gray-100 text-gray-800">

    <!-- Navbar -->
    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
            <a href="/" class="text-xl font-bold">Événementiel</a>

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

    <!-- Page Content -->
    <main class="p-6">
        @yield('content')
    </main>

    <!-- Optional Footer -->
    <footer class="bg-white mt-10 text-center py-4 shadow">
        <p class="text-sm text-gray-500">© {{ date('Y') }} Événementiel. Tous droits réservés.</p>
    </footer>
</body>
</html>
