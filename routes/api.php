<?php

use App\Http\Controllers\BudgetController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PhoneController;
use App\Http\Controllers\NoteController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

//item
Route::get('/items', [ItemController::class, 'index']);
Route::prefix('/item')->group(function(){
    Route::post('/store', [ItemController::class, 'store']);
    Route::put('/{id}', [ItemController::class, 'update']);
    Route::delete('/{id}', [ItemController::class, 'destroy']);
}) ;

//phone
Route::get('/phones', [PhoneController::class, 'index']);
Route::post('/phones', [PhoneController::class, 'store']);
Route::get('/phones/{id}', [PhoneController::class, 'show']);
Route::get('/phones/{id}/edit', [PhoneController::class, 'edit']);
Route::put('/phones/{id}/edit', [PhoneController::class, 'update']);
Route::delete('/phones/{id}/delete', [PhoneController::class, 'destroy']);

//note
Route::get('/notes', [NoteController::class, 'index']);
Route::post('/notes', [NoteController::class, 'store']);
Route::get('/notes/{id}', [NoteController::class, 'show']);
Route::get('/notes/{id}/edit', [NoteController::class, 'edit']);
Route::put('/notes/{id}/edit', [NoteController::class, 'update']);
Route::delete('/notes/{id}/delete', [NoteController::class, 'destroy']);

//budget
Route::get('/budget', [BudgetController::class, 'index']);
Route::post('/budget', [BudgetController::class, 'store']);
Route::get('/budget/{id}', [BudgetController::class, 'show']);
Route::get('/budget/{id}/edit', [BudgetController::class, 'edit']);
Route::put('/budget/{id}/edit', [BudgetController::class, 'update']);
Route::delete('/budget/{id}/delete', [BudgetController::class, 'destroy']);