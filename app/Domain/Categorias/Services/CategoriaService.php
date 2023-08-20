<?php

namespace App\Domain\Categorias\Services;

use App\Domain\Categorias\Contracts\CategoriaServicePort;
use App\Domain\Categorias\Models\Categoria;


class CategoriaService implements CategoriaServicePort

{
  public function createCategoria(array $data)
    {
      return Categoria::create($data);
    }
}