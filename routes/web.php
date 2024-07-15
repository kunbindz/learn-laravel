<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
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


Route::get('/', [AuthController::class, 'login'])->middleware('already_logged_in');
Route::get('/login', [AuthController::class, 'login'])->middleware('already_logged_in');
Route::get('/registration', [AuthController::class, 'registration'])->middleware('already_logged_in');
Route::get('/logout', [AuthController::class, 'logout']);
Route::post('/register-user', [AuthController::class, 'registerUser'])->name('register-user');
Route::post('/login-user', [AuthController::class, 'loginUser'])->name('login-user');

Route::resource('/products', ProductController::class)->middleware('is_logged_in');







