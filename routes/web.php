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
    Route::post('/budgetmanagement/storerekening', [BudgetManagementController::class, 'storeRekening'])->name('budgetmanagement.storerekening');
    Route::post('/budgetmanagement/updaterekening/{rekeningid}', [BudgetManagementController::class, 'updateRekening'])->name('budgetmanagement.updaterekening');
    Route::get('budgetmanagement/budget/{id}', [BudgetManagementController::class,'loadBudget'])->name('budgetmanagement.loadBudget');
    Route::post('/budgetmanagement/storebudget/{rekeningid}', [BudgetManagementController::class, 'storeBudget'])->name('budgetmanagement.storebudget');
    Route::post('/budgetmanagement/updatebudget/{budgetid}', [BudgetManagementController::class, 'updatebudget'])->name('budgetmanagement.updatebudget');

    //User 
    Route::get('user/password', [UserController::class, 'password'])->name('user.password');
    Route::post('user/password', [UserController::class, 'storeubahpassword'])->name('user.password.save');
    Route::resource('user', UserController::class);
});

