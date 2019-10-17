<?php

namespace App\Domains\Location\Service\LocationLister;

use App\Domains\Location\Collection\LocationEntityCollection;

interface LocationListerInterface
{
    public function getList(): LocationEntityCollection;
}
