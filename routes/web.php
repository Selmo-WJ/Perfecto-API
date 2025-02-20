<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::prefix('tasks')->group(function () {
    Route::get('/', [TaskController::class, 'index']);
    Route::post('/create', [TaskController::class, 'store']);
    Route::get('{task}', [TaskController::class, 'show']);
    Route::put('/update/{task}', [TaskController::class, 'update']);
    Route::put('/toggle/{task}', [TaskController::class, 'toggleCompleted']);
    Route::delete('/delete/{task}', [TaskController::class, 'destroy']);
});