<?php

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

// Redirect root to API documentation or frontend
Route::get('/', function () {
    return response()->json([
        'message' => 'Welcome to FreeFlow API',
        'version' => '1.0.0',
        'documentation' => url('/docs'),
        'endpoints' => [
            'auth' => url('/api/auth'),
            'dashboard' => url('/api/dashboard'),
            'projects' => url('/api/projects'),
            'portfolio' => url('/api/portfolio'),
        ],
    ]);
});

// Health check endpoint
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
        'environment' => app()->environment(),
    ]);
});

// Catch all other routes and redirect to frontend or return 404
Route::fallback(function () {
    if (config('app.frontend_url')) {
        return redirect(config('app.frontend_url'));
    }
    
    return response()->json([
        'message' => 'Page not found.',
    ], 404);
});