<?php

namespace App\Http\Controllers\Api;

use App\Domain\Tareas\Contracts\TareaServicePort;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TareaController extends Controller

{
  private $tareasService;

  public function __construct(TareaServicePort $tareaService)
  {
    $this->tareasService = $tareaService;
  }
  
  public function index()
  {
    $tareas = $this->tareasService->getAllTareas();
    return response()->json($tareas);
  }

  public function store(Request $request)
  {
    $data = $request->validate([
      'nombre' => 'required|string',
      'descripcion' => 'string',
      'completada' => 'boolean',
      'fecha_tarea' => 'nullable|date',
      'user_id' => 'required|exists:users,id',
      'categorias' => 'array',
      'categories.*' => 'integer|exists:categories,id'
    ]);

    $tarea = $this->tareasService->createTarea($data);

    return response()->json($tarea,201);
  }

  public function show($id)
  {
    $tarea = $this->tareasService->getTareaByiD($id);
    return response()->json($tarea);
  }

  public function update(Request $request, $id)
  {
    $tarea = $this->tareasService->getTareaByiD($id);

    $data = $request->validate([
      'nombre' => 'required|string',
      'descripcion' => 'string',
      'completada' => 'boolean',
      'fecha_tarea' => 'nullable|date',
      'user_id' => 'required|exists:users,id',
      'categories' => 'array',
      'categories.*' => 'integer|exists:categories,id'
    ]);

    $updatedTarea = $this->tareasService->updateTarea($tarea,$data);

    return response()->json($updatedTarea);
  }

  public function destroy($id)
  {
    $tarea = $this->tareasService->getTareaByiD($id);

    $this->tareasService->deleteTarea($tarea);

    return response()->json(['message' => 'Tarea borrada correctamente']);
  }





}