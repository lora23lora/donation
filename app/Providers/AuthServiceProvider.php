<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Storage_Donation;
use App\Models\User;
use App\Models\Zakat;
use App\Policies\DonationPolicy;
use App\Policies\Storage_DonationPolicy;
use App\Policies\ZakatPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Zakat::class => ZakatPolicy::class,
        Storage_Donation::class => Storage_DonationPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('viewTotalAmount', function (User $user) {

        });    }
}
