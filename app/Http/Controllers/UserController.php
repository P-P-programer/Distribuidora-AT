<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController
{
    public function index()
    {
        $auth = auth()->user();
        if (!$auth || !in_array($auth->role, ['admin','superadmin'], true)) abort(403);

        $users = User::select('id','name','email','role','estado')->orderBy('id')->get();
        return view('users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $auth = auth()->user();
        if (!$auth || !in_array($auth->role, ['admin','superadmin'], true)) abort(403);

        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users,email'],
            'password' => ['required','string','min:6'],
            'role' => ['required', Rule::in(['usuario','admin','superadmin'])],
        ]);

        // admin no puede crear superadmin
        if ($auth->role === 'admin' && $data['role'] === 'superadmin') {
            return back()->with('error','No puedes crear un superadmin.')->withInput();
        }

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => $data['role'],
            'estado' => 'activo',
        ]);

        return back()->with('success','Usuario creado correctamente');
    }

    public function update(Request $request, User $user)
    {
        $auth = auth()->user();
        if (!$auth || !in_array($auth->role, ['admin','superadmin'], true)) abort(403);

        // admin no puede editar superadmin ni convertir a superadmin
        if ($auth->role === 'admin' && ($user->role === 'superadmin' || $request->role === 'superadmin')) {
            return back()->with('error','No puedes modificar a un superadmin.');
        }

        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255', Rule::unique('users','email')->ignore($user->id)],
            'role' => ['required', Rule::in(['usuario','admin','superadmin'])],
            'password' => ['nullable','string','min:6'],
        ]);

        $payload = [
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'],
        ];
        if (!empty($data['password'])) {
            $payload['password'] = bcrypt($data['password']);
        }

        $user->update($payload);

        return back()->with('success','Usuario actualizado');
    }

    public function toggleEstado(User $user)
    {
        $auth = auth()->user();
        if (!$auth || !in_array($auth->role, ['admin','superadmin'], true)) abort(403);

        if ($auth->role === 'admin' && $user->role === 'superadmin') {
            return back()->with('error','No puedes inactivar/activar a un superadmin.');
        }

        $user->estado = $user->estado === 'activo' ? 'inactivo' : 'activo';
        $user->save();

        return back()->with('success', "Usuario {$user->estado}");
    }
}