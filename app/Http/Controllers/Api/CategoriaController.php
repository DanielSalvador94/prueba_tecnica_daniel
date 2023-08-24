<?php

namespace App\Http\Controllers\Api;

use App\Domain\Categorias\Contracts\CategoriaRepositoryPort;
use App\Http\Controllers\Controller;

class CategoriaController extends Controller
{
    protected $categoriaRepository;

    public function __construct(CategoriaRepositoryPort $categoriaRepository)
    {
        $this->categoriaRepository = $categoriaRepository;
    }

    public function index()
    {
        $categorias = $this->categoriaRepository->getAllCategorias();
        return response()->json($categorias);
    }
}



