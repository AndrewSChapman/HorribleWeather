<?php

namespace App\Testing\UnitTestDataHelper\Factory;

use App\Core\Type\CreatedAt;
use App\Core\Type\UpdatedAt;
use App\Domains\Location\Collection\LocationEntityCollection;
use App\Domains\Location\Entity\LocationEntity;
use App\Domains\Location\Repository\LocationRepository\LocationRepositoryInterface;
use App\Domains\Location\Type\LocationId;
use App\Domains\Location\Type\LocationName;
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
