<?php

namespace App\Http\Controllers\Api;

use App\Domain\Tareas\Contracts\TareaServicePort;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Domain\Usuarios\Models\Usuario;


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
      'descripcion' => 'required|string',
      'fecha_tarea' => 'nullable|date',
      'categorias_id' => 'nullable|array',
    ]);

    if ($data['fecha_tarea']) {
      $data['fecha_tarea'] = Carbon::parse($data['fecha_tarea'])->format('Y-m-d H:i:s');
    }
   
    $randomUserId = Usuario::inRandomOrder()->first()->id; 
    $data['user_id'] = $randomUserId;

    $tarea = $this->tareasService->createTarea($data);
    return response()->json($tarea,201);
  }

  public function show($id)
  {
    $tarea = $this->tareasService->getTareaByiD($id);
    return response()->json($tarea);
  }

  public function destroy($id)
  {
    $tarea = $this->tareasService->getTareaByiD($id);

    $this->tareasService->deleteTarea($tarea);

    return response()->json(['message' => 'Tarea borrada correctamente']);
  }


  public function markAsCompleted($id)
  {
    $tarea = $this->tareasService->getTareaByiD($id);

      $data = [
        'completada' => true,
        'completada_en' => Carbon::now(), 
      ];

      $this->tareasService->updateTarea($tarea, $data);
      
      return response()->json(['message' => 'Tarea completada correctamente']);
  }





}