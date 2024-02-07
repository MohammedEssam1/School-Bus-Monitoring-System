<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\VerificationController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('register', [AuthController::class,'register']);

Route::post('login', [AuthController::class,'login']);

Route::get('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::post('resend_otp', [VerificationController::class,'resendOtp']);

Route::post('verify_otp',[VerificationController::class,'verifyOtp']);