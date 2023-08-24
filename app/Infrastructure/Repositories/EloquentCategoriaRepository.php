<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Categorias\Contracts\CategoriaRepositoryPort;
use App\Domain\Categorias\Models\Categoria;

class EloquentCategoriaRepository implements CategoriaRepositoryPort
{
    public function getAllCategorias()
    {
        return Categoria::select('id', 'nombre')->get();
    }

}