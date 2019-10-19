<?php

namespace Tests\Unit\Domains\Location\Service;

use App\Domains\Location\Service\LocationChecker\LocationChecker;
use App\Domains\Location\Type\LocationName;
use App\Domains\Weather\Entity\WeatherItem;
use App\Testing\UnitTest;

class LocationCheckerTest extends UnitTest
{
    public function testLocationCheckerWillReturnLocationIfLocationCanBeFound(): void
    {
        $weatherFetcher = $this->getDataHelper()->location()->getWeatherFetcher($this);
        $weatherItemCollection = $this->getDataHelper()->getWeatherItemCollection(1);

        $weatherFetcher->expects($this->once())->method('fetchCurrentWeather')
            ->willReturn($weatherItemCollection);

        $locationChecker = new LocationChecker($weatherFetcher);
        $weatherItem = $locationChecker->tryLocation(new LocationName('Brighton,uk'));

        $this->assertInstanceOf(WeatherItem::class, $weatherItem);
    }
}
