<?php

namespace App\Providers;

use App\Repositories\DistrictPopulations\DistrictPopulationRepository;
use App\Repositories\DistrictPopulations\DistrictPopulationRepositoryInterface;
use App\Repositories\Districts\DistrictRepository;
use App\Repositories\Districts\DistrictRepositoryInterface;
use App\Repositories\Provinces\ProvinceRepository;
use App\Repositories\Provinces\ProvinceRepositoryInterface;
use App\Repositories\Users\UserRepository;
use App\Repositories\Users\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $bindings = [
        UserRepositoryInterface::class               => UserRepository::class,
        ProvinceRepositoryInterface::class           => ProvinceRepository::class,
        DistrictRepositoryInterface::class           => DistrictRepository::class,
        DistrictPopulationRepositoryInterface::class => DistrictPopulationRepository::class,
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
