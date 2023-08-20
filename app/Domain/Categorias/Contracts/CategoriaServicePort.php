<?php

namespace App\Domain\Categorias\Contracts;

Use App\Domain\Categorias\Models\Categoria;

interface CategoriaServicePort

{
  public function createCategoria(array $data);
}