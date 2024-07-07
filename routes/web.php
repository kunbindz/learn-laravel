<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController as ProductControllerAlias;
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


Route::get('/', [AuthController::class, 'login'])->middleware('alreadyLoggedIn');
Route::get('/login', [AuthController::class, 'login'])->middleware('alreadyLoggedIn');
Route::get('/registration', [AuthController::class, 'registration'])->middleware('alreadyLoggedIn');
Route::get('/logout', [AuthController::class, 'logout']);
Route::post('/register-user', [AuthController::class, 'registerUser'])->name('register-user');
Route::post('/login-user', [AuthController::class, 'loginUser'])->name('login-user');

Route::get('/products', [ProductControllerAlias::class , 'index'])->middleware('isLoggedIn')->name('products.index');
Route::get('/products/create', [ProductControllerAlias::class , 'create'])->middleware('isLoggedIn')->name('products.create');
Route::post('/products/posts', [ProductControllerAlias::class , 'store'])->middleware('isLoggedIn')->name('products.store');





