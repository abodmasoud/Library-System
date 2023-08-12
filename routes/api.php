<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowerController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [ApiController::class, 'login']);
Route::post('/register', [ApiController::class, 'register']);
Route::get('/users', [ApiController::class, 'getUsers'])->middleware('auth:sanctum');
Route::post('/logout', [ApiController::class, 'logout'])->middleware('auth:sanctum');

Route::prefix('/books')->middleware('auth:sanctum')->group(function () {
    Route::get('index', [BookController::class, 'index']);
    Route::post('store', [BookController::class, 'store']);
    Route::post('update/{id}', [BookController::class, 'update']);
    Route::delete('delete/{id}', [BookController::class, 'destroy']);
});

Route::prefix('/categories')->middleware('auth:sanctum')->group(function () {
    Route::get('index', [CategoryController::class, 'index']);
    Route::post('store', [CategoryController::class, 'store']);
    Route::put('update/{id}', [CategoryController::class, 'update']);
    Route::delete('delete/{id}', [CategoryController::class, 'destroy']);
});

Route::prefix('/borrowers')->middleware('auth:sanctum')->group(function () {
    Route::get('index', [BorrowerController::class, 'index']);
    Route::post('store', [BorrowerController::class, 'store']);
    Route::put('update/{id}', [BorrowerController::class, 'update']);
    Route::delete('delete/{id}', [BorrowerController::class, 'destroy']);
});
