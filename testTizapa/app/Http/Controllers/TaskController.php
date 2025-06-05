<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Task::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $task = new Task ();
        $task->project_id = $request->project_id;
        $task->title = $request->title;
        $task->completed = $request->completed;
        $task->due_date = $request->due_date;
        $task->save();

        return response()->json(["error" => "", "message" => "creado correctamente"],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       $data = Task::find($id);

        return response()->json(["error" => false, "data" => $data],200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Task::find($id);

        return response()->json(["error" => false, "data" => $data],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $task = Task::find($id);
        $task->project_id = $request->project_id;
        $task->title = $request->title;
        $task->completed = $request->completed;
        $task->due_date = $request->due_date;
        $task->save();

        return response()->json(["error" => "", "message" => "Modificado correctamente"],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Task::find($id)->delete();
        return response()->json(["error" => "", "message" => "Eliminado correctamente"],200);
    }
}
