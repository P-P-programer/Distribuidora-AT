<?php

namespace App\Services;

class Breadcrumbs
{
    protected $routes = [
        'dashboard' => ['Inicio', 'Dashboard'],
        'products.index' => ['Inicio', 'Dashboard', 'Productos'],
        'inventario.index' => ['Inicio', 'Dashboard', 'Inventario'],
        'users.index' => ['Inicio', 'Dashboard', 'Usuarios'],
        'analytics.index' => ['Inicio', 'Dashboard', 'Analíticas'],
        'cart.index' => ['Inicio', 'Dashboard', 'Carrito'],
        'profile.edit' => ['Inicio', 'Dashboard', 'Perfil'],
    ];

    public function generate(?string $routeName): array
    {
        // Si no hay usuario logueado, solo "Inicio"
        if (!auth()->check()) {
            return [
                ['label' => 'Inicio', 'url' => route('home')],
            ];
        }

        // Si no hay ruta o no está mapeada, inicio + dashboard
        if (!$routeName || !isset($this->routes[$routeName])) {
            return [
                ['label' => 'Inicio', 'url' => route('home')],
                ['label' => 'Dashboard', 'url' => route('dashboard')],
            ];
        }

        $labels = $this->routes[$routeName];
        $crumbs = [];

        foreach ($labels as $i => $label) {
            $url = null;

            // Primer elemento siempre es "Inicio"
            if ($i === 0) {
                $url = route('home');
            }
            // Segundo elemento es "Dashboard" si está logueado
            elseif ($i === 1 && $label === 'Dashboard') {
                $url = route('dashboard');
            }
            // Último elemento es la página actual (sin link)
            elseif ($i === count($labels) - 1) {
                $url = null;
            }

            $crumbs[] = ['label' => $label, 'url' => $url];
        }

        return $crumbs;
    }
}