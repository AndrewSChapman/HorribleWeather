<?php

namespace Tests\Unit\Domains\Location\Service;

use App\Domains\Location\Exception\InvalidLocationException;
use App\Domains\Location\Exception\LocationAlreadyExistsException;
use App\Domains\Location\Service\LocationPersister\LocationPersister;
use App\Domains\Location\Type\LocationName;
use App\Testing\UnitTest;

class LocationPersisterTest extends UnitTest
{
    /**
     * SCENARIO: Given I have a valid LocationPersister object
     * AND I attempt to persist a location that already exists in the database
     * THEN I will see an LocationAlreadyExists exception is raised.
     */
    public function testLocationPersisterWillThrowLocationAlreadyExistsExceptionIfLocationAlreadyExists(): void
    {
        $this->expectException(LocationAlreadyExistsException::class);

        $locationChecker = $this->getDataHelper()->location()->getLocationChecker($this);
        $locationRepo = $this->getDataHelper()->location()->getLocationRepositoryInterface($this);

        $locationRepo->expects($this->once())
            ->method('existsByName')
            ->willReturn(true);

        $service = new LocationPersister($locationRepo, $locationChecker);
        $service->persistLocation(new LocationName('Bleg,uk'));
    }

    /**
     * SCENARIO: Given I have a valid LocationPersister object
     * AND I attempt to persist a location that is not found by the LocationChecker
     * THEN I will see an InvalidLocationException is raised.
     */
    public function testLocationPersisterWillThrowInvalidLocationExceptionIfLocationInvalid(): void
    {
        $this->expectException(InvalidLocationException::class);

        $locationChecker = $this->getDataHelper()->location()->getLocationChecker($this);
        $locationRepo = $this->getDataHelper()->location()->getLocationRepositoryInterface($this);

        $locationRepo->expects($this->once())
            ->method('existsByName')
            ->willReturn(false);

        $locationChecker->expects($this->once())
            ->method('tryLocation')
            ->willReturn(null);

        $service = new LocationPersister($locationRepo, $locationChecker);
        $service->persistLocation(new LocationName('Bleg,uk'));
    }

    /**
     * SCENARIO: Given I have a valid LocationPersister object
     * AND I attempt to persist a location that is found by the LocationChecker
     * THEN I will see the 'save' method is called on the LocationRepository
     */
    public function testLocationPersisterWillCallSaveOnRepoIfLocationValid(): void
    {
        $locationChecker = $this->getDataHelper()->location()->getLocationChecker($this);
        $locationRepo = $this->getDataHelper()->location()->getLocationRepositoryInterface($this);

        $locationRepo->expects($this->once())
            ->method('existsByName')
            ->willReturn(false);

        $weatherItem = $this->getDataHelper()->getWeatherItem();

        $locationChecker->expects($this->once())
            ->method('tryLocation')
            ->willReturn($weatherItem);

        $locationRepo->expects($this->once())
            ->method('save');

        $service = new LocationPersister($locationRepo, $locationChecker);
        $service->persistLocation(new LocationName('Brighton,uk'));
    }
}
