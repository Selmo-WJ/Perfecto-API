<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller {

    public function index() {
        return response()->json(Task::all());
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
    
        $task = new Task();
        $task->name = $request->name;
        $task->save();
    
        return response()->json($task, 201); 
    }
    

    public function show(Task $task) {
        return response()->json($task);
    }

    public function update(Request $request, Task $task)
{
    $request->validate([
        'name' => 'sometimes|required|string|max:255',
        'completed' => 'sometimes|boolean',
    ]);

    if ($request->has('name')) {
        $task->name = $request->input('name');
    }
    if ($request->has('completed')) {
        $task->completed = $request->input('completed');
    }

    $task->save();

    return response()->json([
        'message' => 'Tarefa atualizada com sucesso!',
        'task' => $task
    ], 200);
}

public function toggleCompleted(Request $request, Task $task)
{
    $completed = filter_var($request->query('completed'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);

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