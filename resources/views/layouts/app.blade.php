<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Faceback</title>

    <!-- Fonts -->
    <link rel="icon" type="image/jpeg" href="{{ asset('img/logo_facebook.jpeg') }}">
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">          <!-- animazioni -->

    <script src="https://kit.fontawesome.com/b476d70dd7.js" crossorigin="anonymous"></script>                        <!-- Fontawesome -->

    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>                                  <!-- Gsap -->

    <script src="https://cdn.socket.io/4.7.5/socket.io.min.js" integrity="sha384-2huaZvOR9iDzHqslqwpR87isEmrfxqyWOF7hr7BY6KG0+hVKLoEXMPUJw3ynWuhO" crossorigin="anonymous"></script>   <!-- Socket.io -->

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/js/main.js', 'resources/sass/_variables.scss', 'resources/css/app.css', 'resources/css/themes.css', 'resources/css/mediaQuery.css'])
</head>



@if(Auth::check())       <!-- se si è loggati -->

<body class="bg_{{ Themes::show() }}">

    <div id="app">
        <nav class="nav_{{ Themes::show() }} navbar navbar-expand-lg navbar-light shadow-sm fixed-top">
            <div class="container">   
                <a class="home_{{ Themes::show() }} navbar-brand fw-bold fs-2" style="font-size: 23px; letter-spacing: 1px; font-family: sans-serif; position: relative;" href="{{ route('users.index') }}" id="home" data-theme="{{ Themes::show(Auth::user()->id) }}">
                    <i class="fa fa-facebook-square" aria-hidden="true"></i> Faceback
                </a>

                @else      <!-- se non si è loggati -->

                <body class="bg_default">

                    <div id="app">
                        <nav class="navbar fixed-top" style="background-color:white; box-shadow: 1px 2px 8px rgb(160, 153, 153);">
                            <div class="container">

                                <a class="navbar-brand text-primary fw-bold fs-2 " style="font-size: 23px; letter-spacing: 1px; font-family: sans-serif;" href="{{ route('users.index') }}" id="home" data-theme="default">
                                    <i class="fa fa-facebook-square" aria-hidden="true"></i> Faceback
                                </a>


                                @endif

                                @guest              <!-- se non si è loggati -->

                                <ul class="navbar-nav" id="navbarNoAuth">

                                    <!--  menu grandezza normale "register" e "login"   -->
                                    @include('includes.chose_language')  

                                    
                                    <li class="nav-item starting_menu">
                                        <a class="nav-link" href="{{ route('login.view') }}">{{ __('Login') }}</a>
                                    </li>

                                    <li class="nav-item starting_menu">
                                        <a class="nav-link lang" href="{{ route('register') }}" data-section="register" data-article="title">{{ __('Registrati') }}</a>
                                    </li>


                                    <!--  menu hover "register" e "login"   -->
                                    <li class="nav-item menu_starting_hover">
                                        <a class="nav-link dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Acount
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-link" href="{{ route('login.view') }}">{{ __('Login') }}</a>
                                            </li>

                                            <li>
                                                <a class="dropdown-link lang" href="{{ route('register') }}" data-section="register" data-article="title">{{ __('Registrati') }}</a>
                                            </li>
                                        </ul>
                                    </li>


                                </ul>

                                @else      <!-- se si è loggati -->

                            
                                <div class="arrow_files arrow_files_{{ Themes::show() }}">  
                                    <i class="fa-solid fa-arrow-down fa-xl  arrow_image "></i>
                                </div>                       
                          



                                <button class="navbar-toggler me-0 search_{{ Themes::show() }}" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                                    <span class="navbar-toggler-icon"></span>
                                </button>


                                <div class="collapse navbar-collapse" id="navbarMenu">

                                    <ul class="navbar-nav menu_acount_hover ms-auto">
                                        <!-- Authentication Links -->


                                        <div class="menu_acount_row">

                                            <div id="search_user">

                                                <form action="{{ route('user.search') }}" method="POST">
                                                    @csrf
                                                    <?php
                                                    if (url()->current() != 'http://localhost/progetto_facebook/public/users') {
                                                        $url = url()->current();
                                                    } else {
                                                        $url = url()->previous();
                                                    }  ?>
                                                    <input type="text" name="search" placeholder="Cerca utenti..." class="search_{{ Themes::show() }} lang_placeholder" data-section="nav" data-article="find_users">
                                                    <input type="hidden" name="url" value="<?= $url ?>">
                                                    <button type="submit" class="search_{{ Themes::show() }}">
                                                        <img src="{{ asset('img/glass.png') }}">
                                                    </button>
                                                </form>
                                            </div>

                                        </div>


                                        <div class="menu_acount_row">


                                        @include('includes.chose_language')

                                        @include('includes.fake_users')                                   


                                        <li class="nav-item dropdown li_hover li_{{ Themes::show() }} position-relative">
                                            <a id="navbarDropdown" class="nav-link dropdown-toggle fs-5  a_{{ Themes::show() }}" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                                {{ Auth::user()->name }}
                                            </a>

                                            <div class="menu_acount dropdown-menu dropdown-menu-end div_{{ Themes::show() }} position-absolute" aria-labelledby="navbarDropdown">

                                             <!--  "if" menu utenti veri gestito tramite JS  -->

                                                <a class="dropdown-item menu_hidden lang" href="{{ route('editDatos') }}" data-section="nav" data-article="update_datas" data-user="{{ Auth::user()->id }}">
                                                    Modifica dati Acount
                                                </a>

                                                <a class="dropdown-item menu_hidden lang" href="{{ route('avatar') }}" data-section="nav" data-article="update_image" data-user="{{ Auth::user()->id }}">
                                                    Cambia immagine di profilo
                                                </a>

                                                <a class="dropdown-item menu_hidden lang" href="{{ route('editPassword') }}" data-section="nav" data-article="update_password" data-user="{{ Auth::user()->id }}">
                                                    Modifica password
                                                </a>


                                                <a class="dropdown-item menu_hidden position-relative lang" href="#" data-section="nav" data-article="files" id="upload_files" data-user="{{ Auth::user()->id }}">
                                                    Carica files
                                                </a>


                                                <div class="menu_files  div_{{ Themes::show() }}">

                                                    <a class="dropdown-item lang" href="{{ route('images.create') }}" data-section="nav" data-article="images">
                                                        Carica immagine
                                                    </a>

                                                    <a class="dropdown-item lang" href="{{ route('videos.create') }}" data-section="nav" data-article="videos">
                                                        Carica video
                                                    </a>

                                                </div>


                                                <a class="dropdown-item menu_hidden lang" href="{{ route('theme') }}" data-section="nav" data-article="update_theme" data-user="{{ Auth::user()->id }}">
                                                    Cambia tema
                                                </a>

                                               <!-- fine "if" -->


                                                <a class="dropdown-item logout_{{ Themes::show() }}" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                   document.getElementById('logout-form').submit();">
                                                   {{ __('Logout') }}
                                                </a> 

                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                  @csrf
                                                </form>


                                                @if(Auth::user()->id == 1 || Auth::user()->id > 19)
                                                <a class="dropdown-item pt-2 destroy_{{ Themes::show() }} lang" href="{{ route('user.delete', ['id'=>Auth::user()->id]) }}" style="border-top: 1px dashed black;" data-section="nav" data-article="delete_acount">
                                                    Elimina Acount
                                                </a>
                                                @endif
                                            </div>
                                        </li>

                                     



                                        <li>
                                            <a href="{{ route('users.show', ['user' => Auth::user()->id])  }}">
                                                @if(Auth::user()->img == 'user_default.png')
                                                  <img src="{{ asset('img/user_default.png') }}" id="avatar_profile" class="image_hover_{{ Themes::show() }}" data-theme="{{ Themes::show() }}" alt="User_image">
                                                @else
                                                  <img src="{{ route('getAvatar', ['avatar' => Auth::user()->img]) }}" id="avatar_profile" class="image_hover_{{ Themes::show() }}" data-theme="{{ Themes::show() }}" alt="User_image">   
                                                @endif
                                            </a>
                                        </li>



                                        <li id="notifications" class="li_{{ Themes::show() }}" data-theme="{{ Themes::show() }}">
                                            <a href="{{ route('friendships.index') }}">
                                                <i class="fa-sharp fa-solid fa-bell fa-2xl" style="position: relative;"></i>
                                                <span id="notifications_number" class="notification_{{ Themes::show() }}" data-theme="{{ Themes::show() }}"> {{ Friendships::count(Auth::user()->id) }} </span>
                                            </a>
                                        </li>

                                        </div>   

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