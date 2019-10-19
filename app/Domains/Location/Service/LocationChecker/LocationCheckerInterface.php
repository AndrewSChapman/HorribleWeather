<?php

namespace App\Domains\Location\Service\LocationChecker;

use App\Domains\Location\Type\LocationName;
use App\Domains\Weather\Entity\WeatherItem;

interface LocationCheckerInterface
{
    public function tryLocation(LocationName $locationName): ?WeatherItem;
}
