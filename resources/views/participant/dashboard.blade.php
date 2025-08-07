<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Basic -->
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

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

    @include('home.header')
<div class="our_room">
   <div class="container">
      <div class="row">
         <div class="col-md-12">
            <div class="titlepage">
               <h2>Nos Événements</h2>
               <p>Découvrez nos événements à venir</p>
            </div>
         </div>
      </div>

      <div class="row">
         @foreach ($events as $event)
            <div class="col-md-4 col-sm-6">
               <div id="serv_hover" class="room">
                  <div class="room_img">
                     <figure>
                        <img src="{{ asset('storage/' . $event->image) }}" alt="Image de l'événement"/>
                     </figure>
                  </div>
                  <div class="bed_room">
                     <h3>{{ $event->titre }}</h3>
                     <p>{{ Str::limit($event->description, 100) }}</p>
                     <p><strong>Lieu:</strong> {{ $event->lieu }}</p>
                     <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->date)->format('d/m/Y H:i') }}</p>
                     <div class="mt-3">
                        <a href="{{ route('events.show', $event->id) }}" class="btn btn-primary">Voir les détails</a>
                        <a href="{{ route('events.participer', $event->id) }}" class="btn btn-success">Participer</a>
                    </div>
                  </div>
               </div>
            </div>
         @endforeach
      </div>
   </div>
</div>


</body>
</html>
