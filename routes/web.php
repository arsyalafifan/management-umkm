<?php

use App\Http\Controllers\BudgetManagementController;
use App\Http\Controllers\master\UserController;
use App\Http\Controllers\StockManagementController;
use Illuminate\Support\Facades\Auth;
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

// Route::get('/', function () {
//     return view('home');
// });

Auth::routes();

Route::middleware(['auth'])->group(function () {
    

    Route::get('/', function() {
        return view('dashboard');
    })->name('management-dashboard');

    Route::resource('stockmanagement', StockManagementController::class);
    Route::resource('budgetmanagement', BudgetManagementController::class);

    //User 
    Route::get('user/password', [UserController::class, 'password'])->name('user.password');
    Route::post('user/password', [UserController::class, 'storeubahpassword'])->name('user.password.save');
    Route::resource('user', UserController::class);
});

