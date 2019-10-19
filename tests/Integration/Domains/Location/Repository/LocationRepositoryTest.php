<?php
namespace Tests\Integration\Domains\Location\Repository;

use App\Domains\Location\Repository\LocationRepository\LocationRepository;
use App\Domains\Location\Type\LocationName;
use App\Testing\UnitTestDataHelper\UnitTestDataHelper;
use Tests\IntegrationTestCase;

class LocationRepositoryTest extends IntegrationTestCase
{
    public function testRepositoryWillSaveLocationEntityAndThenFindItByName(): void
    {
        $helper = new UnitTestDataHelper();
        $entity = $helper->location()->createLocationEntity();

        $repo = new LocationRepository();
        $repo->save($entity);

        $this->assertTrue($repo->existsByName($entity->getLocationName()));
    }

    public function testRepositoryWillGetLocationList(): void
    {
        $repo = new LocationRepository();

        // Ensure there's a couple of items in the database
        $helper = new UnitTestDataHelper();
        $entity = $helper->location()->createLocationEntity(new LocationName('Brighton,uk'));
        $repo->save($entity);

        $entity = $helper->location()->createLocationEntity(new LocationName('London,uk'));
        $repo->save($entity);

        // Get a list
        $entities = $repo->getAllLocations();
        self::assertGreaterThan(1, count($entities));

        $hasBrighton = false;
        $hasLondon = false;

        foreach ($entities as $locationEntity) {
            if ($locationEntity->getLocationName()->getValue() === 'Brighton,uk') {
                $hasBrighton = true;
            }

            if ($locationEntity->getLocationName()->getValue() === 'London,uk') {
                $hasLondon = true;
            }
        }

        $this->assertTrue($hasBrighton);
        $this->assertTrue($hasLondon);
    }
}
