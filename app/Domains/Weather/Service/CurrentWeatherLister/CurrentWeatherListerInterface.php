<?php

namespace App\Domains\Weather\Service\CurrentWeatherLister;

use App\Domains\Weather\Collection\WeatherItemCollection;

interface CurrentWeatherListerInterface
{
    public function getCurrentWeather(): WeatherItemCollection;
}
