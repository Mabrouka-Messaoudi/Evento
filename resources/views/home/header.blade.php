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
</div>
