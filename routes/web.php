<?php

use App\Http\Controllers\BudgetManagementController;
use App\Http\Controllers\master\UserController;
use App\Http\Controllers\StockManagementController;
use App\Http\Controllers\TransactionManagementController;
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
    Route::post('budgetmanagement/destroyrekening/{id}', [BudgetManagementController::class,'destroy'])->name('budgetmanagement.destroyrekening');

    Route::post('/budgetmanagement/storebudget/{rekeningid}', [BudgetManagementController::class, 'storeBudget'])->name('budgetmanagement.storebudget');
    Route::post('/budgetmanagement/updatebudget/{budgetid}', [BudgetManagementController::class, 'updatebudget'])->name('budgetmanagement.updatebudget');
    Route::get('budgetmanagement/alokasibudget/{id}', [BudgetManagementController::class,'loadAlokasiBudget'])->name('budgetmanagement.loadAlokasiBudget');
    Route::post('budgetmanagement/destroybudget/{id}', [BudgetManagementController::class,'destroybudget'])->name('budgetmanagement.destroybudget');

    Route::post('/budgetmanagement/storealokasibudget/{budgetid}', [BudgetManagementController::class, 'storeAlokasiBudget'])->name('budgetmanagement.storeAlokasiBudget');
    Route::post('/budgetmanagement/statusrealisasi/{budgetid}', [BudgetManagementController::class, 'statusrealisasi'])->name('budgetmanagement.statusrealisasi');
    Route::post('budgetmanagement/destroyalokasibudget/{id}', [BudgetManagementController::class,'destroyalokasibudget'])->name('budgetmanagement.destroyalokasibudget');
    
    Route::resource('transactionmanagement', TransactionManagementController::class);
    Route::get('/transactionmanagement/transaction/{stockid}', [TransactionManagementController::class, 'transaction'])->name('transactionmanagement.transaction');
    Route::post('/budgetmanagement/savesetting/{stockid}', [TransactionManagementController::class, 'savesetting'])->name('transactionmanagement.savesetting');
    Route::post('/budgetmanagement/addtransaction/{stockid}', [TransactionManagementController::class, 'addtransaction'])->name('transactionmanagement.addtransaction');
    
    //User 
    Route::get('user/password', [UserController::class, 'password'])->name('user.password');
    Route::post('user/password', [UserController::class, 'storeubahpassword'])->name('user.password.save');
    Route::resource('user', UserController::class);
});

