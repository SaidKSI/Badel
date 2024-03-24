<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PhoneNumberController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\DashboredController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
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
    // Log Out
    Route::get('/logout', [AdminController::class, 'logout'])->name('logout');
    // HISTORY
    Route::get('/transaction/history', [DashboredController::class, 'transaction_history'])->name('transaction.history');
    Route::get('/phone/history', [DashboredController::class, 'phone_history'])->name('phone.history');

    //DASHBORED
    Route::get('/dashbored', [DashboredController::class, 'index'])->name('dashbored');
    
    //Banks
        Route::get('/banks', [BankController::class, 'index'])->name('banks');
    Route::get('/bank/{id}', [BankController::class, 'show'])->name('bank');
    Route::patch('/banks/{id}', [BankController::class, 'banks_update'])->name('banks_update');

    //USERS
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('user');


    // Transaction
    Route::get('/transactions/{status}', [TransactionController::class, 'index'])->name('transactions');
    Route::get('/transaction/{transaction_id}', [TransactionController::class, 'show'])->name('transaction');


    // UPDATE TRANSACTION STAUTS
    Route::patch('/transactions/update/{id}/{status}', [TransactionController::class, 'updateStatus'])->name('transactions.updateStatus');
    
    Route::patch('/transactions/update/{id}', [TransactionController::class, 'update'])->name('transaction.update');

    //FEES
    Route::get('/fees', [DashboredController::class, 'fees'])->name('fees');
    Route::patch('/fees/{id}', [DashboredController::class, 'fees_update'])->name('fees_update');


    //PHONE NUMBERS
    Route::get('/phones/{status}', [PhoneNumberController::class, 'index'])->name('phones');
    Route::patch('/phones/update/{id}/{status}', [PhoneNumberController::class, 'updateStatus'])->name('phones.updateStatus');

    //NOTIFICATION
    Route::post('/mark_notification_as_read', [NotificationController::class, 'mark_notification_as_read'])
        ->name('mark_notification_as_read');
    // Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
});