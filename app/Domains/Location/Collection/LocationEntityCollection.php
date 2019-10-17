<?php

namespace App\Domains\Location\Collection;

use App\Core\Data\AbstractCollection;
use App\Domains\Location\Entity\LocationEntity;

class LocationEntityCollection extends AbstractCollection
{
    public function add(LocationEntity $weatherLocation): void
    {
        $this->values[] = $weatherLocation;
    }

    public function current(): LocationEntity
    {
        return $this->offsetGet($this->iteratorPointer);
    }

    public function offsetGet($offset): LocationEntity
    {
        return $this->values[$offset];
    }
}
