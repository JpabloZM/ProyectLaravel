<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sistema de Productos') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    Sistema de Productos
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" 
                               href="{{ url('/') }}">
                                <i class="fas fa-home me-1"></i>{{ __('general.home') }}
                            </a>
                        </li>
                        
                        <!-- Sección Tienda -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->routeIs('shop.*') ? 'active' : '' }}" 
                               href="#" id="tiendaDropdown" role="button" 
                               data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-store me-1"></i>{{ __('general.shop') }}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="tiendaDropdown">
                                <li>
                                    <a class="dropdown-item {{ request()->routeIs('shop.products.*') ? 'active' : '' }}" 
                                       href="{{ route('shop.products.index') }}">
                                        <i class="fas fa-box me-1"></i>{{ __('shop.products') }}
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item {{ request()->routeIs('shop.categories.*') ? 'active' : '' }}" 
                                       href="{{ route('shop.categories.index') }}">
                                        <i class="fas fa-tags me-1"></i>{{ __('shop.categories') }}
                                    </a>
                                </li>
                            </ul>
                        </li>
                        
                        <!-- Sección Blog -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->routeIs('blog.*') ? 'active' : '' }}" 
                               href="#" id="blogDropdown" role="button" 
                               data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-blog me-1"></i>{{ __('general.blog') }}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="blogDropdown">
                                <li>
                                    <a class="dropdown-item {{ request()->routeIs('blog.articles.*') ? 'active' : '' }}" 
                                       href="{{ route('blog.articles.index') }}">
                                        <i class="fas fa-newspaper me-1"></i>{{ __('blog.articles') }}
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item {{ request()->routeIs('blog.categories.*') ? 'active' : '' }}" 
                                       href="{{ route('blog.categories.index') }}">
                                        <i class="fas fa-folder me-1"></i>{{ __('blog.categories') }}
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>

                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('general.login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('general.register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        {{ __('general.logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
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
            @yield('content')
        </main>
    </div>
</body>
</html> 