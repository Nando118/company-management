<?php

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
$middleware = [
    "auth"
];

Route::group(['middleware' => $middleware], function (){

    Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home.index');
    Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home.index');

    // User
    Route::get('/user', [\App\Http\Controllers\UserController::class, 'index'])->name('user.index');
    Route::get('/user/add', [\App\Http\Controllers\UserController::class, 'add'])->name('user.add');
    Route::post('/user/add/submit', [\App\Http\Controllers\UserController::class, 'store'])->name('user.submit');
    Route::get('/user/{id}/edit', [\App\Http\Controllers\UserController::class, 'edit'])->name('user.edit');
    Route::post('/user/edit/{id}/update', [\App\Http\Controllers\UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{id}/delete', [\App\Http\Controllers\UserController::class, 'delete'])->name('user.delete');
});
