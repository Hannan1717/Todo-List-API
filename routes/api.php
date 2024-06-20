<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\TodoController;
use App\Http\Controllers\Api\Users\AvatarController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\Api\TaskController;
use Illuminate\Support\Facades\Route;

Route::post('register', RegisterController::class);
Route::post('login', LoginController::class);

Route::middleware('auth:api')->group(function () {
    Route::post('logout', LogoutController::class);
    Route::apiResource('todos', TodoController::class);
    Route::post('avatar', AvatarController::class);
    Route::get('export-todos', [ExportController::class, 'exportTodos']);
    Route::post('import-todos', [ImportController::class, 'importTodos']);

    Route::middleware('role:admin')->group(function () {
        Route::get('task', [TaskController::class, 'index']);
        Route::post('create-task', [TaskController::class, 'store']);
        Route::put('update-task-adm/{task}', [TaskController::class, 'updateByAdmin']);
        Route::delete('delete-task/{task}', [TaskController::class, 'destroy']);
    });

    Route::middleware('role:employee')->group(function () {
        Route::get('taskEmployee', [TaskController::class, 'employeeTasks']);
        Route::put('update-task/{task}', [TaskController::class, 'updateByEmp']);
    });
});
