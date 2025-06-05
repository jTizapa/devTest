<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectsStoreRequest;
use App\Http\Requests\ProjectsUpdateRequest;
use App\Models\Project;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = auth()->id();
        $data =  Project::where('user_id', $user_id)
            ->get();
         return response()->json(["error" => false, "data" => $data],200);
    }//


    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectsStoreRequest $request)
    {
        $project = new Project ();
        $project->name = $request->name;
        $project->description = $request->description;
        $project->status = $request->status;
        $project->user_id = auth()->id();
        $project->save();

        return response()->json(["error" => false, "message" => "creado correctamente"],200);
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

        return response()->json(["error" => false, "message" => "Modificado correctamente"],200);
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
