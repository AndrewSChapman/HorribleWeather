<?php
namespace Tests\Integration\Domains\Weather\Repository;

use App\Domains\Location\Type\LocationId;
use App\Domains\Weather\Repository\WeatherItemRepository;
use App\Testing\UnitTestDataHelper;
use Tests\IntegrationTestCase;

class WeatherItemRepositoryIntegrationTest extends IntegrationTestCase
{
    public function testRepositoryWillSaveWeatherItem(): void
    {
        $helper = new UnitTestDataHelper();
        $weatherItem = $helper->getWeatherItem();

        $repo = new WeatherItemRepository();
        $repo->save($weatherItem);

        $this->assertTrue(true);
    }

    public function testRepositoryWillGetCurrentWeatherList(): void
    {
        $locationId1 = new LocationId('', true);
        $locationId2 = new LocationId('', true);

        $repo = new WeatherItemRepository();

        // Ensure there's a couple of items in the database
        $helper = new UnitTestDataHelper();
        $weatherItem = $helper->getWeatherItem($locationId1);
        $repo->save($weatherItem);

        $weatherItem = $helper->getWeatherItem($locationId2);
        $repo->save($weatherItem);

        // Get a list
        $weatherItems = $repo->getCurrentWeather();
        self::assertGreaterThan(1, count($weatherItems));

        $hasLocation1 = false;
        $hasLocation2 = false;

        foreach ($weatherItems as $weatherItem) {
            if ($weatherItem->getLocationId()->getUuid() == $locationId1->getUuid()) {
                $hasLocation1 = true;
            }

            if ($weatherItem->getLocationId()->getUuid() == $locationId2->getUuid()) {
                $hasLocation2 = true;
            }
        }

        $this->assertTrue($hasLocation1);
        $this->assertTrue($hasLocation2);
    }
}
