<?php

namespace App\Domains\Location\Service\LocationPersister;

use App\Domains\Location\Entity\LocationEntity;
use App\Domains\Location\Exception\InvalidLocationException;
use App\Domains\Location\Exception\LocationAlreadyExistsException;
use App\Domains\Location\Repository\LocationRepository\LocationRepositoryInterface;
use App\Domains\Location\Service\LocationChecker\LocationCheckerInterface;
use App\Domains\Location\Type\LocationId;
use App\Domains\Location\Type\LocationName;

class LocationPersister implements LocationPersisterInterface
{
    /** @var LocationRepositoryInterface */
    private $locationRepository;

    /** @var LocationCheckerInterface */
    private $locationChecker;

    public function __construct(
        LocationRepositoryInterface $locationRepository,
        LocationCheckerInterface $locationChecker
    ) {
        $this->locationRepository = $locationRepository;
        $this->locationChecker = $locationChecker;
    }

    public function persistLocation(LocationName $locationName): void
    {
        if ($this->locationRepository->existsByName($locationName)) {
            throw new LocationAlreadyExistsException($locationName);
        }

        $weatherItem = $this->locationChecker->tryLocation($locationName);
        if (!$weatherItem) {
            throw new InvalidLocationException($locationName);
        }

        $location = new LocationEntity(
            new LocationId('', true),
            $locationName
        );

        $this->locationRepository->save($location);
    }
}
