<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function __construct(
        private AuthService $authService
    ) {}

    /**
     * Register a new user.
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $user = $this->authService->register($request->validated());
            
            event(new Registered($user));

            return response()->json([
                'message' => 'Registration successful. Please check your email to verify your account.',
                'user' => $user->only(['id', 'first_name', 'last_name', 'email', 'username']),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Registration failed.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Login user.
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $credentials = $request->only(['email', 'password']);
            $remember = $request->boolean('remember');

            $result = $this->authService->login($credentials, $remember);

            if (!$result['success']) {
                throw ValidationException::withMessages([
                    'email' => [$result['message']],
                ]);
            }

            return response()->json([
                'message' => 'Login successful.',
                'user' => $result['user'],
                'token' => $result['token'],
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Login failed.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Login failed.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Logout user.
     */
    public function logout(Request $request): JsonResponse
    {
        try {
            $this->authService->logout($request->user());

            return response()->json([
                'message' => 'Logout successful.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Logout failed.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get authenticated user.
     */
    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'user' => $request->user()->load(['roles', 'permissions']),
        ]);
    }

    /**
     * Refresh user token.
     */
    public function refresh(Request $request): JsonResponse
    {
        try {
            $token = $this->authService->refreshToken($request->user());

            return response()->json([
                'token' => $token,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Token refresh failed.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Verify email address.
     */
    public function verifyEmail(Request $request): JsonResponse
    {
        $request->validate([
            'token' => 'required|string',
            'email' => 'required|email',
        ]);

        try {
            $result = $this->authService->verifyEmail($request->token, $request->email);

            if (!$result['success']) {
                return response()->json([
                    'message' => $result['message'],
                ], 400);
            }

            return response()->json([
                'message' => 'Email verified successfully.',
                'user' => $result['user'],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Email verification failed.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Resend email verification.
     */
    public function resendVerification(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        try {
            $result = $this->authService->resendVerification($request->email);

            if (!$result['success']) {
                return response()->json([
                    'message' => $result['message'],
                ], 400);
            }

            return response()->json([
                'message' => 'Verification email sent successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to send verification email.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Send password reset link.
     */
    public function forgotPassword(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        try {
            $result = $this->authService->sendPasswordResetLink($request->email);

            return response()->json([
                'message' => $result['message'],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to send password reset email.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Reset password.
     */
    public function resetPassword(Request $request): JsonResponse
    {
        $request->validate([
            'token' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            $result = $this->authService->resetPassword(
                $request->token,
                $request->email,
                $request->password
            );

            if (!$result['success']) {
                return response()->json([
                    'message' => $result['message'],
                ], 400);
            }

            return response()->json([
                'message' => 'Password reset successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Password reset failed.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}