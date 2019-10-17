<?php
namespace Tests\Integration\Domains\Weather\Service;

use App\Domains\Location\Collection\LocationEntityCollection;
use App\Domains\Weather\Service\WeatherFetcher\OpenWeatherFetcher;
use App\Testing\UnitTestDataHelper;
use PHPUnit\Framework\TestCase;

class OpenWeatherFetcherServiceTest extends TestCase
{
    public function testOpenWeatherFetcherWillFetchWeatherForLocations(): void
    {
        $helper = new UnitTestDataHelper();

        $locations = new LocationEntityCollection();
        $locations->add($helper->location()->createLocationEntity());
        $locations->add($helper->location()->createLocationEntity());

        $service = new OpenWeatherFetcher();
        $items = $service->fetchCurrentWeather($locations);

        $this->assertCount(2, $items);
    }
}
