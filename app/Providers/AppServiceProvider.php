<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use App\Models\Transaction;
use App\Models\Report;
use App\Policies\TransactionPolicy;
use App\Policies\ReportPolicy;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Gate::policy(Transaction::class, TransactionPolicy::class);
        Gate::policy(Report::class, ReportPolicy::class);

        // Menu gates
        Gate::define('create-menu', function ($user) {
            return $user->role === 'owner';
        });

        Gate::define('update-menu', function ($user) {
            return $user->role === 'owner';
        });

        Gate::define('delete-menu', function ($user) {
            return $user->role === 'owner';
        });
        
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}
