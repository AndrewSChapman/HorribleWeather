<?php

namespace App\Domains\Weather\Type;

use App\Core\Type\ConstrainedString;

class WeatherIcon extends ConstrainedString
{
    /**
     * WeatherIcon constructor.
     */
    public function __construct(string $icon)
    {
        parent::__construct($icon, 1, 20);
    }
}
