<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Salon Lucie Ostrava') }}</title>

     <!-- Scripts -->
     <script src="{{ asset('js/appl.js') }}"></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}" type="text/css">

    {{-- DateTime picker --}}
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> --}}
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    {{-- <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" /> --}}

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
      <main class="py-4">
        <div class='container'>
          <div class='row justify-content-center'>
            <div class='col-md-8'>
              <div class='card'>
                <div class='card-header'>New Booking</div>
                <div class='card-body justify-content-left'>
                  <form 
                    action={{ action('BookingViewController@postCreate') }} 
                    method='POST'
                  >
                    @csrf

                    @if (\Session::has('success'))
                      <div class="alert alert-success">
                        <p>{{ \Session::get('success') }}</p>
                      </div><br />
                    @endif


                    {{-- Dates --}}
                    <div class="row">
                      <div class="form-group col-md-4">
                        <label for="datepicker">Date</label>
                        <input 
                          id="datepicker" 
                          name="date" 
                          width="276"
                          value={{$date}}
                        />
                      </div>
                    </div>



                    {{-- Treatment  --}}
                    <div class="row">
                      <div class="form-group col-md-8">
                        <label for="treatment">Treatment</label>
                        <select class="form-control" id="treatment" name='treatment'>
                          @foreach ($treatments as $treatment)
                              <option value={{ $treatment->id }}>{{ $treatment->name }}</option>
                          @endforeach

                        </select>
                      </div>
                    </div>

                    {{-- Hidden --}}
                    <input type="hidden" name="timeslot" value={{$timeslot}} />
                    
                    {{-- Submit --}}
                    <div class="row">
                      <div class="col-md-4 d-flex"></div>
                      <div class="form-group col-md-4 d-flex"  style="margin-top:60px">
                        <input 
                          type="submit"
                          class="btn btn-success mx-auto"
                          value="Next"
                        >
                      </div>
                    </div>

                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
      <script>
        $('#datepicker').datepicker({
            uiLibrary: 'bootstrap4'
        });
      </script>

    </div>
  </body>
  </html>
  


            

