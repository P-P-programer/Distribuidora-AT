<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name') }}</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="layout-root">
    <header class="app-header" id="appHeader">
        <h1 class="brand">{{ config('app.name') }}</h1>

        <div class="header-actions">
            <nav class="header-nav" aria-label="Principal">
                <a href="{{ url('/contact') }}" class="nav-link">Contacto</a>
                <a href="{{ route('welcome') }}" class="nav-link">Productos</a>
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
                        <a href="{{ route('profile.edit') }}">Mi perfil</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit">Cerrar sesión</button>
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
                        <a href="{{ route('login') }}">Iniciar sesión</a>
                        <a href="{{ route('register') }}">Crear cuenta</a>
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
            <a href="{{ route('welcome') }}">
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

    @auth
        @if(!Auth::user()->hasRole('usuario'))
            <a href="{{ route('inventario.index') }}">
                <svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M3 13h8V3H3v10m0 8h8v-6H3v6m10 0h8v-10h-8v10m0-18v6h8V3h-8Z"/></svg>
                Gestionar stock
            </a>
        @endif

        @if(Auth::user()->hasAnyRole(['admin', 'superadmin']))
            <a href="{{ route('users.index') }}">
                <svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M12 12c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm0 2c-4.41 0-8 2.24-8 5v1h16v-1c0-2.76-3.59-5-8-5z"/></svg>
                Gestionar usuarios
            </a>
        @endif

        @can('role', 'superadmin')
            <a href="{{ route('analytics.index') }}">
                <svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M3 13h8V3H3v10m0 8h8v-6H3v6m10 0h8v-10h-8v10m0-18v6h8V3h-8Z"/></svg>
                Analíticas
            </a>
        @endcan
    @endauth

    <main class="container">
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
