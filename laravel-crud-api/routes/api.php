<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\controluserController;
use App\Http\Controllers\Api\loginCredentialsController;

Route::get('/control-user', [controluserController::class, 'index']);

Route::get('/control-user/{id}', [controluserController::class, 'show']);

Route::post('/control-user', [controluserController::class, 'store']);

Route::put('/control-user/{id}', [controluserController::class, 'update']);

Route::patch('/control-user/{id}', [controluserController::class, 'updatePartial']);

Route::delete('/control-user/{id}', [controluserController::class, 'destroy']);

//? Rutas

Route::get('/user', [loginCredentialsController::class, 'getAll']);

Route::get('/user/{id}', [loginCredentialsController::class, 'getOne']);

Route::post('/user', [loginCredentialsController::class, 'createUser']);

Route::put('/user/{id}', [loginCredentialsController::class, 'updateUser']);

Route::delete('/user/{id}', [loginCredentialsController::class, 'deleteUser']);

//* Ruta de Login

Route::post('/login', [loginCredentialsController::class, 'login']);
