<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    public function store(Request $request)
    {
    $request->validate([
    'name' => 'required|max:255',
    'description' => 'nullable'
    ]);

    $project = Project::create($request->all());

    return response()->json([
    'message'=>'Project created',
    'data'=>$project
    ],201);
    }

    public function index()
    {
        $projects = Project::paginate(3);

    return response()->json($projects);
    }

    public function show($id)
    {
    return Project::findOrFail($id);
    }

    public function destroy($id)
    {
    $project = Project::find($id);

    if(!$project){
    return response()->json([
    'error'=>'Project not found'
    ],404);
    }

    $project->delete();

    return response()->json([
    'message'=>'Project deleted'
    ]);
    }
}




