<?php

namespace App\Domains\Location\Service\LocationChecker;

use App\Domains\Location\Collection\LocationEntityCollection;
use App\Domains\Location\Entity\LocationEntity;
use App\Domains\Location\Exception\InvalidLocationException;
use App\Domains\Location\Type\LocationId;
use App\Domains\Location\Type\LocationName;
use App\Domains\Weather\Entity\WeatherItem;
use App\Domains\Weather\Service\WeatherFetcher\WeatherFetcherInterface;

class LocationChecker implements LocationCheckerInterface
{
    /** @var WeatherFetcherInterface */
    private $weatherFetcher;

    public function __construct(WeatherFetcherInterface $weatherFetcher)
    {
        $this->weatherFetcher = $weatherFetcher;
    }

    public function tryLocation(LocationName $locationName): ?WeatherItem
    {
        $locationCollection = new LocationEntityCollection();
        $locationCollection->add(
            new LocationEntity(
                new LocationId('', true),
                $locationName
            )
        );

        try {
            $weatherItemCollection = $this->weatherFetcher->fetchCurrentWeather($locationCollection);

            if ($weatherItemCollection->isEmpty()) {
                return null;
            }

            return $weatherItemCollection->toArray()[0];
        } catch (InvalidLocationException $invalidLocationException) {
            return null;
        }
    }
}
