<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="index,follow">
    <meta name="googlebot" content="index,follow">
    <meta name="description" content="Salon Lucie | Kadeřnický salón v centru Ostravy. Dámské a pánské kadeřnictví, pedikúra.">
    <meta name="keywords" content="Salón Lucie, Lucie Baránková, kadeřnictví, holičství, dámské, pánské, pedikúra, Ostrava, centrum">
    <meta name="author" content="Kamil Drozd">
    <meta name="geo.placename" content="Ostrava, Velká 12">
    <meta name="geo.region" content="Moravskoslezský kraj">
    <meta name="geo.region" content="Moravskoslezský kraj">
    <meta property="og.title" content="Salón Lucie | Kadeřnický salón v centru Ostravy. Dámské a pánské kadeřnictví, pedikúra.">
    <meta property="og.description" content="Salón Lucie | Kadeřnický salón v centru Ostravy. Dámské a pánské kadeřnictví, pedikúra.">
    <meta property="og.site_name" content="Salón Lucie">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Salon Lucie Ostrava') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/appl.js') }}" defer></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-160286773-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-160286773-1');
    </script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poiret+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@700&display=swap" rel="stylesheet">
    <!-- Styles -->
    {{-- <link href="{{ asset('sass/app.css') }}" rel="stylesheet" type="text/css"> --}}
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}" type="text/css">
    @yield('head')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Salon Lucie Ostrava') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('saloon')}}#services">{{ __('Služby') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('saloon')}}#findmehere">{{ __('Kde jsme') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('saloon')}}#contact">{{ __('Kontakt') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            @can('admin')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ action('StylistController@index') }}">{{ __('Stylists') }}</a>
                                </li>
                            @endcan
                            @if (Auth::user()->stylist !== null)
                                    <a class="nav-link" href="{{ route('treatmentindex') }}">{{ __('Treatments') }}</a>
                                    <a class="nav-link" href="{{ route('home') }}">{{ __('Home') }}</a>

                            @endif
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->first_name }} {{ Auth::user()->last_name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <main>
        {{-- <main class="py-4"> --}}
            @yield('content')
        </main>
    </div>
    <footer id="sticky-footer" class="py-2 bg-dark text-white-50">
        <div class="container text-center">
          <small>&copy; Created by <a href="http://www.drozd.run" target="_blank">Kamil Drozd</a> {{date('Y')}}</small>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>
