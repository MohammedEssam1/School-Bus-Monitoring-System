<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\ParentController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\DashBoardController;
use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\VerificationController;
use App\Http\Controllers\Api\AccelerometerController;
use App\Http\Controllers\Api\NotificationsController;

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
    Route::get('location',[LocationController::class,'index'] );
    Route::post('notifications/readAll',[NotificationsController::class,'readAll'] );
    Route::get('notifications',[NotificationsController::class,'index'] );
    Route::get('accelerometer_readings',[AccelerometerController::class,'index'] );
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
     Route::resource('admins',AdminController::class);
     Route::post('/attendances/search_by_student_name', [AttendanceController::class, 'searchBy_Student_Name']);
     Route::get('/dashboard', [DashBoardController::class, 'index']);
 });