<?php

namespace App\Domain\Tareas\Contracts;

Use App\Domain\Tareas\Models\Tarea;

interface TareaServicePort

{
  public function getAllTareas();
  public function createTarea(array $data);
  public function getTareaByiD($id);
  public function updateTarea(Tarea $tarea, array $data);
  public function deleteTarea(Tarea $tarea);

}