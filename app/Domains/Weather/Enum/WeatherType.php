<?php

namespace App\Domains\Weather\Enum;

use App\Core\Type\AbstractEnum;

class WeatherType extends AbstractEnum
{
    public const Ash = 'Ash';
    public const ClearConditions = 'Clear';
    public const Clouds = 'Clouds';
    public const Drizzle = 'Drizzle';
    public const Dust = 'Dust';
    public const Fog = 'Fog';
    public const Haze = 'Haze';
    public const Mist =	'mist';
    public const Rain = 'Rain';
    public const Sand = 'Sand';
    public const Smoke =	'Smoke';
    public const Snow = 'Snow';
    public const Squall = 'Squalls';
    public const Thunderstorm = 'Thunderstorm';
    public const Tornado = 'Tornado';
}
