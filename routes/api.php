<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\TodoController;
use App\Http\Controllers\Api\Users\AvatarController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\LogoutController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register', RegisterController::class);
Route::post('login', LoginController::class);
Route::post('logout', LogoutController::class);

Route::middleware('auth:api')->group(function () {
    Route::apiResource('todos', TodoController::class);
    Route::post('avatar', AvatarController::class);
    Route::get('export-todos', [ExportController::class, 'exportTodos']);
    Route::post('import-todos', [ImportController::class, 'importTodos']);
});
