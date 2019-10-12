<?php

namespace App\Domains\Weather\Service\WeatherFetcher;

use App\Domains\Weather\Collection\WeatherItemCollection;
use App\Domains\Weather\Collection\WeatherLocationCollection;

interface WeatherFetcherInterface
{
    /**
     * Fetches the current weather for the specification locations.
     * @param WeatherLocationCollection $weatherLocationCollection
     * @return WeatherItemCollection
     */
    public function fetchCurrentWeather(WeatherLocationCollection $weatherLocationCollection): WeatherItemCollection;
}
