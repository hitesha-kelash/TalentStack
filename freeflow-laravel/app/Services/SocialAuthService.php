<?php

namespace App\Services;

use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Laravel\Socialite\Contracts\User as SocialiteUser;

class SocialAuthService
{
    /**
     * Handle social provider callback.
     */
    public function handleCallback(string $provider, SocialiteUser $socialUser): array
    {
        return DB::transaction(function () use ($provider, $socialUser) {
            // Check if social account exists
            $socialAccount = SocialAccount::where('provider', $provider)
                ->where('provider_id', $socialUser->getId())
                ->first();

            if ($socialAccount) {
                // Update social account token
                $socialAccount->update([
                    'provider_token' => $socialUser->token,
                    'provider_refresh_token' => $socialUser->refreshToken,
                ]);

                $user = $socialAccount->user;
            } else {
                // Check if user exists with this email
                $user = User::where('email', $socialUser->getEmail())->first();

                if (!$user) {
                    // Create new user
                    $names = $this->parseFullName($socialUser->getName());
                    $username = $this->generateUniqueUsername($socialUser->getNickname() ?: $names['first_name']);

                    $user = User::create([
                        'first_name' => $names['first_name'],
                        'last_name' => $names['last_name'],
                        'username' => $username,
                        'email' => $socialUser->getEmail(),
                        'password' => Hash::make(Str::random(32)), // Random password
                        'avatar' => $socialUser->getAvatar(),
                        'email_verified_at' => now(),
                        'is_active' => true,
                    ]);
                }

                // Create social account
                SocialAccount::create([
                    'user_id' => $user->id,
                    'provider' => $provider,
                    'provider_id' => $socialUser->getId(),
                    'provider_token' => $socialUser->token,
                    'provider_refresh_token' => $socialUser->refreshToken,
                ]);
            }

            // Update last login
            $user->update(['last_login_at' => now()]);

            // Create token
            $token = $user->createToken('social-auth-token')->plainTextToken;

            return [
                'user' => $user,
                'token' => $token,
            ];
        });
    }

    /**
     * Parse full name into first and last name.
     */
    private function parseFullName(?string $fullName): array
    {
        if (!$fullName) {
            return ['first_name' => 'User', 'last_name' => ''];
        }

        $parts = explode(' ', trim($fullName), 2);
        
        return [
            'first_name' => $parts[0] ?? 'User',
            'last_name' => $parts[1] ?? '',
        ];
    }

    /**
     * Generate unique username.
     */
    private function generateUniqueUsername(string $baseUsername): string
    {
        $username = Str::slug($baseUsername, '');
        $originalUsername = $username;
        $counter = 1;

        while (User::where('username', $username)->exists()) {
            $username = $originalUsername . $counter;
            $counter++;
        }

        return $username;
    }
}