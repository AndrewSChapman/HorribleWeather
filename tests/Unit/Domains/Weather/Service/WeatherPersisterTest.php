<?php

namespace Tests\Unit\Domains\Weather\Service;

use App\Domains\Weather\Service\WeatherPersister\WeatherPersister;
use App\Testing\UnitTest;

class WeatherPersisterTest extends UnitTest
{
    public function testWeatherPersisterWillCallRepoSaveMethodForEachWeatherItem(): void
    {
        $weatherItemRepo = $this->getDataHelper()->getWeatherItemRepository($this);

        $weatherItemRepo->expects($this->exactly(3))
            ->method('save');

        $service = new WeatherPersister($weatherItemRepo);

        $weatherItemCollection = $this->getDataHelper()->getWeatherItemCollection(3);
        $service->persistWeatherItems($weatherItemCollection);
    }
}
