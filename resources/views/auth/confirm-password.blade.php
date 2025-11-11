@extends('layouts.app')

@section('content')
<div class="auth-page">
  <div class="auth-card card-surface">
    <div class="auth-header">
      <h2>Confirmar contraseña</h2>
      <p>Área segura. Confirma tu contraseña para continuar.</p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
      @csrf
      <div class="form-group">
        <label for="password" class="form-label">Contraseña</label>
        <input id="password" class="form-control" type="password" name="password" required autocomplete="current-password">
        @error('password') <p class="form-error">{{ $message }}</p> @enderror
      </div>

      <div class="form-actions" style="justify-content:flex-end;">
        <button class="btn btn-primary">Confirmar</button>
      </div>
    </form>
  </div>
</div>
@endsection
