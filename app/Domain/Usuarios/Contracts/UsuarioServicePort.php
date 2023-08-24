<?php

namespace App\Domain\Usuarios\Contracts;

interface UsuarioServicePort

{
  public function createUsuario(array $data);
}