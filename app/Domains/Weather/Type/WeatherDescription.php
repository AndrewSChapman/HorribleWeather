<?php

namespace App\Domains\Weather\Type;

use App\Core\Type\Varchar255Required;

class WeatherDescription extends Varchar255Required
{
    public function __construct(string $description)
    {
        parent::__construct($description);
    }
}
