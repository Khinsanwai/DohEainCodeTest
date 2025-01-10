<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;




Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum', 'role:Admin'])->group(function () {
    Route::post('/projects', [ProjectController::class, 'store']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('projects', ProjectController::class);
});

Route::get('/projects/{id}/summary', [ProjectController::class, 'summary']);

Route::get('user-performance', [UserController::class, 'performance']);

Route::get('/search', [SearchController::class, 'search']);

