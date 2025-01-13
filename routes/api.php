<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;


Route::middleware(['auth:sanctum', 'throttle:10,1'])->group(function () {
    Route::apiResource('events', EventController::class);
});


//Route::get('events', [EventController::class, 'index']);
