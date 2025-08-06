<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\EmailVerificationNotification;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthService
{
    /**
     * Register a new user.
     */
    public function register(array $data): User
    {
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'is_active' => true,
        ]);

        // Send email verification notification
        $user->notify(new EmailVerificationNotification());

        return $user;
    }

    /**
     * Login user.
     */
    public function login(array $credentials, bool $remember = false): array
    {
        // Allow login with username or email
        $loginField = filter_var($credentials['email'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $loginCredentials = [
            $loginField => $credentials['email'],
            'password' => $credentials['password'],
        ];

        if (!Auth::attempt($loginCredentials, $remember)) {
            return [
                'success' => false,
                'message' => 'Invalid credentials.',
            ];
        }

        $user = Auth::user();

        if (!$user->is_active) {
            Auth::logout();
            return [
                'success' => false,
                'message' => 'Your account has been deactivated.',
            ];
        }

        // Update last login
        $user->update(['last_login_at' => now()]);

        // Create token
        $token = $user->createToken('auth-token')->plainTextToken;

        return [
            'success' => true,
            'user' => $user,
            'token' => $token,
        ];
    }

    /**
     * Logout user.
     */
    public function logout(User $user): void
    {
        $user->currentAccessToken()->delete();
        Auth::logout();
    }

    /**
     * Refresh user token.
     */
    public function refreshToken(User $user): string
    {
        $user->currentAccessToken()->delete();
        return $user->createToken('auth-token')->plainTextToken;
    }

    /**
     * Verify email address.
     */
    public function verifyEmail(string $token, string $email): array
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return [
                'success' => false,
                'message' => 'User not found.',
            ];
        }

        if ($user->hasVerifiedEmail()) {
            return [
                'success' => false,
                'message' => 'Email already verified.',
            ];
        }

        // In a real implementation, you would verify the token
        // For now, we'll just mark the email as verified
        $user->markEmailAsVerified();

        return [
            'success' => true,
            'user' => $user,
        ];
    }

    /**
     * Resend email verification.
     */
    public function resendVerification(string $email): array
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return [
                'success' => false,
                'message' => 'User not found.',
            ];
        }

        if ($user->hasVerifiedEmail()) {
            return [
                'success' => false,
                'message' => 'Email already verified.',
            ];
        }

        $user->notify(new EmailVerificationNotification());

        return [
            'success' => true,
            'message' => 'Verification email sent.',
        ];
    }

    /**
     * Send password reset link.
     */
    public function sendPasswordResetLink(string $email): array
    {
        $status = Password::sendResetLink(['email' => $email]);

        return [
            'success' => $status === Password::RESET_LINK_SENT,
            'message' => $status === Password::RESET_LINK_SENT
                ? 'Password reset link sent to your email.'
                : 'Unable to send password reset link.',
        ];
    }

    /**
     * Reset password.
     */
    public function resetPassword(string $token, string $email, string $password): array
    {
        $status = Password::reset(
            ['email' => $email, 'password' => $password, 'token' => $token],
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        return [
            'success' => $status === Password::PASSWORD_RESET,
            'message' => $status === Password::PASSWORD_RESET
                ? 'Password reset successfully.'
                : 'Unable to reset password.',
        ];
    }
}