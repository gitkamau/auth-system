<?php

use App\Http\Controllers\Api\Auth\AuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\RecruiterController;
use App\Http\Controllers\Api\Auth\MfaController;

Route::post('register', [AuthController::class, 'register'])->middleware('api');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);
Route::post('refresh', [AuthController::class, 'refresh']);
Route::post('me', [AuthController::class, 'me']);


Route::middleware('auth:api:check_mfa')->group(function () {
    Route::put('user/{id}', [AuthController::class, 'updateUser']);
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
    Route::post('mfa/send-code', [MfaController::class, 'sendMfaCode']);
    Route::post('mfa/verify', [MfaController::class, 'verifyMfaCode']);
});
Route::group(['middleware' => ['role:student']], function () {
    // Projects
    Route::get('/projects', [StudentController::class, 'indexProjects']); // List all projects
    Route::get('/projects/{id}', [StudentController::class, 'showProject']); // Read a specific project

    // Videos
    Route::get('/videos', [StudentController::class, 'indexVideos']); // List all videos
    Route::get('/videos/{id}', [StudentController::class, 'showVideo']); // Read a specific video

    // Files
    Route::get('/files', [StudentController::class, 'indexFiles']); // List all files
    Route::get('/files/{id}', [StudentController::class, 'showFile']); // Read a specific file

    // Tasks
    Route::put('/tasks/{id}', [StudentController::class, 'updateTask']); // Edit a task

    // Challenges
    Route::put('/challenges/{id}', [StudentController::class, 'updateChallenge']); // Edit a challenge

    // Certificates
    Route::get('/certificates', [StudentController::class, 'indexCertificates']); // List all certificates
    Route::get('/certificates/{id}', [StudentController::class, 'showCertificate']); // Read a specific certificate

    // Submissions
    Route::put('/submissions/{id}', [StudentController::class, 'updateSubmission']); // Edit a submission
    Route::delete('/submissions/{id}', [StudentController::class, 'deleteSubmission']); // Delete a submission
});

Route::group(['middleware' => ['role:university_admin']], function () {
    Route::get('/admin-dashboard', [AdminController::class, 'index']);
});

Route::group(['middleware' => ['role:company_recruiter']], function () {
    // Projects
    Route::get('/projects', [RecruiterController::class, 'indexProjects']); // List all projects
    Route::post('/projects', [RecruiterController::class, 'storeProject']); // Create a project
    Route::get('/projects/{id}', [RecruiterController::class, 'showProject']); // Read a specific project
    Route::put('/projects/{id}', [RecruiterController::class, 'updateProject']); // Update a project
    Route::delete('/projects/{id}', [RecruiterController::class, 'deleteProject']); // Delete a project

    // Videos
    Route::get('/videos', [RecruiterController::class, 'indexVideos']); // List all videos
    Route::post('/videos', [RecruiterController::class, 'storeVideo']); // Create a video
    Route::get('/videos/{id}', [RecruiterController::class, 'showVideo']); // Read a specific video
    Route::put('/videos/{id}', [RecruiterController::class, 'updateVideo']); // Update a video
    Route::delete('/videos/{id}', [RecruiterController::class, 'deleteVideo']); // Delete a video

    // Files
    Route::get('/files', [RecruiterController::class, 'indexFiles']); // List all files
    Route::post('/files', [RecruiterController::class, 'storeFile']); // Upload a file
    Route::get('/files/{id}', [RecruiterController::class, 'showFile']); // Read a specific file
    Route::put('/files/{id}', [RecruiterController::class, 'updateFile']); // Update a file
    Route::delete('/files/{id}', [RecruiterController::class, 'deleteFile']); // Delete a file

    // Submissions
    Route::get('/submissions', [RecruiterController::class, 'indexSubmissions']); // List all submissions
    Route::post('/submissions', [RecruiterController::class, 'storeSubmission']); // Create a submission
    Route::get('/submissions/{id}', [RecruiterController::class, 'showSubmission']); // Read a specific submission
    Route::put('/submissions/{id}', [RecruiterController::class, 'updateSubmission']); // Update a submission
    Route::delete('/submissions/{id}', [RecruiterController::class, 'deleteSubmission']); // Delete a submission

    // Certificates
    Route::get('/certificates', [RecruiterController::class, 'indexCertificates']); // List all certificates
    Route::post('/certificates', [RecruiterController::class, 'storeCertificate']); // Issue a certificate
    Route::get('/certificates/{id}', [RecruiterController::class, 'showCertificate']); // Read a specific certificate
    Route::put('/certificates/{id}', [RecruiterController::class, 'updateCertificate']); // Update a certificate
    Route::delete('/certificates/{id}', [RecruiterController::class, 'deleteCertificate']); // Revoke a certificate

    // View all students
    Route::get('/students', [RecruiterController::class, 'indexStudents']); // List all students
});
