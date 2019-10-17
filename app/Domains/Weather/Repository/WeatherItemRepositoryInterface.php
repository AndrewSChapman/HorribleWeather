<?php

namespace App\Domains\Weather\Repository;

use App\Domains\Weather\Collection\WeatherItemCollection;
use App\Domains\Weather\Entity\WeatherItem;

interface WeatherItemRepositoryInterface
{
    public function save(WeatherItem $weatherItem): void;
    public function getCurrentWeather(): WeatherItemCollection;
}
