<?php

namespace App\Domain\Usuarios\Services;

use App\Domain\Usuarios\Contracts\UsuarioServicePort;
use App\Domain\Usuarios\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UsuarioService implements UsuarioServicePort
{
    public function createUsuario(array $data)
    {
        return Usuario::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
