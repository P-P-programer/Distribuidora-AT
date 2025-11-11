@extends('layouts.app')

@section('content')
<div class="dashboard-panel">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
        Dashboard
    </h2>
    <div class="dashboard-actions" style="display:flex;gap:1rem;flex-wrap:wrap;">
        <a href="{{ route('profile.edit') }}" class="btn btn-soft">
            <svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true">
                <path fill="currentColor" d="M12 12c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm0 2c-4.41 0-8 2.24-8 5v1h16v-1c0-2.76-3.59-5-8-5z"/>
            </svg>
            Mi perfil
        </a>
        @if(!Auth::user()->hasRole('usuario'))
            <a href="{{ route('inventario.index') }}" class="btn btn-soft">
                <svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true">
                    <path fill="currentColor" d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2s-.9-2-2-2m10 0c-1.1 0-1.99.9-1.99 2S15.9 22 17 22s2-.9 2-2s-.9-2-2-2M7.17 14h9.82c.75 0 1.41-.41 1.75-1.03l3.58-6.49l-1.74-.99L17 11H8.1L5.21 5H2v2h2l3.6 7.59L5.25 17c-.24.36-.25.82-.06 1.2c.2.38.59.62 1.02.62H19v-2H7.42l1.25-2Z"/>
                </svg>
                Modificar inventario
            </a>
        @endif
        @if(Auth::user()->hasAnyRole(['admin', 'superadmin']))
            <a href="{{ route('users.index') }}" class="btn btn-soft">
                <svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true">
                    <path fill="currentColor" d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5s-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5s-3 1.34-3 3s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05C15.64 13.36 17 14.28 17 15.5V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                </svg>
                Gestionar usuarios
            </a>
        @endif
        @if(Auth::user()->hasRole('superadmin'))
            <a href="{{ route('analytics.index') }}">
                <svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true">
                    <path fill="currentColor" d="M3 13h8V3H3v10m0 8h8v-6H3v6m10 0h8v-10h-8v10m0-18v6h8V3h-8Z"/>
                </svg>
                Analíticas
            </a>
        @endif
    </div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
        <div class="p-6 text-gray-900">
            ¡Bienvenido, <b>{{ Auth::user()->name }}</b>! Has iniciado sesión correctamente.
        </div>
    </div>
</div>
@endsection
