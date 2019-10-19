<?php

namespace App\Tests\Unit\Domains\Weather\Entity;

use App\Core\Type\CreatedAt;
use App\Core\Type\UpdatedAt;
use App\Domains\Weather\Entity\WeatherItem;
use App\Domains\Weather\Enum\WeatherType;
use App\Domains\Location\Type\LocationId;
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
        $locationId = new LocationId('', true);
        $weatherType = new WeatherType(WeatherType::Rain);
        $weatherDescription = new WeatherDescription('Light rain');
        $temperature = new Temperature(11.5);
        $windSpeed = new WindSpeed(0.5);
        $weatherIcon = new WeatherIcon('09d');

        $weatherItem = new WeatherItem(
            $id,
            $locationId,
            $weatherType,
            $weatherDescription,
            $temperature,
            $windSpeed,
            $weatherIcon
        );

        $this->assertEquals($id->getUuid(), $weatherItem->getId()->getUuid());
        $this->assertEquals($locationId->getUuid(), $weatherItem->getLocationId()->getUuid());
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
        $locationId = new LocationId('', true);
        $weatherDescription = new WeatherDescription('Light rain');
        $temperature = new Temperature(11.5);
        $windSpeed = new WindSpeed(0.5);
        $weatherIcon = new WeatherIcon('09d');
        $createdAt = new CreatedAt('2019-10-12 17:00:00');
        $updatedAt = new UpdatedAt('2019-10-12 17:05:05');

        $weatherItem = new WeatherItem(
            $id,
            $locationId,
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

    /**
     * @dataProvider getWeatherItemScoringFactors
     */
    public function testWeatherItemScoring(int $temperature, string $weatherType, int $windSpeed, int $expectedScore)
    {
        $weatherItem = new WeatherItem(
            new WeatherItemId('', true),
            new LocationId('', true),
            new WeatherType($weatherType),
            new WeatherDescription('Not relevant'),
            new Temperature($temperature),
            new WindSpeed($windSpeed),
            new WeatherIcon('09d')
        );

        $this->assertEquals($expectedScore, $weatherItem->getScore()->getValue());
    }

    /**
     *
     * @return array
     */
    public function getWeatherItemScoringFactors(): array
    {
       return [
           [-3, WeatherType::Thunderstorm, 30, 30],
           [-3, WeatherType::Tornado, 30, 30],
           [-3, WeatherType::Dust, 30, 30],
           [-3, WeatherType::Ash, 30, 30],
           [-3, WeatherType::Sand, 30, 30],
           [37, WeatherType::Thunderstorm, 30, 30],
           [-2, WeatherType::Thunderstorm, 30, 25],
           [31, WeatherType::Thunderstorm, 30, 25],
           [-2, WeatherType::Thunderstorm, 30, 25],
           [12, WeatherType::Thunderstorm, 30, 23],
           [30, WeatherType::Thunderstorm, 30, 23],
           [14, WeatherType::Thunderstorm, 30, 20],
           [29, WeatherType::Thunderstorm, 30, 20],

           [-3, WeatherType::Snow, 30, 25],
           [-3, WeatherType::Rain, 30, 25],
           [-3, WeatherType::Smoke, 30, 25],

           [-3, WeatherType::Mist, 30, 23],
           [-3, WeatherType::Clouds, 30, 23],
           [-3, WeatherType::Drizzle, 30, 23],
           [-3, WeatherType::Fog, 30, 23],
           [-3, WeatherType::Haze, 30, 23],
           [-3, WeatherType::Squall, 30, 23],

           [-3, WeatherType::ClearConditions, 30, 20],
           [-2, WeatherType::ClearConditions, 30, 15],
           [31, WeatherType::ClearConditions, 30, 15],
           [12, WeatherType::ClearConditions, 30, 13],
           [30, WeatherType::ClearConditions, 30, 13],
           [14, WeatherType::ClearConditions, 30, 10],
           [29, WeatherType::ClearConditions, 30, 10],

           [14, WeatherType::ClearConditions, 29, 5],
           [14, WeatherType::ClearConditions, 20, 5],
           [14, WeatherType::ClearConditions, 19, 3],
           [14, WeatherType::ClearConditions, 10, 3],
           [14, WeatherType::ClearConditions, 9, 0],
           [14, WeatherType::ClearConditions, 0, 0],
       ];
    }
}
