<?php

namespace App\Domains\Location\Type;

use App\Core\Type\Varchar50Required;

class LocationName extends Varchar50Required
{
    public function __construct(string $description)
    {
        parent::__construct($description);
    }
}
