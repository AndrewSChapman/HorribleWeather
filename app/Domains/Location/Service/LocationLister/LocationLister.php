<?php

namespace App\Domains\Location\Service\LocationLister;

use App\Domains\Location\Collection\LocationEntityCollection;
use App\Domains\Location\Repository\LocationRepository\LocationRepositoryInterface;

class LocationLister implements LocationListerInterface
{
    /** @var LocationRepositoryInterface */
    private $locationRepository;

    public function __construct(LocationRepositoryInterface $locationRepository)
    {
        $this->locationRepository = $locationRepository;
    }

    public function getList(): LocationEntityCollection
    {
        return $this->locationRepository->getAllLocations();
    }
}
