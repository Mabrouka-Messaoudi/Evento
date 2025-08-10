<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Evento</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">

    <!-- Site Metas -->
    <title>Evento</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- Responsive CSS -->
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/fevicon.png') }}" type="image/gif" />

    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/jquery.mCustomScrollbar.min.css') }}">

    <!-- Font Awesome for older IEs -->
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">

    <!-- Fancybox -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <!-- Tes autres CSS... -->
    <style>
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
            margin-left: 270px; /* pour laisser la place à la sidebar */
            padding: 20px;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800">
    @include('home.header')
    <!-- Sidebar fixed -->
    <div class="sidebar">
    <h2>
        {{ Auth::user()->prenom }} {{ Auth::user()->nom }}
    </h2>
    <a href="{{ route('participant.dashboard') }}">Les Événements</a>
    <a href="{{ route('participant.reservations.historique') }}">Mes Réservations</a>

</div>


    <div class="main-content">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @yield('content')
    </div>

</body>
</html>
