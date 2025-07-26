<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompleteSocialiteRequest;
use App\Models\AuthProvider;
use App\Services\UserRegistrationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function __construct(
        private UserRegistrationService $userRegistrationService
    ) {}

    public function redirect(string $provider): RedirectResponse
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback(string $provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();

            $authProvider = AuthProvider::findByProvider($provider, $socialUser->getId());

            if ($authProvider) {
                $authProvider->update([
                    'nickname' => $socialUser->getNickname() ?? $socialUser->getName(),
                    'avatar' => $socialUser->getAvatar(),
                    'token' => $socialUser->token,
                    'login_at' => now(),
                ]);

                Auth::login($authProvider->user);

                return redirect()->intended('/');
            }

            session()->put('socialite_data', [
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
                'nickname' => $socialUser->getNickname() ?? $socialUser->getName(),
                'email' => $socialUser->getEmail(),
                'avatar' => $socialUser->getAvatar(),
                'token' => $socialUser->token,
            ]);

            return redirect()->route('auth.socialite.complete');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Authentication error with '.ucfirst($provider));
        }
    }

    public function showCompleteForm()
    {
        $socialiteData = session()->get('socialite_data');

        if (! $socialiteData) {
            return redirect()->route('login')->with('error', 'Authentication data not found');
        }

        return Inertia::render('auth/complete-socialite', [
            'socialiteData' => $socialiteData,
        ]);
    }

    public function complete(CompleteSocialiteRequest $request)
    {
        $socialiteData = session()->get('socialite_data');

        if (! $socialiteData) {
            return redirect()->route('login')->with('error', 'Authentication data not found');
        }

        $user = $this->userRegistrationService->createUserWithProvider(
            $request->getUserData($socialiteData['email']),
            $socialiteData
        );

        session()->forget('socialite_data');

        return $this->userRegistrationService->loginAndRedirect($user);
    }
}
