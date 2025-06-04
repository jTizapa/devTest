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
        $taks = new Task ();
        $taks->name = $request->name;
        $taks->description = $request->description;
        $taks->status = $request->status;
        $taks->save();

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
        $Task = Task::find($id);
        $Task->name = $request->name;
        $Task->description = $request->description;
        $Task->status = $request->status ;
        $Task->save();

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
