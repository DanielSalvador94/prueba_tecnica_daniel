<?php

namespace App\Domain\Tareas\Services;

use App\Domain\Tareas\Contracts\TareaServicePort;
use App\Domain\Tareas\Models\Tarea;


class TareaService implements TareaServicePort

{
  public function getAllTareas()

  {
    return Tarea::with('user','categorias')->get();
  }

  public function createTarea(array $data)

  {
    $categorias = isset($data['categorias_id']) ? $data['categorias_id'] : [];
      unset($data['categorias_id']);
      $tarea = Tarea::create($data);

      if (!empty($categorias)) {
        $tarea->categorias()->attach($categorias);
      }

    return $tarea;
  }

  public function getTareaByiD($id)

  {
    return Tarea::with('user', 'categorias')->findOrFail($id);
  }

  public function updateTarea(Tarea $tarea, array $data)
  {
    $tarea->update($data);
      if (isset($data['categorias'])) {
        $tarea->categorias()->sync($data['categorias']);
      }
      return $tarea;
  }

  public function deleteTarea(Tarea $tarea)
  {
    $tarea->delete();
  }
}