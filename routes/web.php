<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Moban\ClosingController;
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

Route::get('/table', function () {
    return view('pages.table');
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
 * Group of closing routes.
 */
Route::group(['prefix' => 'moban', 'middleware' => ['auth']], function () {
    Route::group(['prefix' => 'closing'], function () {
        Route::get('/', [ClosingController::class, 'index'])->name('closing');
        Route::put('/pickup', [ClosingController::class, 'pickup'])->name('closing.pickup');
        Route::put('/close', [ClosingController::class, 'pickup'])->name('closing.close');
    });
});



/**
 * Group of user profile routes
 */
Route::group(['prefix' => 'users'], function () {
    Route::middleware(['auth'])->group(function () {

        Route::get('/profile', [ProfileController::class, 'profilePage'])
            ->name('profile');
        Route::put('/profile', [ProfileController::class, 'updatePassword'])
            ->name('profile.new.password');

    });
});

/**
 * Group of admin routes
 */
Route::group(['prefix' => 'users'], function () {
    Route::middleware(['auth', 'role:admin'])->group(function () {

        Route::get('/agent', [UserController::class, 'listAgentPage'])
            ->name('user.agent');
        Route::get('/admin', [UserController::class, 'listAdminPage'])
            ->name('user.admin');

        Route::post('/', [UserController::class, 'store'])
            ->name('user.store');

        Route::put('/{userId}', [UserController::class, 'update'])
            ->name('user.update');

        Route::delete('/{userId}', [UserController::class, 'destroy'])
            ->name('user.destroy');
    });
});


// Test Error Page

Route::get('/test-401', function () {
    abort(401);
});


Route::get('/test-403', function () {
    abort(403);
});

Route::get('/test-500', function () {
    abort(500);
});
