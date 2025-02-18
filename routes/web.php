<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;

Route::get('/', [UsuarioController::class, 'index']);
Route::post('/cadastrarUsuario', [UsuarioController::class, 'cadastrarUsuario']);
Route::get('/visualizarUsuarios/{id}', [UsuarioController::class, 'visualizarUsuarios']);
Route::put('/atualizarUsuario/{id}', [UsuarioController::class, 'update']);
Route::delete('/deletarUsuario/{id}', [UsuarioController::class, 'deletarUsuario']);
Route::get('/telaUsuario',[UsuarioController::class, 'telaUsuario']);
