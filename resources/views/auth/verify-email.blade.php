@extends('layouts.app')

@section('content')
<div class="auth-page">
  <div class="auth-card card-surface">
    <div class="auth-header">
      <h2>Verificar correo</h2>
      <p>Confirma tu correo haciendo clic en el enlace que te enviamos.</p>
    </div>

    @if (session('status') == 'verification-link-sent')
      <div class="alert alert-success" role="status">
        <svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="m10 17l-5-5l1.4-1.4l3.6 3.575L17.6 6.6L19 8z"/></svg>
        <p>Se envió un nuevo enlace de verificación a tu correo.</p>
      </div>
    @endif

    <div class="form-actions">
      <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button class="btn btn-primary">Reenviar correo</button>
      </form>

      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="btn btn-soft">Cerrar sesión</button>
      </form>
    </div>
  </div>
</div>
@endsection
