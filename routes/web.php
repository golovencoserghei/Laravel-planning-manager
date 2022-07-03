<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\StandController;
use App\Http\Controllers\TestController;
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
Route::middleware('guest')->group(static function(){
    Route::get('register', [RegisterController::class, 'edit'])->name('register');
    Route::post('register', [RegisterController::class, 'store'])->name('register.store');
    Route::get('login', [LoginController::class, 'loginView'])->name('login');
    Route::post('login', [LoginController::class, 'login'])->name('login.verification');
});

Route::get('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(static function(){
    Route::get('/', [TestController::class, 'index']);

    Route::get('/stand', [StandController::class, 'index']);
});