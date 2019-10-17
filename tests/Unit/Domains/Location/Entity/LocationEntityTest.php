<?php

namespace App\Tests\Unit\Domains\Location\Entity;

use App\Core\Type\CreatedAt;
use App\Core\Type\UpdatedAt;
use App\Domains\Location\Entity\LocationEntity;
use App\Domains\Location\Type\LocationId;
use App\Domains\Location\Type\LocationName;
use PHPUnit\Framework\TestCase;

class LocationEntityTest extends TestCase
{
    public function testLocationEntityWillConstructCorrectlyWithoutTimestampsSpecified(): void
    {
        $id = new LocationId('', true);
        $locationName = new LocationName('Brighton,uk');

        $location = new LocationEntity(
            $id,
            $locationName
        );

        $this->assertEquals($id->getUuid(), $location->getId()->getUuid());
        $this->assertEquals($locationName->getValue(), $location->getLocationName()->getValue());
        $this->assertGreaterThan(time() - 10, $location->getCreatedAt()->getTimestamp());
        $this->assertGreaterThan(time() - 10, $location->getUpdatedAt()->getTimestamp());
    }

    public function testLocationEntityWillConstructCorrectlyWithTimestampsSpecified(): void
    {
        $id = new LocationId('', true);
        $locationName = new LocationName('Brighton,uk');
        $createdAt = new CreatedAt('2019-10-12 17:00:00');
        $updatedAt = new UpdatedAt('2019-10-12 17:05:05');

        $location = new LocationEntity(
            $id,
            $locationName,
            $createdAt,
            $updatedAt
        );

        $this->assertEquals(1570899600, $location->getCreatedAt()->getTimestamp());
        $this->assertEquals(1570899905, $location->getUpdatedAt()->getTimestamp());
    }
}
