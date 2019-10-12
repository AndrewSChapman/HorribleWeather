<?php

namespace App\Domains\Weather\Collection;

use App\Core\Data\AbstractCollection;
use App\Domains\Weather\Entity\WeatherItem;

class WeatherItemCollection extends AbstractCollection
{
    public function add(WeatherItem $weatherItem): void
    {
        $this->values[] = $weatherItem;
    }

    public function current(): WeatherItem
    {
        return $this->offsetGet($this->iteratorPointer);
    }

    public function offsetGet($offset): WeatherItem
    {
        return $this->values[$offset];
    }
}
