<?php

namespace App\Domains\Location\Repository\LocationRepository;

use App\Domains\Location\Collection\LocationEntityCollection;
use App\Domains\Location\Entity\LocationEntity;

interface LocationRepositoryInterface
{
    public function save(LocationEntity $location): void;
    public function getAllLocations(): LocationEntityCollection;
}
