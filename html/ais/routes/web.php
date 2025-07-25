<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;

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

Route::get('/', [HomeController::class, 'nmea'])->name('nmea');
Route::get('hwid/{id}', [HomeController::class, 'nmeaID'])->name('nmeaID');
// Route::get('/', [LoginController::class, 'login'])->name('login');
Route::post('actionlogin', [LoginController::class, 'actionlogin'])->name('actionlogin');

// Route::get('home', [HomeController::class, 'index'])->name('home')->middleware('auth');
// Route::get('logout', [LoginController::class, 'actionlogout'])->name('actionlogout')->middleware('auth');

// Route::get('home/{name}', [HomeController::class, 'menu'])->middleware('auth');
