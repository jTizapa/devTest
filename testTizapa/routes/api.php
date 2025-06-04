<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::group(['prefix' => 'auth'], function () {
  Route::post('login', [AuthController::class, 'login']);
  Route::post('register', [AuthController::class, 'register']);

  Route::group(['middleware' => 'auth:api'], function () {
    Route::get('logout', [AuthController::class, 'logout']);
  });
});


Route::group(['prefix' => 'project'], function () {
  Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::resource('project', TaskController::class);
  });
});

Route::group(['prefix' => 'task'], function () {
  Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::resource('task', ProjectsController::class);
  });
});
