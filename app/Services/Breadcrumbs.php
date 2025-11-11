<?php

namespace App\Services;

class Breadcrumbs
{
    public function generate(?string $routeName): array
    {
        if (!$routeName) return [];

        $map = [
            'welcome' => ['Inicio'],
            'contact' => ['Inicio' => route('welcome'), 'Contacto'],
            'login' => ['Inicio' => route('welcome'), 'Iniciar sesión'],
            'register' => ['Inicio' => route('welcome'), 'Crear cuenta'],
            'password.request' => ['Inicio' => route('welcome'), 'Recuperar contraseña'],
            'password.reset' => ['Inicio' => route('welcome'), 'Restablecer contraseña'],
            'verification.notice' => ['Inicio' => route('welcome'), 'Verificar correo'],
            'profile.edit' => ['Inicio' => route('welcome'), 'Perfil'],
            'dashboard' => ['Inicio' => route('welcome'), 'Panel'],
        ];

        $trail = $map[$routeName] ?? [];
        $out = [];
        foreach ($trail as $k => $v) {
            if (is_int($k)) $out[] = ['label' => $v, 'url' => null];
            else $out[] = ['label' => $k, 'url' => $v];
        }
        return $out;
    }
}