<?php

namespace Tests\Unit\Domains\Location\Service;

use App\Domains\Location\Service\LocationLister\LocationLister;
use App\Testing\UnitTest;

class LocationListerTest extends UnitTest
{
    public function testLocationListerWillCallRepostitoryAndReturnLocationCollection(): void
    {
        $locations = $this->getDataHelper()->location()->getLocationCollection(2);
        $repository = $this->getDataHelper()->location()->getLocationRepositoryInterface($this);

        $repository->expects($this->once())
            ->method('getAllLocations')
            ->willReturn($locations);

        $service = new LocationLister($repository);

        $returnedLocations = $service->getList();

        $this->assertCount(2, $returnedLocations);
    }
}
