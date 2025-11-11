<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name','email','password','role','estado'];

    // Compatibilidad con vistas
    public function hasRole(string $role): bool { return $this->role === $role; }
    public function hasAnyRole($roles): bool {
        if (is_string($roles)) $roles = explode('|', $roles);
        return in_array($this->role, $roles, true);
    }
    public function getRoleNames() { return collect([$this->role]); }
}
