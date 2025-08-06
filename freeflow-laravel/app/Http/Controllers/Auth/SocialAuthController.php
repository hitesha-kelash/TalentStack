<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\SocialAuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function __construct(
        private SocialAuthService $socialAuthService
    ) {}

    /**
     * Redirect to social provider.
     */
    public function redirect(string $provider): RedirectResponse
    {
        $this->validateProvider($provider);

        return Socialite::driver($provider)->redirect();
    }

    /**
     * Handle social provider callback.
     */
    public function callback(string $provider): JsonResponse|RedirectResponse
    {
        try {
            $this->validateProvider($provider);

            $socialUser = Socialite::driver($provider)->user();
            $result = $this->socialAuthService->handleCallback($provider, $socialUser);

            if (request()->expectsJson()) {
                return response()->json([
                    'message' => 'Social login successful.',
                    'user' => $result['user'],
                    'token' => $result['token'],
                ]);
            }

            // Redirect to frontend with token
            $frontendUrl = config('app.frontend_url', config('app.url'));
            return redirect()->to("{$frontendUrl}/auth/callback?token={$result['token']}");
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'message' => 'Social login failed.',
                    'error' => $e->getMessage(),
                ], 500);
            }

            $frontendUrl = config('app.frontend_url', config('app.url'));
            return redirect()->to("{$frontendUrl}/auth/login?error=social_login_failed");
        }
    }

    /**
     * Validate social provider.
     */
    private function validateProvider(string $provider): void
    {
        $allowedProviders = ['github', 'google'];

        if (!in_array($provider, $allowedProviders)) {
            abort(404, 'Provider not supported.');
        }
    }
}