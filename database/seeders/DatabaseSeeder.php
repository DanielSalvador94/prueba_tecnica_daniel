<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\CategoriaSeeder;
use Database\Seeders\UsuarioSeeder;


class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(CategoriaSeeder::class);
        $this->call(UsuarioSeeder::class);
    }
}
