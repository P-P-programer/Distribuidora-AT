@extends('layouts.app')

@section('content')
<div class="auth-page">
  <div class="auth-card card-surface">
    <div class="auth-header">
      <h2>Recuperar contraseña</h2>
      <p>Ingresa tu correo y te enviaremos un enlace para restablecer tu contraseña.</p>
    </div>

    @if (session('status'))
      <div class="alert alert-success" role="status">
        <svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="m10 17l-5-5l1.4-1.4l3.6 3.575L17.6 6.6L19 8z"/></svg>
        <p>{{ session('status') }}</p>
      </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
      @csrf
      <div class="form-group">
        <label for="email" class="form-label">Correo electrónico</label>
        <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus>
        @error('email') <p class="form-error">{{ $message }}</p> @enderror
      </div>

      <div class="form-actions" style="justify-content:flex-end;">
        <button class="btn btn-primary">Enviar enlace</button>
      </div>
    </form>
  </div>
</div>
@endsection
