<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\OTPController;
use App\Http\Controllers\Api\PhoneNumberController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController\AuthenticationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('v1/register', [AuthenticationController::class, 'store']);
Route::post('v1/login', [AuthenticationController::class, 'login']);
Route::post('v1/forgot-password', [AuthenticationController::class, 'forgotPassword']);
Route::post("v1/send-otp", [OTPController::class, 'sendOTP']);
Route::post("v1/send-forgot-otp", [OTPController::class, 'sendForgotOTP']);
Route::post("v1/verify-forgot-otp", [OTPController::class, 'verifyForgotOTP']);


//Route::post('register', [AuthenticationController::class, 'register']);

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::post('v1/logout', [AuthenticationController::class, 'logout']);

    Route::get('v1/check-token-expiration', [AuthenticationController::class, 'checkTokenExpiration']);

    Route::post('v1/change-first-name', [ProfileController::class, 'changeFirstName']);
    Route::post('v1/change-last-name', [ProfileController::class, 'changeLastName']);
    Route::post('v1/change-date-birth', [ProfileController::class, 'changeDateOfBirth']);
    Route::post('v1/change-phone', [ProfileController::class, 'changePhone']);
    Route::post('v1/change-email', [ProfileController::class, 'changeEmail']);
    Route::post('v1/change-password', [ProfileController::class, 'changePassword']);

    Route::post('v1/exchange', [TransactionController::class, 'send']);

    Route::get('v1/notifications', [NotificationController::class, 'getAllList']);
    Route::post('v1/change-notifications-status', [NotificationController::class, 'changeNotificationStatus']);

    // Route::get('v1/listsbank', [Sbankcontroller::class, 'SbankList']);

    route::get('v1/list-order/{order}/{start_date?}/{end_date?}', [OrderController::class, 'orders'])->name('order.list');
    route::get('v1/order/{id}', [OrderController::class, 'singleOrder'])->name('order.single');
});



Route::post('/phone-numbers', [PhoneNumberController::class, 'store']);
Route::get('/test', [PhoneNumberController::class, 'index']);
