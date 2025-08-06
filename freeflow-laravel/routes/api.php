<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Public routes
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);
    Route::get('verify-email', [AuthController::class, 'verifyEmail']);
    Route::post('resend-verification', [AuthController::class, 'resendVerification']);
    
    // Social authentication
    Route::get('{provider}/redirect', [SocialAuthController::class, 'redirect'])
        ->where('provider', 'github|google');
    Route::get('{provider}/callback', [SocialAuthController::class, 'callback'])
        ->where('provider', 'github|google');
});

// Public portfolio routes
Route::get('portfolio', [ProjectController::class, 'portfolio']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::prefix('auth')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);
        Route::post('refresh', [AuthController::class, 'refresh']);
    });

    // Dashboard routes
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index']);
        Route::get('recent-activities', [DashboardController::class, 'recentActivities']);
        Route::get('earnings-chart', [DashboardController::class, 'earningsChart']);
        Route::get('time-tracking-summary', [DashboardController::class, 'timeTrackingSummary']);
    });

    // Project routes
    Route::apiResource('projects', ProjectController::class);
    Route::prefix('projects/{project}')->group(function () {
        Route::post('images', [ProjectController::class, 'uploadImages']);
        Route::delete('images', [ProjectController::class, 'removeImage']);
    });

    // Client routes
    // Route::apiResource('clients', ClientController::class);

    // Invoice routes
    // Route::apiResource('invoices', InvoiceController::class);
    // Route::prefix('invoices/{invoice}')->group(function () {
    //     Route::post('send', [InvoiceController::class, 'send']);
    //     Route::post('mark-paid', [InvoiceController::class, 'markPaid']);
    //     Route::get('pdf', [InvoiceController::class, 'downloadPdf']);
    // });

    // Time tracking routes
    // Route::apiResource('time-entries', TimeEntryController::class);
    // Route::prefix('time-entries')->group(function () {
    //     Route::post('start', [TimeEntryController::class, 'start']);
    //     Route::post('{timeEntry}/stop', [TimeEntryController::class, 'stop']);
    //     Route::get('running', [TimeEntryController::class, 'running']);
    // });

    // User profile routes
    // Route::prefix('profile')->group(function () {
    //     Route::get('/', [ProfileController::class, 'show']);
    //     Route::put('/', [ProfileController::class, 'update']);
    //     Route::post('avatar', [ProfileController::class, 'uploadAvatar']);
    //     Route::delete('avatar', [ProfileController::class, 'removeAvatar']);
    //     Route::put('password', [ProfileController::class, 'updatePassword']);
    // });
});

// Fallback route for API
Route::fallback(function () {
    return response()->json([
        'message' => 'API endpoint not found.',
    ], 404);
});