<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller {

    public function index() {
        return response()->json(Task::all());
    }

    public function store(Request $request) {
        // Validação simples para garantir que o nome foi enviado
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
    
        $task = new Task();
        $task->name = $request->name;
       // $task->completed = 0; // Define como não concluído por padrão
        $task->save();
    
        return response()->json($task, 201); // Retorna a tarefa criada com código HTTP 201 (Criado)
    }
    

    public function show(Task $task) {
        return response()->json($task);
    }

    public function update(Request $request, Task $task)
{
    // Validação dos dados recebidos
    $request->validate([
        'name' => 'sometimes|required|string|max:255',
        'completed' => 'sometimes|boolean',
    ]);

    // Atualiza os valores da tarefa se foram passados
    if ($request->has('name')) {
        $task->name = $request->input('name');
    }
    if ($request->has('completed')) {
        $task->completed = $request->input('completed');
    }

    $task->save(); // Salva a atualização no banco

    return response()->json([
        'message' => 'Tarefa atualizada com sucesso!',
        'task' => $task
    ], 200);
}

public function toggleCompleted(Request $request, Task $task)
{
    // Obtém o valor enviado e converte para booleano
    $completed = filter_var($request->query('completed'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);

    // Verifica se o parâmetro foi passado corretamente
    if ($completed !== null) {
        $task->completed = $completed;
        $task->save();
    }

    return response()->json($task);
}

    public function destroy($id) {
        $task = Task::find($id);
        if ($task) {
            $task->delete();
            return response()->json(['result' => 'Deu certo'], 204);
        } else {
            return response()->json(['result' => 'Não deu certo'], 404);
        }
    }
}