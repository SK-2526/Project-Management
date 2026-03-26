<?php

namespace App\Http\Controllers;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function store(Request $request, $project_id)
    {
     $request->validate([
    'title'=>'required|max:255',
    'status'=>'required',
    'priority'=>'required',
    'due_date'=>'required'
    ]);

    $task = Task::create([
    'project_id'=>$project_id,
    'title'=>$request->title,
    'description'=>$request->description,
    'status'=>$request->status,
    'priority'=>$request->priority,
    'due_date'=>$request->due_date
    ]);

    return response()->json([
    'message'=>'Task created',
    'data'=>$task
    ],201);
    }


    public function index(Request $request, $project_id)
    {
    $query = Task::where('project_id',$project_id);

    if($request->status){
    $query->where('status',$request->status);
    }

    if($request->sort == 'due_date'){
    $query->orderBy('due_date','asc');
    }
    $tasks = $query->paginate(6);
    return response()->json($tasks);

    }


    public function update(Request $request,$id)
    {
    $data = $request->all(); //
    $task = Task::find($id);

    if(!$task){
    return response()->json([
    'error'=>'Task not found'
    ],404);
    }

    $request->validate([
    'status'=>'required',
    'priority'=>'required',
    'due_date'=>'required|date'
    ]);

    $task->update($request->all());
    
    // $task->update($data);  // direct update

    return response()->json([
    'message'=>'Task updated',
    'data'=>$task
    ]);
    }
    

    public function destroy($id)
    {
    $task = Task::find($id);

    if(!$task){
    return response()->json([
    'error'=>'Task not found'
    ],404);
    }

    $task->delete();

    return response()->json([
    'message'=>'Task deleted'
    ]);

    }


}
