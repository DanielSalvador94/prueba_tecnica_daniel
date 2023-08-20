<?php

namespace App\Domain\Tareas\Services;

use App\Domain\Tareas\Contracts\TareaServicePort;
use App\Domain\Tareas\Models\Tarea;


class TareaService implements TareaServicePort

{
  public function getAllTareas()

  {
    return Tarea::with('user','categoriues')->get();
  }

  public function createTarea(array $data)

  {
    $tarea = Tarea::create($data);

    if (isset($data['categorias'])) {
        $tarea->categorias()->sync($data['categorias']);
    }

    return $tarea;
  }

  public function getTareaByiD($id)

  {
    return Tarea::findOrFail($id);
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