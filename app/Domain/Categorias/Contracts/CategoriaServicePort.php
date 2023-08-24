<?php

namespace App\Domain\Categorias\Contracts;

interface CategoriaServicePort

{
  public function createCategoria(array $data);
}