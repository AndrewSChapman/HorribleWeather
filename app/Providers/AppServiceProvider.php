<?php

namespace App\Providers;

use App\Domains\Location\Repository\LocationRepository\LocationRepository;
use App\Domains\Location\Repository\LocationRepository\LocationRepositoryInterface;
use App\Domains\Location\Service\LocationChecker\LocationChecker;
use App\Domains\Location\Service\LocationChecker\LocationCheckerInterface;
use App\Domains\Location\Service\LocationLister\LocationLister;
use App\Domains\Location\Service\LocationLister\LocationListerInterface;
use App\Domains\Location\Service\LocationPersister\LocationPersister;
use App\Domains\Location\Service\LocationPersister\LocationPersisterInterface;
use App\Domains\Weather\Repository\WeatherItemRepository;
use App\Domains\Weather\Repository\WeatherItemRepositoryInterface;
use App\Domains\Weather\Service\CurrentWeatherLister\CurrentWeatherLister;
use App\Domains\Weather\Service\CurrentWeatherLister\CurrentWeatherListerInterface;
use App\Domains\Weather\Service\WeatherFetcher\OpenWeatherFetcher;
use App\Domains\Weather\Service\WeatherFetcher\WeatherFetcherInterface;
use App\Domains\Weather\Service\WeatherPersister\WeatherPersister;
use App\Domains\Weather\Service\WeatherPersister\WeatherPersisterInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerWeatherServices();
        $this->registerLocationServices();
    }

    private function registerWeatherServices(): void
    {
        $this->app->singleton(WeatherFetcherInterface::class, function($app) {
            return new OpenWeatherFetcher();
        });

        $this->app->singleton(WeatherPersisterInterface::class, function($app) {
            return new WeatherPersister(new WeatherItemRepository());
        });

        $this->app->singleton(WeatherItemRepositoryInterface::class, function($app) {
            return new WeatherItemRepository();
        });

        $this->app->singleton(CurrentWeatherListerInterface::class, function($app) {
            return new CurrentWeatherLister(new WeatherItemRepository());
        });
    }

    private function registerLocationServices(): void
    {
        $this->app->singleton(LocationListerInterface::class, function ($app) {
            return new LocationLister(new LocationRepository());
        });

        $this->app->singleton(LocationCheckerInterface::class, function ($app) {
            return new LocationChecker(new OpenWeatherFetcher());
        });

        $this->app->singleton(LocationRepositoryInterface::class, function ($app) {
            return new LocationRepository();
        });

        $this->app->singleton(LocationPersisterInterface::class, function ($app) {
            return new LocationPersister(
                $this->app->make(LocationRepositoryInterface::class),
                $this->app->make(LocationCheckerInterface::class)
            );
        });
    }
}
