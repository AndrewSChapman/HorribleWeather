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

    /**
     * Returns the current weather, sorted by the most deplorable.
     * The places with the worst weather come first.
     * @return WeatherItemCollection
     */
    public function getCurrentWeather(): WeatherItemCollection
    {
        $weatherCollection = $this->weatherItemRepository->getCurrentWeather();
        $weatherCollection->sortByHorribleWeather();
        return $weatherCollection;
    }
}
