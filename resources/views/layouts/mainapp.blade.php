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
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poiret+One&display=swap" rel="stylesheet">

    <!-- Styles -->
    {{-- <link href="{{ asset('sass/app.css') }}" rel="stylesheet" type="text/css"> --}}
    <link rel="stylesheet" href="{{ mix('/css/mainapp.css') }}" type="text/css">
    @yield('head')
</head>
<body>
    <div class="app" id="app">

        <main>
        {{-- <main class="py-4"> --}}
            @yield('content')
        </main>
    </div>

</body>
</html>
