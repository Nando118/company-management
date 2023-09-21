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

    Route::get('/', function () {
        return view('home.index');
    })->name('home.index');
    Route::get('/home', function () {
        return view('home.index');
    });

    // User
    Route::get('/user', [\App\Http\Controllers\UserController::class, 'index'])->name('user.index');
});
