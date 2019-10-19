<?php
namespace Tests\Integration\Domains\Weather\Repository;

use App\Domains\Location\Repository\LocationRepository\LocationRepository;
use App\Domains\Location\Type\LocationId;
use App\Domains\Location\Type\LocationName;
use App\Domains\Weather\Repository\WeatherItemRepository;
use App\Testing\UnitTestDataHelper\UnitTestDataHelper;
use Tests\IntegrationTestCase;

class WeatherItemRepositoryIntegrationTest extends IntegrationTestCase
{
    public function testRepositoryWillSaveWeatherItem(): void
    {
        $helper = new UnitTestDataHelper();

        $location = $helper->location()->createLocationEntity();
        $weatherItem = $helper->getWeatherItem($location->getId());

        // We must have a location in order to save a weather item
        $locationRepo = new LocationRepository();
        $locationRepo->save($location);

        $weatherRepo = new WeatherItemRepository();
        $weatherRepo->save($weatherItem);

        $this->assertTrue(true);
    }

    public function testRepositoryWillGetCurrentWeatherList(): void
    {
        $helper = new UnitTestDataHelper();
        $location1 = $helper->location()->createLocationEntity(new LocationName('AAA,uk'));
        $location2 = $helper->location()->createLocationEntity(new LocationName('BBB,uk'));
        $locationRepo = new LocationRepository();
        $locationRepo->save($location1);
        $locationRepo->save($location2);

        $repo = new WeatherItemRepository();

        // Ensure there's a couple of items in the database
        $helper = new UnitTestDataHelper();
        $weatherItem = $helper->getWeatherItem($location1->getId());
        $repo->save($weatherItem);

        $weatherItem = $helper->getWeatherItem($location2->getId());
        $repo->save($weatherItem);

        // Get a list
        $weatherItems = $repo->getCurrentWeather();
        self::assertGreaterThan(1, count($weatherItems));

        $hasLocation1 = false;
        $hasLocation2 = false;

        foreach ($weatherItems as $weatherItem) {
            if ($weatherItem->getLocationId()->getUuid() == $location1->getId()->getUuid()) {
                $hasLocation1 = true;
            }

            if ($weatherItem->getLocationId()->getUuid() == $location2->getId()->getUuid()) {
                $hasLocation2 = true;
            }
        }

        $this->assertTrue($hasLocation1);
        $this->assertTrue($hasLocation2);
    }
}
