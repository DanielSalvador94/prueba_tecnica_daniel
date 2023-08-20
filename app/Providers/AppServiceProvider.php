<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Tareas\Contracts\TareaServicePort;
use App\Domain\Tareas\Services\TareaService;
use App\Domain\Categorias\Contracts\CategoriaServicePort;
use App\Domain\Categorias\Services\CategoriaService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TareaServicePort::class, TareaService::class);
        $this->app->bind(CategoriaServicePort::class, CategoriaService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
