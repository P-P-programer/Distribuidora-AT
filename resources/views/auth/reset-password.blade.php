@extends('layouts.app')

@section('content')
<div class="auth-page">
  <div class="auth-card card-surface">
    <div class="auth-header">
      <h2>Restablecer contraseña</h2>
      <p>Define una nueva contraseña para tu cuenta.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}">
      @csrf
      <input type="hidden" name="token" value="{{ $request->route('token') }}">

      <div class="form-group">
        <label for="email" class="form-label">Correo electrónico</label>
        <input id="email" class="form-control" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
        @error('email') <p class="form-error">{{ $message }}</p> @enderror
      </div>

      <div class="form-group">
        <label for="password" class="form-label">Nueva contraseña</label>
        <input id="password" class="form-control" type="password" name="password" required autocomplete="new-password">
        @error('password') <p class="form-error">{{ $message }}</p> @enderror
      </div>

      <div class="form-group">
        <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
        <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password">
        @error('password_confirmation') <p class="form-error">{{ $message }}</p> @enderror
      </div>

      <div class="form-actions" style="justify-content:flex-end;">
        <button class="btn btn-primary">Restablecer</button>
      </div>
    </form>
  </div>
</div>
@endsection
