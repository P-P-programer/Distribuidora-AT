<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'App' }}</title>
    @vite([
        'resources/css/app.css',
        'resources/js/app.js',
        'resources/js/modules/search.js',
        'resources/js/modules/cart-badge-reset.js',
        'resources/js/modules/cart-buy.js',
        'resources/js/modules/user-management.js',
    ])
</head>
<body class="layout-root">
    <a href="#main-content" class="skip-link">Saltar al contenido</a>
    <header class="app-header" id="appHeader">
        <h1 class="brand">{{ config('app.name') }}</h1>

        <div class="header-actions">
            <nav class="header-nav" aria-label="Principal">
                <a href="{{ url('/contact') }}" class="nav-link">Contacto</a>
                <a href="{{ route('products.index') }}" class="nav-link">Productos</a>
                @auth
                    @if(!Auth::user()->hasRole('usuario'))
                        <button class="btn btn-soft" id="cartBtn" aria-label="Carrito">🛒 <span class="sr-only">Carrito</span></button>
                    @endif
                @endauth

                @guest
                    <a href="{{ route('login') }}" class="btn btn-primary btn-contrast">Inicia sesión para comprar</a>
                @endguest
            </nav>

            <div class="user-menu">
                <button id="userMenuBtn" class="user-btn" aria-haspopup="true" aria-expanded="false">
                    <svg width="22" height="22" viewBox="0 0 24 24" aria-hidden="true" focusable="false" fill="currentColor">
                        <path d="M12 12c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm0 2c-4.41 0-8 2.24-8 5v1h16v-1c0-2.76-3.59-5-8-5z"/>
                    </svg>
                    <span class="sr-only">Usuario</span>
                </button>

                <div id="userMenu" class="dropdown" hidden>
                    @auth
                        <div class="dropdown-header">
                            <div class="avatar">👤</div>
                            <div>
                                <b>{{ Auth::user()->name }}</b>
                                <div class="dropdown-role">Rol: {{ Auth::user()->getRoleNames()->first() ?? 'usuario' }}</div>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>

                        <a href="{{ route('profile.edit') }}" class="dropdown-link">
                            <svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M12 12c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm0 2c-4.41 0-8 2.24-8 5v1h16v-1c0-2.76-3.59-5-8-5z"/></svg>
                            <span>Mi perfil</span>
                        </a>

                        {{-- Inventario: Modificar inventario --}}
                        @if(auth()->check() && in_array(auth()->user()->role, ['admin','superadmin']))
                            <a href="{{ route('inventario.index') }}" class="dropdown-link">
                                <svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M3 3h18v2H3V3m2 4h14l-1.1 6H6.1L5 7m2 10a2 2 0 100 4 2 2 0 000-4m10 0a2 2 0 100 4 2 2 0 000-4z"/></svg>
                                <span>Modificar inventario</span>
                            </a>
                        @endif

                        {{-- Gestionar usuarios --}}
                        @if(auth()->check() && in_array(auth()->user()->role, ['admin','superadmin']))
                            <a href="{{ route('users.index') }}" class="dropdown-link">
                                <svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M16 11c1.66 0 3-1.34 3-3s-1.34-3-3-3s-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 3-1.34 3-3S9.66 5 8 5S5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5C13 14.17 8.33 13 6 13zm8 0c-.29 0-.62.02-.97.05C15.64 13.36 17 14.28 17 15.5V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                                <span>Gestionar usuarios</span>
                            </a>
                        @endif

                        {{-- Analíticas --}}
                        @if(auth()->check() && auth()->user()->role === 'superadmin')
                            <a href="{{ route('analytics.index') }}" class="dropdown-link">
                                <svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M3 13h8V3H3v10m10 8h8v-10h-8v10m0-18v6h8V3h-8Z"/></svg>
                                <span>Analíticas</span>
                            </a>
                        @endif

                        <form method="POST" action="{{ route('logout') }}" class="dropdown-form">
                            @csrf
                            <button type="submit" class="dropdown-link btn-link">
                                <svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M16 13v-2H7V8l-5 4l5 4v-3h9zM20 3h-8v2h8v14h-8v2h8c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z"/></svg>
                                <span>Cerrar sesión</span>
                            </button>
                        </form>
                    @else
                        <div class="dropdown-header">
                            <div class="avatar">👤</div>
                            <div>
                                <b>Invitado</b>
                                <div class="dropdown-role">Opciones</div>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('login') }}" class="dropdown-link">
                            <svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M10 17l5-5l-5-5v10zM4 19h2V5H4v14z"/></svg>
                            <span>Iniciar sesión</span>
                        </a>
                        <a href="{{ route('register') }}" class="dropdown-link">
                            <svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M12 12c2.76 0 5-2.24 5-5s-2.24-5-5-5S7 4.24 7 7s2.24 5 5 5zm0 2c-4.33 0-8 2.17-8 5v1h16v-1c0-2.83-3.67-5-8-5z"/></svg>
                            <span>Crear cuenta</span>
                        </a>
                    @endauth
                </div>
            </div>

            <!-- solo móvil -->
            <button id="hamburger" class="hamburger-mobile" aria-label="Menú" aria-expanded="false" aria-controls="head-menu">☰</button>
        </div>
    </header>

    <!-- Panel desplegable móvil del header -->
    <div id="headMenu" class="head-menu" aria-hidden="true" hidden>
        <nav>
            <a href="{{ url('/contact') }}">
                <svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M21 8V7l-3 2l-3-2v1l3 2l3-2M8 6H2v2h6V6m14 12H2v2h20v-2M2 10v2h12v-2H2m0 4v2h12v-2H2Z"></path></svg>
                Contacto
            </a>
            <a href="{{ route('products.index') }}">
                <svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M3 4h18v2H3V4m0 4h18v2H3V8m0 4h12v2H3v-2m0 4h12v2H3v-2Z"></path></svg>
                Productos
            </a>
            @auth
                @if(!Auth::user()->hasRole('usuario'))
                    <a href="#" id="mobileCart">
                        <svg width="18" height="18" viewBox="0 0 24 24"><path fill="currentColor" d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2s-.9-2-2-2m10 0c-1.1 0-1.99.9-1.99 2S15.9 22 17 22s2-.9 2-2s-.9-2-2-2M7.17 14h9.82c.75 0 1.41-.41 1.75-1.03l3.58-6.49l-1.74-.99L17 11H8.1L5.21 5H2v2h2l3.6 7.59L5.25 17c-.24.36-.25.82-.06 1.2c.2.38.59.62 1.02.62H19v-2H7.42l1.25-2Z"></path></svg>
                        Carrito
                    </a>
                @endif
            @endauth

            @guest
                <a href="{{ route('login') }}">
                    <svg width="18" height="18" viewBox="0 0 24 24"><path fill="currentColor" d="M12 12c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm0 2c-4.41 0-8 2.24-8 5v1h16v-1c0-2.76-3.59-5-8-5z"/></svg>
                    Inicia sesión para comprar
                </a>
            @endguest

            @auth
                <a href="{{ route('dashboard') }}">
                    <svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M3 13h8V3H3v10m0 8h8v-6H3v6m10 0h8v-10h-8v10m0-18v6h8V3h-8Z"/></svg>
                    Inicio
                </a>
            @endauth
        </nav>
    </div>

    <main id="main-content" class="container" tabindex="-1">
        <x-breadcrumb />
        @include('partials.flash')
        @yield('content')
    </main>

    <footer class="site-footer">
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}</p>
    </footer>

    {{-- Contenedor de toasts (también se crea en JS si faltara) --}}
    <div id="toast-root" aria-live="polite" aria-atomic="true"></div>
</body>
</html>
