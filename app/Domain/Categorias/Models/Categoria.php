<?php

namespace App\Domain\Categorias\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $fillable = ['nombre'];

    public function tareas()
    {
        return $this->belongsToMany(Tarea::class);
    }
}