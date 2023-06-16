<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
})->name('login');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::post('user/register',[RegisterController::class,'register'])->name('user.register');
Route::post('user/login',[LoginController::class,'login'])->name('user.login');
Route::get('user/logout',[LoginController::class,'logout'])->name('logout');

Route::get('unique/email',[UserController::class,'uniqueEmail'])->name('unique.email');
Route::get('user/edit',[UserController::class,'edit'])->name('user.edit');
Route::post('user/update',[UserController::class,'update'])->name('user.update');
