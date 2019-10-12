<?php
namespace App\Tests\Integration\Domains\Weather\Entity;

use App\Domains\Weather\Collection\WeatherLocationCollection;
use App\Domains\Weather\Enum\WeatherLocation;
use App\Domains\Weather\Service\WeatherFetcher\OpenWeatherFetcher;
use PHPUnit\Framework\TestCase;

class OpenWeatherFetcherServiceTest extends TestCase
{
    public function testOpenWeatherFetcherWillFetchWeatherForLocations(): void
    {
        $locations = new WeatherLocationCollection();
        $locations->add(new WeatherLocation(WeatherLocation::Brighton));
        $locations->add(new WeatherLocation(WeatherLocation::Leeds));

        $service = new OpenWeatherFetcher();
        $items = $service->fetchCurrentWeather($locations);

        $this->assertCount(2, $items);
    }
}
