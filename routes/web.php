<?php

use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [WelcomeController::class, 'index']);

Route::get('/zad1/dodajlosowe/{liczba}', [WelcomeController::class, 'task3'])->name('task3');


Route::get('/zad1/lista/{fraza}', [WelcomeController::class, 'task4'])->name('task4');

Route::get('/zad6', [WelcomeController::class, 'task5'])->name('task5');

Route::get('/convert/array', [WelcomeController::class, 'task6'])->name('convertArray');
