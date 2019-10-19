<?php

namespace App\Testing\UnitTestDataHelper\Factory;

use App\Core\Type\CreatedAt;
use App\Core\Type\UpdatedAt;
use App\Domains\Location\Collection\LocationEntityCollection;
use App\Domains\Location\Entity\LocationEntity;
use App\Domains\Location\Repository\LocationRepository\LocationRepositoryInterface;
use App\Domains\Location\Service\LocationChecker\LocationCheckerInterface;
use App\Domains\Location\Service\LocationPersister\LocationPersisterInterface;
use App\Domains\Location\Type\LocationId;
use App\Domains\Location\Type\LocationName;
use App\Domains\Weather\Service\WeatherFetcher\WeatherFetcherInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * This is a convenience class that creates Location related data items
 * for unit testing purposes.
 */
class LocationDataFactory
{
    /**
     * @param TestCase $testCase
     * @return LocationRepositoryInterface|MockObject
     */
    public function getLocationRepositoryInterface(TestCase $testCase): LocationRepositoryInterface
    {
        $repository = $testCase->getMockBuilder(LocationRepositoryInterface::class)
            ->getMock();

        return $repository;
    }

    /**
     * @param TestCase $testCase
     * @return WeatherFetcherInterface|MockObject
     */
    public function getWeatherFetcher(TestCase $testCase): WeatherFetcherInterface
    {
        $service = $testCase->getMockBuilder(WeatherFetcherInterface::class)
            ->getMock();

        return $service;
    }

    /**
     * @param TestCase $testCase
     * @return LocationCheckerInterface|MockObject
     */
    public function getLocationChecker(TestCase $testCase): LocationCheckerInterface
    {
        $service = $testCase->getMockBuilder(LocationCheckerInterface::class)
            ->getMock();

        return $service;
    }

    /**
     * @param TestCase $testCase
     * @return LocationPersisterInterface|MockObject
     */
    public function getLocationPersister(TestCase $testCase): LocationPersisterInterface
    {
        $service = $testCase->getMockBuilder(LocationPersisterInterface::class)
            ->getMock();

        return $service;
    }

    public function createLocationEntity(?LocationName $locationName = null): LocationEntity
    {
        if ($locationName === null) {
            $locationName = new LocationName('Brighton,uk');
        }

        $location = new LocationEntity(
            new LocationId('', true),
            $locationName,
            new CreatedAt(),
            new UpdatedAt()
        );

        return $location;
    }

    public function getLocationCollection(int $numLocations = 1): LocationEntityCollection
    {
        $collection = new LocationEntityCollection();

        for ($counter = 1; $counter <= $numLocations; $counter++) {
            $collection->add($this->createLocationEntity());
        }

        return $collection;
    }
}
