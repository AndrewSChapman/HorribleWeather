<?php

namespace App\Domains\Weather\Service\WeatherPersister;

use App\Domains\Weather\Collection\WeatherItemCollection;
use App\Domains\Weather\Repository\WeatherItemRepositoryInterface;

class WeatherPersister implements WeatherPersisterInterface
{
    /** @var WeatherItemRepositoryInterface */
    private $weatherItemRepository;

    public function __construct(WeatherItemRepositoryInterface $weatherItemRepository)
    {
        $this->weatherItemRepository = $weatherItemRepository;
    }

    public function persistWeatherItems(WeatherItemCollection $weatherItems): void
    {
        foreach ($weatherItems as $weatherItem) {
            $this->weatherItemRepository->save($weatherItem);
        }
    }
}
