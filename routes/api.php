<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\SubtaskController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);


Route::get('user/team-leaders', [UserController::class, 'getTeamLeaders']);
Route::get('user/developers', [UserController::class, 'getDevelopers']);


Route::middleware(['jwt.verify'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::apiResource('projects', ProjectController::class);
    Route::apiResource('tasks', TaskController::class);
    Route::apiResource('subtasks', SubtaskController::class);

    Route::get('project-reports', [ReportController::class, 'index']);
    Route::get('project-report/exports', [ReportController::class, 'export']);
});
