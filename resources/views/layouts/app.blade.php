<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    {{-- Fontawesome CDN --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .dropdown-menu {
            margin-top: 0;
        }
        .dropdown-item:hover {
            background-color: #343a40;
        }
        .dropdown-menu.show {
            display: block;
        }
        
        .dropdown-toggle::after {
            display: inline-block;
            margin-left: 0.255em;
            vertical-align: 0.255em;
            content: "";
            border-top: 0.3em solid;
            border-right: 0.3em solid transparent;
            border-bottom: 0;
            border-left: 0.3em solid transparent;
        }
        
        .btn-link {
            text-decoration: none;
            color: rgba(255,255,255,.55);
        }
        
        .btn-link:hover {
            color: rgba(255,255,255,.75);
        }
    </style>
</head>
<body class="bg-dark">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                
                <!-- Tambahkan tombol hamburger untuk mobile -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" 
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        @auth
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('products.index') }}">Products</a>
                            </li>
                        @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif

                            @if (Route::has('password.request'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('password.request') }}">{{ __('Forgot Password?') }}</a>
                                </li>
                            @endif
                        @else
                            @if (!auth()->user()->hasVerifiedEmail())
                                <li class="nav-item">
                                    <a class="nav-link text-warning" href="{{ route('verification.notice') }}">
                                        <i class="fa fa-exclamation-triangle"></i> Verify Email
                                    </a>
                                </li>
                            @endif
                            <li class="nav-item dropdown">
                                <button id="navbarDropdown" class="nav-link dropdown-toggle btn btn-link" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                </button>

                                <ul class="dropdown-menu dropdown-menu-end bg-dark" aria-labelledby="navbarDropdown">
                                    <li>
                                        <a class="dropdown-item text-light" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                            <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @auth
                @if (!auth()->user()->hasVerifiedEmail())
                    <div class="alert alert-warning text-center" role="alert">
                        <i class="fa fa-exclamation-triangle"></i>
                        Please <a class="alert-link" href="{{ route('verification.notice') }}">verify your email</a> to access all features.
                    </div>
                @endif
            @endauth

            @yield('content') <!-- Tambahkan baris ini di sini -->
        </main>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}" defer></script>
</body>
</html>