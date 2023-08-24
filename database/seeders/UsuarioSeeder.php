<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Domain\Usuarios\Contracts\UsuarioServicePort;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class UsuarioSeeder extends Seeder
{
    protected $usuarioService;

    public function __construct(UsuarioServicePort $usuarioService)
    {
        $this->usuarioService = $usuarioService;
    }

    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            $this->usuarioService->createUsuario([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => 'password', // You can change this or use Faker for passwords
            ]);
        }
    }
}