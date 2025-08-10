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
<header>
        <!-- Header -->
<div class="header">
   <div class="container">
      <div class="row">
         <!-- Logo Section -->
         <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col logo_section">
            <div class="full">
               <div class="center-desk">
                  <div class="logo">
                     <a href="{{ route('home') }}"><img src="{{ asset('images/logo.png') }}" width="60" height="60" alt="Logo" /></a>
                  </div>
               </div>
            </div>
         </div>

         <!-- Navigation Section -->
         <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9">
            <nav class="navigation navbar navbar-expand-md navbar-dark">
               <button class="navbar-toggler" type="button" data-toggle="collapse"
                  data-target="#navbarsExample04" aria-controls="navbarsExample04"
                  aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
               </button>

               <div class="collapse navbar-collapse" id="navbarsExample04">
                  <ul class="navbar-nav mr-auto">
                     <li class="nav-item active">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="{{ url('/about') }}">À propos de nous</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="{{ url('/evenements') }}">Nos Événements</a>
                     </li>

                     {{-- Auth based navigation --}}
                     @if (Route::has('login'))
                        @auth
                           @php
                              $redirectRoute = '#';
                              if (Auth::user()->role === 'admin') {
                                  $redirectRoute = route('admin.dashboard');
                              } elseif (Auth::user()->role === 'organisateur') {
                                  $redirectRoute = route('organisateur.dashboard');
                              } elseif (Auth::user()->role === 'participant') {
                                  $redirectRoute = route('participant.dashboard');
                              }
                           @endphp
                           <li class="nav-item">
                              <a class="nav-link" href="{{ $redirectRoute }}">Dashboard</a>
                           </li>
                        @else
                           <li class="nav-item">
                              <a class="nav-link" href="{{ route('login') }}">Log in</a>
                           </li>
                           @if (Route::has('register'))
                              <li class="nav-item">
                                 <a class="nav-link" href="{{ route('register') }}">Register</a>
                              </li>
                           @endif
                        @endauth
                     @endif
                  </ul>

                  {{-- Username and Logout side by side --}}
                  @auth
                     <ul class="navbar-nav ml-auto align-items-center">
                        <li class="nav-item">
                           <span class="nav-link" style="color: #000; cursor: default;">
                              {{ Auth::user()->prenom }} {{ Auth::user()->nom }}
                           </span>
                        </li>
                        <li class="nav-item">
                           <form method="POST" action="{{ route('logout') }}">
                              @csrf
                              <button type="submit" class="btn btn-link nav-link" style="padding: 0; color: #000; text-decoration: underline; cursor: pointer;">
                                 Déconnexion
                              </button>
                           </form>
                        </li>
                     </ul>
                  @endauth
               </div>
            </nav>
         </div>
      </div>
   </div>
   </header>
<div class="sidebar">
    <h2>
        {{ Auth::user()->prenom }} {{ Auth::user()->nom }}
    </h2>
    <a href="{{ url('/organisateur/dashboard') }}">Mes Événements</a>
    <a href="{{ url('/organisateur/events/creer') }}">Créer un Événement</a>
    <a href="{{ url('/organisateur/reservations') }}">Réservations</a>
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
