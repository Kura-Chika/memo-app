<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MemoApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/', [MemoApiController::class, 'saveMemoAction'])->name('memo.store');
Route::delete('/{id}', [MemoApiController::class, 'deleteMemoAction'])->name('memo.destroy');
Route::put('/{id}', [MemoApiController::class, 'updateMemoAction'])->name('memo.update');