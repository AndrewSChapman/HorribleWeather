<?php

namespace App\Domains\Weather\Collection;

use App\Core\Data\AbstractCollection;
use App\Domains\Weather\Enum\WeatherLocation;

class WeatherLocationCollection extends AbstractCollection
{
    public function add(WeatherLocation $weatherLocation): void
    {
        $this->values[] = $weatherLocation;
    }

    public function current(): WeatherLocation
    {
        return $this->offsetGet($this->iteratorPointer);
    }

    public function offsetGet($offset): WeatherLocation
    {
        return $this->values[$offset];
    }
}
