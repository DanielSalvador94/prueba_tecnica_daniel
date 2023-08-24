<?php

namespace App\Providers;

use App\Domain\Usuarios\Contracts\UsuarioServicePort;
use App\Domain\Usuarios\Services\UsuarioService;
use Illuminate\Support\ServiceProvider;
use App\Domain\Tareas\Contracts\TareaServicePort;
use App\Domain\Tareas\Services\TareaService;
use App\Domain\Categorias\Contracts\CategoriaServicePort;
use App\Domain\Categorias\Services\CategoriaService;
use App\Domain\Categorias\Contracts\CategoriaRepositoryPort; 
use App\Infrastructure\Repositories\EloquentCategoriaRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TareaServicePort::class, TareaService::class);
        $this->app->bind(CategoriaServicePort::class, CategoriaService::class);
        $this->app->bind(CategoriaRepositoryPort::class, EloquentCategoriaRepository::class); 
        $this->app->bind(UsuarioServicePort::class, UsuarioService::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
