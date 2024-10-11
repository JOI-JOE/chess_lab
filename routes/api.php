<?php

use App\Http\Controllers\Api\MovieController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
// Route::prefix('v1')->group(function () {
//     Route::apiResource('category', CategoryController::class);
// });

Route::apiResource('movie', MovieController::class);
