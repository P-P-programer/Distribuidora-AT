@extends('layouts.app')

@section('title','Usuarios')

@section('content')
<h1 class="users-title">Usuarios</h1>

@if ($errors->any())
  <div class="alert alert-danger" role="alert">
    <ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
  </div>
@endif
@if(session('success'))
  <div class="alert alert-success" role="status">{{ session('success') }}</div>
@endif
@if(session('error'))
  <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
@endif

@php $yo = auth()->user(); @endphp

<div class="card user-create-card">
  <h2>Crear usuario</h2>
  <form id="createUserForm" method="POST" action="{{ route('users.store') }}" class="user-grid-form">
    @csrf
    <div class="user-grid">
      <div>
        <label for="cu_name">Nombre</label>
        <input id="cu_name" name="name" required value="{{ old('name') }}" autocomplete="name">
      </div>
      <div>
        <label for="cu_email">Email</label>
        <input id="cu_email" type="email" name="email" required value="{{ old('email') }}" autocomplete="email">
      </div>
      <div>
        <label for="cu_password">Contraseña</label>
        <input id="cu_password" type="password" name="password" required autocomplete="new-password">
      </div>
      <div>
        <label for="cu_role">Rol</label>
        <select id="cu_role" name="role" required>
          <option value="usuario" @selected(old('role')==='usuario')>Usuario</option>
          <option value="admin" @selected(old('role')==='admin')>Admin</option>
          <option value="superadmin" @selected(old('role')==='superadmin') @disabled($yo->role==='admin')>Superadmin</option>
        </select>
      </div>
    </div>
    <div class="user-actions">
      <button type="button" id="createConfirm" class="btn btn-primary">Crear</button>
    </div>
  </form>
</div>

<div class="users-table-wrapper">
  <table class="table users-table" aria-describedby="usersHelp">
    <caption id="usersHelp" class="sr-only">Listado de usuarios administrables</caption>
    <thead>
      <tr>
        <th scope="col" id="th-id">ID</th>
        <th scope="col" id="th-nombre">Nombre</th>
        <th scope="col" id="th-email">Email</th>
        <th scope="col" id="th-rol">Rol</th>
        <th scope="col" id="th-estado">Estado</th>
        <th scope="col" id="th-acciones">Acciones</th>
      </tr>
    </thead>
    <tbody>
      @forelse($users as $u)
        @php
          $id = (int) $u->id;
        @endphp
        <tr data-user-row>
          <td data-label="ID" headers="th-id">{{ $id }}</td>

          <td data-label="Nombre" headers="th-nombre">
            <form class="inline-edit" method="POST" action="{{ route('users.update',$u) }}">
              @csrf @method('PATCH')
              <label class="sr-only" for="name_{{ $id }}">Nombre</label>
              <input id="name_{{ $id }}" name="name" value="{{ $u->name }}" required autocomplete="name">
          </td>

          <td data-label="Email" headers="th-email">
              <label class="sr-only" for="email_{{ $id }}">Email</label>
              <input id="email_{{ $id }}" type="email" name="email" value="{{ $u->email }}" required autocomplete="email">
          </td>

          <td data-label="Rol" headers="th-rol">
              <label class="sr-only" for="role_{{ $id }}">Rol</label>
              <select id="role_{{ $id }}" name="role" @disabled($yo->role==='admin' && $u->role==='superadmin')}>
                <option value="usuario" @selected($u->role==='usuario')>Usuario</option>
                <option value="admin" @selected($u->role==='admin')>Admin</option>
                <option value="superadmin" @selected($u->role==='superadmin') @disabled($yo->role==='admin')>Superadmin</option>
              </select>
          </td>

          <td data-label="Estado" headers="th-estado">
            <span class="badge {{ $u->estado==='activo'?'badge-active':'badge-inactive' }}">{{ ucfirst($u->estado) }}</span>
          </td>

          <td data-label="Acciones" headers="th-acciones" class="user-row-actions">
              <button type="button" class="btn btn-primary btn-save" data-name="{{ $u->name }}">Guardar</button>
            </form>

            <form method="POST" action="{{ route('users.toggleEstado',$u) }}">
              @csrf @method('PATCH')
              <button type="button"
                class="btn btn-soft btn-toggle"
                data-action="{{ $u->estado==='activo'?'inactivar':'activar' }}"
                data-name="{{ $u->name }}"
                @disabled($yo->role==='admin' && $u->role==='superadmin')>
                {{ $u->estado==='activo'?'Inactivar':'Activar' }}
              </button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="6">Sin usuarios</td></tr>
      @endforelse
    </tbody>
  </table>
</div>

<div id="confirmModal" class="modal-overlay" hidden role="dialog" aria-modal="true" aria-labelledby="confirmTitle" aria-describedby="confirmText">
  <div class="modal-dialog">
    <button type="button" class="modal-close" id="confirmClose" aria-label="Cerrar">×</button>
    <h2 id="confirmTitle">Confirmar acción</h2>
    <p id="confirmText" class="muted"></p>
    <div class="modal-flex-actions">
      <button type="button" class="btn btn-soft" id="confirmCancel">Cancelar</button>
      <button type="button" class="confirm" id="confirmOk">Sí, continuar</button>
    </div>
  </div>
</div>
@endsection