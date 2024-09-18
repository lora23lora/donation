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
use App\Models\Storage as ModelsStorage;
use App\Nova\City;
use App\Nova\Income;
use App\Nova\ItemCategory;
use App\Nova\ItemDonated;
use App\Nova\Lenses\CityWithMostBeneficiary;
use App\Nova\Lenses\DonationStorageLens;
use App\Nova\Lenses\ExpenseReport;
use App\Nova\Lenses\ItemReport;
use App\Nova\Status;
use App\Nova\Superviser;
use App\Nova\Zakat;
use Laravel\Nova\Menu\MenuGroup;
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
               MenuSection::resource(Income::class)->icon('currency-dollar'),
               MenuSection::resource(Donation::class)->icon('calculator'),
               MenuSection::resource(Zakat::class)->icon('book-open'),
               MenuSection::resource(Beneficiary::class)->icon('clipboard-list'),
               MenuSection::resource(Storage::class)->icon('home'),
               MenuSection::resource(User::class)->icon('user'),
               MenuSection::lens(ItemDonated::class, DonationStorageLens::class)->icon('presentation-chart-line'),
            //    MenuSection::lens(Storage::class, ItemReport::class)->icon('presentation-chart-line'),
               MenuSection::make(__('Others'), [
                   MenuItem::resource(City::class),
                   MenuItem::resource(Status::class),
                   MenuItem::resource(Superviser::class),
                   MenuItem::resource(ItemCategory::class),
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
