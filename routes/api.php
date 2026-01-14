<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\RoleController;

Route::get('products', [ProductController::class, 'index']);
Route::post('products', [ProductController::class, 'store']);
Route::get('products/{id}', [ProductController::class, 'show']);
Route::patch('products/{id}', [ProductController::class, 'update']);
Route::post('/products/{id}/sell', [ProductController::class, 'sell']);
Route::delete('products/{id}', [ProductController::class, 'destroy']);

Route::get('roles', [RoleController::class, 'index']);
Route::get('roles/{id}', [RoleController::class, 'show']);
