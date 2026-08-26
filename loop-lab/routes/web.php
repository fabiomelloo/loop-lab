<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LearningController;
use App\Http\Controllers\RewardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LearningController::class, 'dashboard'])->name('dashboard');
Route::get('/aulas/{lesson:slug}/{exercise:slug?}', [LearningController::class, 'lesson'])->name('lessons.show');
Route::post('/exercicios/{exercise}/executar', [LearningController::class, 'run'])->middleware('throttle:20,1')->name('exercises.run');
Route::post('/exercicios/{exercise}/validar', [LearningController::class, 'validateAnswer'])->middleware('throttle:20,1')->name('exercises.validate');
Route::get('/ranking', [LearningController::class, 'ranking'])->name('ranking');
Route::get('/recompensas', [RewardController::class, 'index'])->name('rewards.index');
Route::post('/recompensas/{reward:slug}/resgatar', [RewardController::class, 'redeem'])->middleware('throttle:10,1')->name('rewards.redeem');
Route::post('/perfil', [LearningController::class, 'updateProfile'])->middleware('throttle:10,1')->name('profile.update');
Route::get('/revisar', [LearningController::class, 'review'])->name('review');
Route::get('/entrar/{mode?}', [AuthController::class, 'form'])->middleware('guest')->name('login');
Route::post('/entrar', [AuthController::class, 'login'])->middleware('guest')->name('login.submit');
Route::post('/cadastro', [AuthController::class, 'register'])->middleware('guest')->name('register');
Route::post('/sair', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
