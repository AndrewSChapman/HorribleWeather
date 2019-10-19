<?php
namespace Tests\Integration\Domains\Weather\Service;

use App\Domains\Location\Collection\LocationEntityCollection;
use App\Domains\Location\Entity\LocationEntity;
use App\Domains\Location\Exception\InvalidLocationException;
use App\Domains\Location\Type\LocationId;
use App\Domains\Location\Type\LocationName;
use App\Domains\Weather\Service\WeatherFetcher\OpenWeatherFetcher;
use App\Testing\UnitTestDataHelper\UnitTestDataHelper;
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

    public function testOpenWeatherFetcherWillThrowInvalidLocationExceptionIfLocationInvalid(): void
    {
        $this->expectException(InvalidLocationException::class);

        $locations = new LocationEntityCollection();
        $locations->add(
            new LocationEntity(
                new LocationId('', true),
                new LocationName('Bleg,uk')
            )
        );

        $service = new OpenWeatherFetcher();
        $items = $service->fetchCurrentWeather($locations);
    }
}
