<?php

namespace App\Domain\Categorias\Services;

use App\Domain\Categorias\Contracts\CategoriaServicePort;
use App\Domain\Categorias\Contracts\CategoriaRepositoryPort; 
use App\Domain\Categorias\Models\Categoria;

class CategoriaService implements CategoriaServicePort
{
    protected $categoriaRepository;

    public function __construct(CategoriaRepositoryPort $categoriaRepository)
    {
        $this->categoriaRepository = $categoriaRepository;
    }

    public function createCategoria(array $data)
    {
        return Categoria::create($data);
    }

    public function getAllCategorias()
    {
        return $this->categoriaRepository->getAllCategorias();
    }
}
