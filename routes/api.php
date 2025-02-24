<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

Route::post('/projects/new', [ProjectController::class, 'storeProjects']);      //Endpoint para ejecutar la creacion de proyectos de prueba
Route::delete('/projects/deleteAll', [ProjectController::class, 'deleteAll']);  //Endpoint para borrar todos los proyectos

Route::post('/register', [UserController::class, 'register']);             //Endpoint para el registro de usuarios
Route::post('/login', [AuthController::class, 'login']);                   //Endpoint para el login
Route::get('/projects', [ProjectController::class, 'list']);               //Endpoint para mostrar todos los proyectos

//Middleware que solicita un login para ejecutar las siguientes rutas:
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/projects', [ProjectController::class, 'store']);                  //Endpoint para almacenar un nuevo proyecto
    Route::put('/projects/{id}', [ProjectController::class, 'update']);             //Endpoint para actualizar un proyecto
    Route::delete('/projects/{id}', [ProjectController::class, 'softDelete']);      //Endpoint para eliminar un proyecto
    Route::get('/projects/deleted', [ProjectController::class, 'listDeleted']);     //Endpoint para ver proyectos eliminados
    Route::post('/logout', [AuthController::class, 'logout']);                      //Endpoint para el log out
});
