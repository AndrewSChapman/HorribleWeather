<?php

namespace Tests\Unit\Domains\Location\Adapter;

use App\Domains\Location\Adapter\LocationEntityModelAdapter;
use App\Domains\Location\Model\LocationModel;
use App\Testing\UnitTest;

class LocationEntityModelAdapterTest extends UnitTest
{
    private const LOCATION_ID = '34dff32d-ea81-4371-976b-2eeab7b20ae5';
    private const CREATED_AT = 1571049909;
    private const UPDATED_AT = 1571049959;
    private const LOCATION_NAME = 'Brighton,uk';

    /**
     * SCENARIO: Given I have a correctly populated LocationModel
     * AND I call modelToEntity on the LocationEntityModelAdapter
     * THEN I except a properly hydrated LocationEntity to be returned.
     */
    public function testAdapterWillConvertModelToEntity(): void
    {
        $model = new LocationModel();

        $model->id = self::LOCATION_ID;
        $model->created_at = self::CREATED_AT;
        $model->updated_at = self::UPDATED_AT;
        $model->location = self::LOCATION_NAME;

        $adapter = new LocationEntityModelAdapter();
        $entity = $adapter->modelToEntity($model);

        $this->assertEquals(self::LOCATION_ID, $entity->getId()->getUuid()->toString());
        $this->assertEquals(self::CREATED_AT, $entity->getCreatedAt()->getTimestamp());
        $this->assertEquals(self::UPDATED_AT, $entity->getUpdatedAt()->getTimestamp());
        $this->assertEquals(self::LOCATION_NAME, $entity->getLocationName()->getValue());
    }

    /**
     * SCENARIO: Given I have a correctly populated LocationEntity
     * AND I call entityToModel on the LocationEntityModelAdapter
     * THEN I except a properly hydrated LocationModel to be returned.
     */
    public function testAdapterWillConvertEntityToModel(): void
    {
        $entity = $this->getDataHelper()->location()->createLocationEntity();

        $adapter = new LocationEntityModelAdapter();
        $model = $adapter->entityToModel($entity);

        $this->assertEquals($entity->getId()->getUuid()->toString(), $model->id);
        $this->assertEquals($entity->getCreatedAt()->getTimestamp(), $model->created_at->timestamp);
        $this->assertEquals($entity->getUpdatedAt()->getTimestamp(), $model->updated_at->timestamp);
        $this->assertEquals($entity->getLocationName()->getValue(), $model->location);
    }
}
