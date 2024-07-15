<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\RecruiterController;

Route::post('register', [AuthController::class, 'register'])->middleware('api');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);
Route::post('refresh', [AuthController::class, 'refresh']);
Route::post('me', [AuthController::class, 'me']);


Route::middleware('auth:api')->group(function () {
    Route::get('email/verify', function () {
        return response()->json(['message' => 'Email verification notice']);
    })->name('verification.notice');

    Route::get('email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return response()->json(['message' => 'Email verified']);
    })->middleware(['signed'])->name('verification.verify');

    Route::post('email/resend', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return response()->json(['message' => 'Verification link sent']);
    })->name('verification.resend');
});
Route::group(['middleware' => ['role:student']], function () {
    Route::get('/student-dashboard', [StudentController::class, 'index']);
});

Route::group(['middleware' => ['role:university_admin']], function () {
    Route::get('/admin-dashboard', [AdminController::class, 'index']);
});

Route::group(['middleware' => ['role:company_recruiter']], function () {
    Route::get('/recruiter-dashboard', [RecruiterController::class, 'index']);
});