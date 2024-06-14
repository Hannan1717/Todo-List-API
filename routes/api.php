<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\TodoController;
use App\Http\Controllers\Api\Users\AvatarController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ImportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('register', RegisterController::class);
Route::post('login', LoginController::class);
Route::apiResource('todos', TodoController::class)->middleware('auth:sanctum');
Route::post('avatar', AvatarController::class)->middleware('auth:sanctum');
Route::get('export-todos', [ExportController::class, 'exportTodos'])->middleware('auth:sanctum');
Route::post('import-todos', [ImportController::class, 'importTodos'])->middleware('auth:sanctum');
