<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Contracts\LogoutResponse;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Personnalisation des redirections (logout)
        $this->app->instance(LogoutResponse::class, new class implements LogoutResponse {
            public function toResponse($request)
            {
                return redirect('/');
            }
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(5)->by($email.$request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        // Personnalisation de l'authentification des utilisateurs
        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('email', $request->email)->first();
     
            if ($user &&
                Hash::check($request->password, $user->password)) {
                return $user;
            }
        });

        // redirection vers le formulaire de connexion
        Fortify::loginView(function () {
            return view('auth.login');
        });

        // Authentification  deux facteurs
        Fortify::twoFactorChallengeView(function () {
            return view('auth.two-factor-challenge');
        });

        // Inscription
        Fortify::registerView(function () {
            return view('auth.register');
        });

        // Notification d'envoie du lien de reinitialisation du mot de passe
        Fortify::requestPasswordResetLinkView(function () {
            return view('auth.forgot-password');
        });

        // Reinitialiser le mot de passe
        Fortify::resetPasswordView(function (Request $request) {
            return view('auth.passwords.reset', ['request' => $request]);
        });

        // Verification de l'email
        Fortify::verifyEmailView(function () {
            return view('auth.verify-email');
        });

        // Confirmation du mot de passe
        Fortify::confirmPasswordView(function () {
            return view('auth.passwords.confirm');
        });
    }
}
