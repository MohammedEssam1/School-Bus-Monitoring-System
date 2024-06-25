<?php

use App\Http\Controllers\Api\ParentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\AttendanceController;
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


Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('user',function (Request $request) {
        return $request->user();
    });
    Route::get('attendances', [AttendanceController::class,'index']);
    Route::post('/attendances/search_by_student_id', [AttendanceController::class, 'searchBy_Student_Id']);
    Route::get('parents/{id}/sons', [ParentController::class,'sons']);

});

Route::post('register', [AuthController::class,'register']);

Route::post('login', [AuthController::class,'login']);

Route::get('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::post('resend_otp', [VerificationController::class,'resendOtp']);

Route::post('verify_otp',[VerificationController::class,'verifyOtp']);

Route::group(['middleware' => ['auth:sanctum','admin']], function () {
     Route::resource('students',StudentController::class);
     Route::resource('tags',TagController::class);
     Route::resource('parents',ParentController::class);
     Route::post('/attendances/search_by_student_name', [AttendanceController::class, 'searchBy_Student_Name']);
 });