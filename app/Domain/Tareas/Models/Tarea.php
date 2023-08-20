<?php

namespace App\Domain\Tareas\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tarea extends Model
{
  use SoftDeletes;

  protected $table = 'tareas';
  protected $fillable = ['nombre', 'descripcion', 'completada', 'completada_en', 'fecha_tarea', 'user_id'];
  protected $dates = ['completada_en', 'fecha_tarea'];


  public function user()
  {
    return $this->belongsTo(User::class, 'user_id');
  }

  public function categorias()
  {
    return $this->belongsToMany(Categoria::class);
  }
}