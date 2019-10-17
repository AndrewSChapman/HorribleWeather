<?php

namespace Tests\Unit\Domains\Weather\Service;

use App\Domains\Weather\Service\CurrentWeatherLister\CurrentWeatherLister;
use App\Testing\UnitTest;

class CurrentWeatherListerTest extends UnitTest
{
    public function testCurrentWeatherListerWillCallRepositoryGetCurrentWeather(): void
    {
        $repository = $this->getDataHelper()->getWeatherItemRepository($this);

        // Ensure the repository is called
        $repository->expects($this->once())
            ->method('getCurrentWeather')
            ->willReturn($this->getDataHelper()->getWeatherItemCollection(2));

        $service = new CurrentWeatherLister($repository);
        $weatherItems = $service->getCurrentWeather();

        // Ensure the 2 items that the repo returns are returned by the service
        $this->assertCount(2, $weatherItems);
    }
}
