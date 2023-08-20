<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Domain\Categorias\Contracts\CategoriaServicePort;

class CategoriaSeeder extends Seeder
{
    protected $categoriaService;

    public function __construct(CategoriaServicePort $categoriaService)
    {
        $this->categoriaService = $categoriaService;
    }

    public function run()
    {
        $categorias = [
            ['nombre' => 'PHP'],
            ['nombre' => 'JS'],
            ['nombre' => 'CSS'],
	        ['nombre' => 'Otros'],
        ];

        foreach ($categorias as $categoria) {
            $this->categoriaService->createCategoria($categoria);
        }
    }
}