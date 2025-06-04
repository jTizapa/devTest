<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectsStoreRequest;
use App\Http\Requests\ProjectsUpdateRequest;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Project::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectsStoreRequest $request)
    {
        $project = new Project ();
        $project->name = $request->name;
        $project->description = $request->description;
        $project->status = $request->status;
        $project->save();

        return response()->json(["error" => "", "message" => "creado correctamente"],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       $data = Project::find($id);

        return response()->json(["error" => false, "data" => $data],200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Project::find($id);

        return response()->json(["error" => false, "data" => $data],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProjectsUpdateRequest $request, string $id)
    {
        $project = Project::find($id);
        $project->name = $request->name;
        $project->description = $request->description;
        $project->status = $request->status ;
        $project->save();

        return response()->json(["error" => "", "message" => "Modificado correctamente"],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Project::find($id)->delete();
        return response()->json(["error" => "", "message" => "Eliminado correctamente"],200);
    }
}
