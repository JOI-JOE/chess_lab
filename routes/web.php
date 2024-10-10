<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\isAdmin;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::middleware([Authenticate::class, isAdmin::class])->group(function () {
Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard');
Route::get('/list', action: [HomeController::class, 'list'])->name('list');
Route::get('book/{id}', action: [HomeController::class, 'detail'])->name('detail');
Route::get('add-new', action: [HomeController::class, 'create'])->name('create');
Route::post('add-new', action: [HomeController::class, 'store'])->name('book.store');
Route::get('book/edit/{id}', action: [HomeController::class, 'edit'])->name('book.edit');
Route::PUT('book/update/{id}', action: [HomeController::class, 'update'])->name('book.update');
Route::delete('list/{id}', action: [HomeController::class, 'destroy'])->name('book.delete');

Route::prefix('user')->name('user.')->group(function () {
    Route::get('list', [UserController::class, 'index'])->name('list');
    Route::get('change-password', [UserController::class, 'changePass'])->name('changePass');
    Route::get('{id}', [UserController::class, 'show'])->name('show');
    Route::get('edit/{id}', [UserController::class, 'edit'])->name('edit');
    Route::put('update/{id}', [UserController::class, 'update'])->name('update');
});
Route::post('postAlterPass',[UserController::class,'postAlterPass'])->name('postAlterPass');

Route::prefix('movie')->name('movie.')->group(function () {
    Route::get('list', [MovieController::class, 'index'])->name('list');
    Route::get('create', [MovieController::class, 'create'])->name('create');
    Route::post('store', [MovieController::class, 'store'])->name('store');
    Route::get('{id}', [MovieController::class, 'show'])->name('show');
    Route::delete('{id}', [MovieController::class, 'destroy'])->name('destroy');
    Route::get('edit/{id}', [MovieController::class, 'edit'])->name('edit');
    Route::put('update/{id}', [MovieController::class, 'update'])->name('update');
});

Route::post('/tmp-upload', [MovieController::class, 'tmpUpload'])->name('upload_image');
Route::delete('/tmp-delete', [MovieController::class, 'tmpDelete'])->name('delete_image');
Route::post('/update_movie_image', [MovieController::class, 'tmpUpdate'])->name('update_movie_image');

Route::get('/logout', action: [AuthController::class, 'logout'])->name('logout');
// });

//login, register, logout
Route::get('/login', [AuthController::class, 'getLogin'])->name('login');
Route::post('/login', [AuthController::class, 'postLogin'])->name('postLogin');

Route::get('/register', [AuthController::class, 'getRegister'])->name('register');
Route::post('/register', [AuthController::class, 'postRegister'])->name('postRegister');
