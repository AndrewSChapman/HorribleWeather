<?php

namespace App\Domains\Location\Service\LocationPersister;

use App\Domains\Location\Type\LocationName;

interface LocationPersisterInterface
{
    public function persistLocation(LocationName $locationName): void;
}
