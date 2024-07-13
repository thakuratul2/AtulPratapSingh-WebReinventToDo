<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListToDoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ListToDoController::class, 'index'])->name('tasks.index');
Route::post('/tasks', [ListToDoController::class, 'store'])->name('tasks.store');
Route::patch('/tasks/{task}', [ListToDoController::class, 'update'])->name('tasks.update');
Route::delete('/tasks/{task}', [ListToDoController::class, 'destroy'])->name('tasks.destroy');
Route::get('/tasks', [ListToDoController::class, 'showAll'])->name('tasks.showAll');
