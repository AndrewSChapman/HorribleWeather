<?php

namespace App\Domains\Weather\Service\WeatherFetcher;

use App\Domains\Weather\Collection\WeatherItemCollection;
use App\Domains\Location\Collection\LocationEntityCollection;

interface WeatherFetcherInterface
{
    /**
     * Fetches the current weather for the specification locations.
     * @param LocationEntityCollection $weatherLocationCollection
     * @return WeatherItemCollection
     */
    public function fetchCurrentWeather(LocationEntityCollection $weatherLocationCollection): WeatherItemCollection;
}
