@extends('layouts.app')

@section('content')
<div class="auth-page">
  <div class="auth-card card-surface">
    <div class="auth-header">
      <h2>Crear cuenta</h2>
      <p>Completa tus datos para registrarte.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" novalidate>
      @csrf

      <div class="form-group">
        <label for="name" class="form-label">Nombre</label>
        <input id="name" class="form-control" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
        @error('name') <p class="form-error">{{ $message }}</p> @enderror
      </div>

      <div class="form-group">
        <label for="email" class="form-label">Correo electrónico</label>
        <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autocomplete="username">
        @error('email') <p class="form-error">{{ $message }}</p> @enderror
      </div>

      <div class="form-group">
        <label for="password" class="form-label">Contraseña</label>
        <input id="password" class="form-control" type="password" name="password" required autocomplete="new-password">
        @error('password') <p class="form-error">{{ $message }}</p> @enderror
      </div>

      <div class="form-group">
        <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
        <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password">
        @error('password_confirmation') <p class="form-error">{{ $message }}</p> @enderror
      </div>

      <div class="form-actions" style="justify-content:flex-end;">
        <a href="{{ route('login') }}" class="link">¿Ya tienes cuenta?</a>
        <button class="btn btn-primary">Registrar</button>
      </div>
    </form>
  </div>
</div>
@endsection
