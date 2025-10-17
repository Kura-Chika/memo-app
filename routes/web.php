<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemoController;

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


Route::get('/', [MemoController::class, 'index'])->name('memo.index');
Route::post('/', [MemoController::class, 'store'])->name('memo.store');
Route::delete('/{id}', [MemoController::class, 'destroy'])->name('memo.destroy');