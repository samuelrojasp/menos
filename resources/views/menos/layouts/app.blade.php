<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://kit.fontawesome.com/0e218de214.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="build/css/intlTelInput.css">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <h1>
                    <a class="d-none d-sm-block navbar-brand" href="{{ url('/') }}">
                        {{ strtoupper(config('app.name', 'Laravel')) }}
                    </a>
                    <button class="navbar-toggler position-absolute  collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                        M
                    </button>
                </h1>
                
                <div class="d-md-none">
                    <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">salir</a>
                    
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>


                <!--button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="true" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button-->

                <div class="navbar-collapse d-none d-sm-block" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            
                                <span class="d-none d-sm-block">{{ Auth::user()->name }}</span>
                            
                            <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">salir</a>
                            
                        </li>    
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container-fluid">
        
            <div class="row">
            @include('menos.componentes.menu')        

                <div class="col-md-9">
                    <main class="py-4">
                        @yield('content')
                    </main>
                </div>
            </div>
        </div>
    </div>
    <script src="build/js/intlTelInput-jquery.min.js"></script>
    <script>
        $("#telephone").intlTelInput({
        });
    </script>
</body>
</html>
