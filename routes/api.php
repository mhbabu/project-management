<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::middleware(['jwt.verify'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    // Route::apiResource('projects', ProjectController::class);
    // Route::apiResource('tasks', TaskController::class);
    // Route::apiResource('subtasks', SubtaskController::class);

    // Route::get('reports/projects', [ReportController::class, 'index']);
    // Route::get('reports/projects/export', [ReportController::class, 'export']);
});
