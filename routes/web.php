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
    Route::get('/user/add', [\App\Http\Controllers\UserController::class, 'create'])->name('user.create');
    Route::post('/user/add/submit', [\App\Http\Controllers\UserController::class, 'store'])->name('user.store');
    Route::get('/user/{id}/edit', [\App\Http\Controllers\UserController::class, 'edit'])->name('user.edit');
    Route::post('/user/edit/{id}/update', [\App\Http\Controllers\UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{id}/delete', [\App\Http\Controllers\UserController::class, 'delete'])->name('user.delete');

    // Company
    Route::get('/company', [\App\Http\Controllers\CompanyController::class, 'index'])->name('company.index');
    Route::get('/company/add', [\App\Http\Controllers\CompanyController::class, 'create'])->name('company.create');
    Route::post('/company/add/submit', [\App\Http\Controllers\CompanyController::class, 'store'])->name('company.store');
    Route::get('/company/{id}/edit', [\App\Http\Controllers\CompanyController::class, 'edit'])->name('company.edit');
    Route::post('/company/edit/{id}/update', [\App\Http\Controllers\CompanyController::class, 'update'])->name('company.update');
    Route::delete('/company/{id}/delete', [\App\Http\Controllers\CompanyController::class, 'delete'])->name('company.delete');

    // Employees
    Route::get('/employee', [\App\Http\Controllers\EmployeeController::class, 'index'])->name('employee.index');
    Route::get('/employee/add', [\App\Http\Controllers\EmployeeController::class, 'create'])->name('employee.create');
    Route::get('/employee/get-companies', [\App\Http\Controllers\EmployeeController::class, 'getCompanies'])->name('employee.getCompanies');
    Route::post('/employee/add/submit', [\App\Http\Controllers\EmployeeController::class, 'store'])->name('employee.store');
    Route::get('/employee/{id}/edit', [\App\Http\Controllers\EmployeeController::class, 'edit'])->name('employee.edit');
    Route::post('/employee/edit/{id}/update', [\App\Http\Controllers\EmployeeController::class, 'update'])->name('employee.update');
    Route::delete('/employee/{id}/delete', [\App\Http\Controllers\EmployeeController::class, 'delete'])->name('employee.delete');
});
