<?php

namespace App\Domains\Weather\Adapter;

use App\Core\Type\CreatedAt;
use App\Core\Type\Exception\InvalidJsonException;
use App\Core\Type\Timestamp;
use App\Core\Type\UpdatedAt;
use App\Domains\Weather\Entity\WeatherItem;
use App\Domains\Weather\Enum\WeatherType;
use App\Domains\Location\Type\LocationId;
use App\Domains\Weather\Type\Temperature;
use App\Domains\Weather\Type\WeatherDescription;
use App\Domains\Weather\Type\WeatherIcon;
use App\Domains\Weather\Type\WeatherItemId;
use App\Domains\Weather\Type\WindSpeed;

class OpenWeatherItemAdapter
{
    /**
     * Converts an OpenWeather JSON string to a WeatherItem identity
     * @param LocationId $locationId
     * @param string $json
     * @param Timestamp|null $timestamp
     * @return WeatherItem
     * @throws \ReflectionException
     */
    public function jsonToEntity(LocationId $locationId, string $json, ?Timestamp $timestamp = null): WeatherItem
    {
        if (empty($json)) {
            throw new InvalidJsonException(OpenWeatherItemAdapter::class, 'Json string is empty');
        }

        $item = @json_decode($json);

        if ((!isset($item->weather)) || (!is_array($item->weather)) ||
            (empty($item->weather))) {
            throw new InvalidJsonException(OpenWeatherItemAdapter::class, 'Weather attribute missing');
        }

        if (!isset($item->main)) {
            throw new InvalidJsonException(OpenWeatherItemAdapter::class, 'Main attribute missing');
        }

        if (!isset($item->wind)) {
            throw new InvalidJsonException(OpenWeatherItemAdapter::class, 'Wind attribute missing');
        }

        $weatherItemId = new WeatherItemId('', true);
        $weatherType = new WeatherType($item->weather[0]->main);
        $weatherDescription = new WeatherDescription($item->weather[0]->description);
        $weatherIcon = new WeatherIcon($item->weather[0]->icon);
        $temperature = new Temperature($item->main->temp);
        $windSpeed = new WindSpeed($item->wind->speed);
        $createdAt = new CreatedAt($timestamp);
        $updatedAt = new UpdatedAt($timestamp);

        $item = new WeatherItem(
            $weatherItemId,
            $locationId,
            $weatherType,
            $weatherDescription,
            $temperature,
            $windSpeed,
            $weatherIcon,
            $createdAt,
            $updatedAt
        );

        return $item;
    }
}
