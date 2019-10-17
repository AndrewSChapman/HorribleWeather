<?php

namespace App\Domains\Weather\Service\WeatherPersister;

use App\Domains\Weather\Collection\WeatherItemCollection;

interface WeatherPersisterInterface
{
    public function persistWeatherItems(WeatherItemCollection $items): void;
}
