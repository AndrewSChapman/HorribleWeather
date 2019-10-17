<?php

namespace App\Domains\Weather\Service\CurrentWeatherLister;

use App\Domains\Weather\Collection\WeatherItemCollection;
use App\Domains\Weather\Repository\WeatherItemRepositoryInterface;

class CurrentWeatherLister implements CurrentWeatherListerInterface
{
    /** @var WeatherItemRepositoryInterface */
    private $weatherItemRepository;

    public function __construct(WeatherItemRepositoryInterface $weatherItemRepository)
    {
        $this->weatherItemRepository = $weatherItemRepository;
    }

    public function getCurrentWeather(): WeatherItemCollection
    {
        return $this->weatherItemRepository->getCurrentWeather();
    }
}
