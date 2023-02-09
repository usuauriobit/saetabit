<?php

namespace App\Providers;

use App\Actions\Jetstream\DeleteUser;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Laravel\Jetstream\Jetstream;

class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Jetstream::ignoreRoutes();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->configurePermissions();

        Jetstream::deleteUsersUsing(DeleteUser::class);

        Fortify::loginView(function () {
            return view('livewire.landing-page.auth.login');
        });
        Fortify::resetPasswordView(function () {
            return view('livewire.landing-page.auth.forgot-password');
        });
        Fortify::requestPasswordResetLinkView(function () {
            return view('livewire.landing-page.auth.forgot-password');
        });


        Fortify::registerView(function () {
            return view('livewire.landing-page.auth.register');
        });

        Fortify::verifyEmailView(function () {
            return view('livewire.landing-page.auth.forgot-password');
        });
        Fortify::confirmPasswordView(function () {
            return view('livewire.landing-page.auth.forgot-password');
        });
    }

    /**
     * Configure the permissions that are available within the application.
     *
     * @return void
     */
    protected function configurePermissions()
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        Jetstream::permissions([
            'create',
            'read',
            'update',
            'delete',
        ]);
    }
}
