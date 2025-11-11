@extends('layouts.app')

@section('content')
<div class="auth-page">
  <div class="auth-card card-surface">
    <div class="auth-header">
      <h2>Iniciar sesión</h2>
      <p>Bienvenido de nuevo. Ingresa tus credenciales para continuar.</p>
    </div>

    @if (session('status'))
      <div class="alert alert-info" role="status">
        <svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M11 17h2v-6h-2v6Zm1-8q.425 0 .713-.288T13 8q0-.425-.288-.712T12 7q-.425 0-.712.288T11 8q0 .425.288.713T12 9Z"/></svg>
        <p>{{ session('status') }}</p>
      </div>
    @endif

    <form method="POST" action="{{ route('login') }}" novalidate>
      @csrf

      <div class="form-group">
        <label for="email" class="form-label">Correo electrónico</label>
        <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
        @error('email') <p class="form-error">{{ $message }}</p> @enderror
      </div>

      <div class="form-group">
        <label for="password" class="form-label">Contraseña</label>
        <input id="password" class="form-control" type="password" name="password" required autocomplete="current-password">
        @error('password') <p class="form-error">{{ $message }}</p> @enderror
      </div>

      <label for="remember_me" class="form-check">
        <input id="remember_me" type="checkbox" name="remember">
        <span>Recuérdame</span>
      </label>

      <div class="form-actions">
        @if (Route::has('password.request'))
          <a href="{{ route('password.request') }}" class="link">¿Olvidaste tu contraseña?</a>
        @endif
        <button class="btn btn-primary">Entrar</button>
      </div>

      <div style="margin-top:.9rem; font-size:.85rem;">
        ¿No tienes cuenta?
        <a href="{{ route('register') }}" class="link" style="font-weight:600;">Crear cuenta</a>
      </div>
    </form>
  </div>
</div>
@endsection
