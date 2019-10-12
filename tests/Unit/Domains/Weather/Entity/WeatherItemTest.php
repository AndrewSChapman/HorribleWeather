<?php

namespace App\Tests\Unit\Domains\Weather\Entity;

use App\Core\Type\CreatedAt;
use App\Core\Type\UpdatedAt;
use App\Domains\Weather\Entity\WeatherItem;
use App\Domains\Weather\Enum\WeatherType;
use App\Domains\Weather\Type\Temperature;
use App\Domains\Weather\Type\WeatherDescription;
use App\Domains\Weather\Type\WeatherIcon;
use App\Domains\Weather\Type\WeatherItemId;
use App\Domains\Weather\Type\WindSpeed;
use PHPUnit\Framework\TestCase;

class WeatherItemTest extends TestCase
{
    public function testWeatherItemWillConstructCorrectlyWithoutTimestampsSpecified(): void
    {
        $id = new WeatherItemId('', true);
        $weatherType = new WeatherType(WeatherType::Rain);
        $weatherDescription = new WeatherDescription('Light rain');
        $temperature = new Temperature(11.5);
        $windSpeed = new WindSpeed(0.5);
        $weatherIcon = new WeatherIcon('09d');

        $weatherItem = new WeatherItem($id, $weatherType, $weatherDescription, $temperature, $windSpeed, $weatherIcon);

        $this->assertEquals($id->getUuid(), $weatherItem->getId()->getUuid());
        $this->assertEquals($weatherType, $weatherItem->getType());
        $this->assertEquals('Light rain', $weatherItem->getDescription()->toString());
        $this->assertEquals(11.5, $weatherItem->getTemperature()->getValue());
        $this->assertEquals(0.5, $weatherItem->getWindSpeed()->getValue());
        $this->assertEquals('09d', $weatherIcon->toString());
        $this->assertGreaterThan(time() - 10, $weatherItem->getCreatedAt()->getTimestamp());
        $this->assertGreaterThan(time() - 10, $weatherItem->getUpdatedAt()->getTimestamp());
    }

    public function testWeatherItemWillConstructCorrectlyWithTimestampsSpecified(): void
    {
        $id = new WeatherItemId('', true);
        $weatherType = new WeatherType(WeatherType::Rain);
        $weatherDescription = new WeatherDescription('Light rain');
        $temperature = new Temperature(11.5);
        $windSpeed = new WindSpeed(0.5);
        $weatherIcon = new WeatherIcon('09d');
        $createdAt = new CreatedAt('2019-10-12 17:00:00');
        $updatedAt = new UpdatedAt('2019-10-12 17:05:05');

        $weatherItem = new WeatherItem(
            $id,
            $weatherType,
            $weatherDescription,
            $temperature,
            $windSpeed,
            $weatherIcon,
            $createdAt,
            $updatedAt
        );

        $this->assertEquals(1570899600, $weatherItem->getCreatedAt()->getTimestamp());
        $this->assertEquals(1570899905, $weatherItem->getUpdatedAt()->getTimestamp());
    }
}
