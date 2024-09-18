<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard');
Route::get('/list', action: [HomeController::class, 'list'])->name('list');
Route::get('book/{id}', action: [HomeController::class, 'detail'])->name('detail');
// Route::get('select_cate/{id}', action: [HomeController::class, 'select_cate'])->name('select_cate');
