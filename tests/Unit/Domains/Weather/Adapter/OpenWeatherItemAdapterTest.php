<?php

namespace App\Tests\Unit\Domains\Weather\Adapter;

use App\Domains\Weather\Adapter\OpenWeatherItemAdapter;
use App\Domains\Weather\Enum\WeatherType;
use PHPUnit\Framework\TestCase;

class OpenWeatherItemAdapterTest extends TestCase
{
    public function testOpenWeatherItemAdapterWillConvertJsonToEntity(): void
    {
        $itemJson = $this->getItemJson();

        $adapter = new OpenWeatherItemAdapter();
        $weatherItem = $adapter->jsonToEntity($itemJson);

        $this->assertEquals(WeatherType::Rain, (string)$weatherItem->getType());
        $this->assertEquals('shower rain', $weatherItem->getDescription()->toString());
        $this->assertEquals(13.47, $weatherItem->getTemperature()->getValue());
        $this->assertEquals(4.6, $weatherItem->getWindSpeed()->getValue());
    }

    private function getItemJson(): string
    {
        $json = <<<JSON
{
    "coord": {
        "lon": -5.22,
        "lat": 50.23
    },
    "weather": [
        {
            "id": 521,
            "main": "Rain",
            "description": "shower rain",
            "icon": "09d"
        }
    ],
    "base": "stations",
    "main": {
        "temp": 13.47,
        "pressure": 1008,
        "humidity": 93,
        "temp_min": 13,
        "temp_max": 15
    },
    "visibility": 10000,
    "wind": {
        "speed": 4.6,
        "deg": 170
    },
    "clouds": {
        "all": 40
    },
    "dt": 1570882635,
    "sys": {
        "type": 1,
        "id": 1403,
        "message": 0.0075,
        "country": "GB",
        "sunrise": 1570862243,
        "sunset": 1570901832
    },
    "timezone": 3600,
    "id": 2639524,
    "name": "Redruth",
    "cod": 200
}
JSON;

        return $json;
    }
}
