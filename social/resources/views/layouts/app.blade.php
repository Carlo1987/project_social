<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Progetto Social</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="icon" type="image/jpeg" href="{{ asset('img/logo_facebook.jpeg') }}">

    <script src="https://kit.fontawesome.com/b476d70dd7.js" crossorigin="anonymous"></script>

    <script src="https://cdn.socket.io/4.7.5/socket.io.min.js" integrity="sha384-2huaZvOR9iDzHqslqwpR87isEmrfxqyWOF7hr7BY6KG0+hVKLoEXMPUJw3ynWuhO" crossorigin="anonymous"></script>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/js/main.js', 'resources/sass/_variables.scss',  'resources/css/app.css', 'resources/css/themes.css', 'resources/css/mediaQuery.css'])    
</head>

@if(Auth::check())    <!-- se si è loggati -->



<body class="bg_{{ Themes::show(Auth::user()->id) }}">

    <div id="app">
        <nav class="nav_{{ Themes::show(Auth::user()->id) }} navbar navbar-expand-md navbar-light shadow-sm fixed-top">
            <div class="container">
                <a class="home_{{ Themes::show(Auth::user()->id) }} navbar-brand fw-bold fs-2" style="font-size: 23px; letter-spacing: 1px; font-family: sans-serif; position: relative;" href="{{ route('users.index') }}" id="home"  data-theme="{{ Themes::show(Auth::user()->id) }}">
                      <i class="fa fa-facebook-square" aria-hidden="true"></i>    Social
                </a>
               
@else        <!-- se non si è loggati -->
<body class="bg_default">

    <div id="app">
        <nav class="navbar fixed-top" style="background-color:white; box-shadow: 1px 2px 8px rgb(160, 153, 153);">
            <div class="container">
                <a class="navbar-brand text-primary fw-bold fs-2 " style="font-size: 23px; letter-spacing: 1px; font-family: sans-serif; position: relative;" href="{{ route('users.index') }}" id="home"  data-theme="default">
                    <i class="fa fa-facebook-square" aria-hidden="true"></i>    Social
                </a>
@endif                      
            
            @guest 

                 <ul class="navbar-nav d-flex flex-row gap-4 fs-4">
                        <li class="nav-item me-2 starting_menu">
                            <a class="nav-link" href="{{ route('login.view') }}">{{ __('Login') }}</a>
                        </li>
              
                        <li class="nav-item starting_menu">
                            <a class="nav-link" href="{{ route('register.view') }}">{{ __('Registrati') }}</a>
                        </li>
                 </ul>
          
            @else

            <div id="container_search">
                        <div id="search_user">
                           
                           <span class="download downloadHover" data-theme="{{ Themes::show(Auth::user()->id) }}">
                               <i class="fa-solid fa-users fa-lg">  </i> 
                           </span>

                            <form action="{{ route('user.search') }}" method="POST">
                                @csrf
                                <?php
                                if (url()->current() != 'http://localhost/progetto_facebook/public/users') {
                                    $url = url()->current();
                                } else {
                                    $url = url()->previous();
                                }  ?>
                                <input type="text" name="search" placeholder="Cerca utenti..." class="search_{{ Themes::show(Auth::user()->id) }}">
                                <input type="hidden" name="url" value="<?= $url ?>">
                                <button type="submit" class="search_{{ Themes::show(Auth::user()->id) }}">
                                    <img src="{{ asset('img/glass.png') }}">
                                </button>
                            </form>
                        </div>
            </div>

                <button class="navbar-toggler me-0 search_{{ Themes::show(Auth::user()->id) }}" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
      
                <div class="collapse navbar-collapse" id="navbarMenu">
                    
                    <ul class="navbar-nav mainNavbar d-flex flex-row justify-content-center ms-auto">           
                     <!-- Authentication Links -->
            

                        <li class="nav-item dropdown li_hover li_{{ Themes::show(Auth::user()->id) }} position-relative">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle fs-5" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Carica files
                            </a>

                            <div class="menu_acount dropdown-menu dropdown-menu-end {{ Themes::show(Auth::user()->id) }} div_{{ Themes::show(Auth::user()->id) }} position-absolute " aria-labelledby="navbarDropdown">

                                <a class="dropdown-item" href="{{ route('images.create') }}">
                                    Carica immagine
                                </a>

                                <a class="dropdown-item" href="{{ route('videos.create') }}">
                                    Carica video
                                </a>

                            </div>
                        </li>

                        <li class="nav-item dropdown li_hover li_{{ Themes::show(Auth::user()->id) }} position-relative">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle fs-5 " href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="menu_acount dropdown-menu dropdown-menu-end {{ Themes::show(Auth::user()->id) }} div_{{ Themes::show(Auth::user()->id) }} position-absolute" aria-labelledby="navbarDropdown">

                          
                            @if(Auth::user()->id == 1 || Auth::user()->id > 19)
                            
                                <a class="dropdown-item" href="{{ route('editDatos') }}">
                                    Modifica dati Acount
                                </a>

                                <a class="dropdown-item" href="{{ route('avatar') }}">
                                    Cambia immagine di profilo
                                </a>

                                <a class="dropdown-item" href="{{ route('editPassword') }}">
                                    Modifica password
                                </a>

                                <a class="dropdown-item" href="{{ route('theme') }}">
                                   Cambia temi
                                </a>
                        
                            @endif

                                <a class="dropdown-item logout_{{ Themes::show(Auth::user()->id) }}" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>

                                @if(Auth::user()->id == 1 || Auth::user()->id > 19)
                                <a class="dropdown-item pt-2 destroy_{{ Themes::show(Auth::user()->id) }}" href="{{ route('user.delete', ['id'=>Auth::user()->id]) }}" style="border-top: 1px dashed black;" >
                                    Elimina Acount
                                </a>
                                @endif
                            </div>
                        </li>


                      
                        <li>
                            <a href="{{ route('users.show', ['user' => Auth::user()->id])  }}">
                            @if(Auth::user()->img == 'user_default.png')
                                <img src="{{ asset('img/user_default.png') }}" id="avatar_profile" data-theme="{{ Themes::show(Auth::user()->id) }}" alt="User_image">
                            @else
                                <img src="{{ route('getAvatar', ['avatar' => Auth::user()->img]) }}" id="avatar_profile" data-theme="{{ Themes::show(Auth::user()->id) }}" alt="User_image">
                            @endif
                            </a>
                        </li>
                      


                        <li id="notifications" class="li_{{ Themes::show(Auth::user()->id) }}" data-theme="{{ Themes::show(Auth::user()->id) }}">
                          <a href="{{ route('friendships.index') }}">
                               <i class="fa-sharp fa-solid fa-bell fa-2xl"  style="position: relative;"></i>   
                                  <span id="notifications_number" class="notification_{{ Themes::show(Auth::user()->id) }}" data-theme="{{ Themes::show(Auth::user()->id) }}"> {{ Friendships::count(Auth::user()->id) }} </span>
                          </a>
                        </li>

                    </ul>
                </div>    
                @endguest  
            </div>
      
        </nav>

        <main class="py-4">


        @if(session('message'))
        <div class="alert alert-success mt-3 w-100">
            {{ session('message') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger mt-3 w-100">
            {{ session('error') }}
        </div>
        @endif


            @yield('content')
        </main>
    </div>
</body>
</html>