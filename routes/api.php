<?php

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/', function () {
    return view('projects.index');
});

Route::get('/tasks', function () {
    return view('tasks.index');
});

Route::get('/projects',[ProjectController::class,'index']);    //pagiantion
Route::post('/projects',[ProjectController::class,'store']);
Route::get('/projects/{id}',[ProjectController::class,'show']);  //give prj data
Route::delete('/projects/{id}',[ProjectController::class,'destroy']);   

Route::post('/projects/{project_id}/tasks',[TaskController::class,'store']);  //task created
Route::get('/projects/{project_id}/tasks',[TaskController::class,'index']);
Route::post('/tasks/{id}',[TaskController::class,'update']);
Route::delete('/tasks/{id}',[TaskController::class,'destroy']);


