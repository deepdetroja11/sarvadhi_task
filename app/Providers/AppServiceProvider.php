<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Schema::defaultStringLength(191);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            $isAdmin = false;
            $isUser = false;
            if (Auth::check()) {
                $user = Auth::user();
                $isAdmin = $user->role == 1;
                $isUser = $user->role == 0;
                Log::info('Authenticated user role:', ['role' => $user->role]);
            }

            $view->with('isAdmin', $isAdmin);
            $view->with('isUser', $isUser);
        });
    }
}
