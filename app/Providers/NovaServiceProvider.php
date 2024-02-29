<?php

namespace App\Providers;

use App\Nova\Beneficiary;
use App\Nova\Dashboards\Main;
use App\Nova\Donation;
use App\Nova\Storage;
use App\Nova\User;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Anaseqal\NovaImport\NovaImport;
use App\Nova\City;
use App\Nova\Lenses\CityWithMostBeneficiary;
use App\Nova\Status;
use App\Nova\Superviser;
use Laravel\Nova\Menu\MenuItem;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Nova::mainMenu(function () {
            return [
               MenuSection::dashboard(Main::class)->icon('chart-bar'),
               MenuSection::resource(Donation::class)->icon('calculator'),
               MenuSection::resource(Beneficiary::class)->icon('clipboard-list'),
               MenuSection::resource(Storage::class)->icon('home'),
               MenuSection::resource(User::class)->icon('user'),
               MenuSection::make(__('Others'), [
                   MenuItem::resource(City::class),
                   MenuItem::resource(Status::class),
                   MenuItem::resource(Superviser::class),
            ])->icon('plus')->collapsable(),
            ];
        });
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return in_array($user->email, [
                //
            ]);
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [
            new \App\Nova\Dashboards\Main,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
            // new NovaImport,
            new \Badinansoft\LanguageSwitch\LanguageSwitch(),        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
