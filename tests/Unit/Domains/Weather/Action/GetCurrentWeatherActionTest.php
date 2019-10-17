<?php

namespace Tests\Unit\Domains\Weather\Action;

use App\Domains\Weather\Action\GetCurrentWeatherAction;
use App\Domains\Weather\Collection\WeatherItemCollection;
use App\Domains\Weather\Service\CurrentWeatherLister\CurrentWeatherListerInterface;
use App\Testing\UnitTest;
use PHPUnit\Framework\MockObject\MockObject;

class GetCurrentWeatherActionTest extends UnitTest
{
    public function testActionCallsCurrentWeatherListerAndReturnsData(): void
    {
        $currentWeatherLister = $this->getCurrentWeatherLister();

        $action = new GetCurrentWeatherAction($currentWeatherLister);

        $weatherItems = $this->getWeatherItemCollection();

        $currentWeatherLister->expects($this->once())
            ->method('getCurrentWeather')
            ->willReturn($weatherItems);

        $data = $action->getCurrentWeather();

        self::assertCount(count($weatherItems), $data);
    }

    private function getWeatherItemCollection(): WeatherItemCollection
    {
        $weatherItemCollection = $this->getDataHelper()->getWeatherItemCollection(2);
        return $weatherItemCollection;
    }

    /**
     * @return CurrentWeatherListerInterface|MockObject
     */
    private function getCurrentWeatherLister(): CurrentWeatherListerInterface
    {
        $service = $this->getMockBuilder(CurrentWeatherListerInterface::class)
            ->getMock();

        return $service;
    }
}
