<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\controluserController;

Route::get('/control-user', [controluserController::class, 'index']);

Route::get('/control-user/{id}', [controluserController::class, 'show']);

Route::post('/control-user', [controluserController::class, 'store']);

Route::put('/control-user/{id}', [controluserController::class, 'update']);

Route::patch('/control-user/{id}', [controluserController::class, 'updatePartial']);

Route::delete('/control-user/{id}', [controluserController::class, 'destroy']);
