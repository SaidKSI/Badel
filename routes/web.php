<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\DashboredController;
use App\Http\Controllers\TransactionController;
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
    return redirect()->route('login');
});
Route::prefix('admin')->group(function () {
    Route::get('login', [AdminController::class, 'show_login'])->name('login');
    Route::post('admin_login', [AdminController::class, 'login'])->name('admin_login');
});
Route::prefix('admin')->middleware(['auth:admin'])->group(function () {
    Route::get('/banks', [BankController::class, 'index'])->name('banks');
    Route::get('/users', [DashboredController::class, 'users'])->name('users');
    // Transaction
    Route::get('/transactions/{status}', [TransactionController::class, 'index'])->name('transactions');
    Route::get('/transactions/pending', [TransactionController::class, 'pending'])->name('pending');

    // UPDATE TRANSACTION STAUTS
    Route::patch('/transactions/update/{id}/{status}', [TransactionController::class, 'updateStatus'])->name('transactions.updateStatus');


    //FEES

    Route::get('/fees', [DashboredController::class, 'fees'])->name('fees');
    Route::patch('/fees/{id}', [DashboredController::class, 'fees_update'])->name('fees_update');

    // HISTORY
    Route::get('/history', [DashboredController::class, 'history'])->name('history');
});
