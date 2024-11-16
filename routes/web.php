<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ProfileController;
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

Route::get('/', function () {
    return view('pages.testing');
});


/**
 * Group of auth routes.
 */
Route::group(['prefix' => 'auth'], function () {
    Route::get('/login', [AuthController::class, 'loginPage'])
        ->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])
        ->name('login.submit');
    Route::delete('/logout', [AuthController::class, 'logout'])
        ->name('logout')
        ->middleware('auth');
});


/**
 * Group of user profile routes
 */
Route::group(['prefix' => 'users'], function () {
    Route::middleware(['auth'])->group(function () {

        Route::get('/profile', [ProfileController::class, 'profilePage'])->name('profile');
        Route::put('/profile', [ProfileController::class, 'profilePage'])->name('profile.new.password');

    });
});
