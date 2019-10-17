<?php

namespace Tests\Unit\Domains\Weather\Adapter;

use App\Core\Exception\AdapterException;
use App\Domains\Weather\Adapter\WeatherItemModelAdapter;
use App\Domains\Weather\Enum\WeatherType;
use App\Domains\Weather\Model\WeatherItemModel;
use App\Testing\UnitTest;

class WeatherItemModelAdapterTest extends UnitTest
{
    private const WEATHER_ITEM_ID = '34dff32d-ea81-4371-976b-2eeab7b20ae5';
    private const CREATED_AT = 1571049909;
    private const UPDATED_AT = 1571049959;
    private const TYPE = WeatherType::ClearConditions;
    private const DESCRIPTION = 'Clear skies';
    private const LOCATION_ID = '17d49166-1bd1-478e-8dca-6b33348c404f';
    private const TEMPERATURE = 18.5;
    private const WIND_SPEED = 3.6;
    private const WIND_ICON = '09d';

    /**
     * SCENARIO: Given I have a correctly populated WeatherItemModel
     * AND I call modelToEntity on the WeatherItemModelAdapter
     * THEN I except a properly hydrated WeatherItem entity to be returned.
     */
    public function testAdapterWillConvertModelToEntity(): void
    {
        $model = new WeatherItemModel();

        $model->id = self::WEATHER_ITEM_ID;
        $model->created_at = self::CREATED_AT;
        $model->updated_at = self::UPDATED_AT;
        $model->type = self::TYPE;
        $model->description = self::DESCRIPTION;
        $model->location_id = self::LOCATION_ID;
        $model->temperature = self::TEMPERATURE;
        $model->wind_speed = self::WIND_SPEED;
        $model->icon = self::WIND_ICON;

        $adapter = new WeatherItemModelAdapter();
        $entity = $adapter->modelToEntity($model);

        $this->assertEquals(self::WEATHER_ITEM_ID, $entity->getId()->getUuid()->toString());
        $this->assertEquals(self::CREATED_AT, $entity->getCreatedAt()->getTimestamp());
        $this->assertEquals(self::UPDATED_AT, $entity->getUpdatedAt()->getTimestamp());
        $this->assertEquals(self::TYPE, $entity->getType());
        $this->assertEquals(self::LOCATION_ID, $entity->getLocationId()->getUuid()->toString());
        $this->assertEquals(self::TEMPERATURE, $entity->getTemperature()->getValue());
        $this->assertEquals(self::WIND_SPEED, $entity->getWindSpeed()->getValue());
        $this->assertEquals(self::WIND_ICON, $entity->getWeatherIcon()->toString());
    }

    /**
     * SCENARIO: Given I have a correctly populated WeatherItem entity
     * AND I call modelToEntity on the WeatherItemModelAdapter
     * THEN I except a properly hydrated WeatherItem entity to be returned.
     */
    public function testAdapterWillConvertEntityToModel(): void
    {
        $entity = $this->getDataHelper()->getWeatherItem();

        $adapter = new WeatherItemModelAdapter();
        $model = $adapter->entityToModel($entity);

        $this->assertEquals($entity->getId()->getUuid()->toString(), $model->id);
        $this->assertEquals($entity->getCreatedAt()->getTimestamp(), $model->created_at->timestamp);
        $this->assertEquals($entity->getUpdatedAt()->getTimestamp(), $model->updated_at->timestamp);
        $this->assertEquals($entity->getType(), $model->type);
        $this->assertEquals($entity->getLocationId()->getUuid()->toString(), $model->location_id);
        $this->assertEquals($entity->getDescription()->toString(), $model->description);
        $this->assertEquals($entity->getTemperature()->getValue(), $model->temperature);
        $this->assertEquals($entity->getWindSpeed()->getValue(), $model->wind_speed);
        $this->assertEquals($entity->getWeatherIcon()->toString(), $model->icon);
    }

    /**
     * SCENARIO: Given I have an unpopulated WeatherItemModel
     * AND I call modelToEntity on the WeatherItemModelAdapter
     * THEN I except an AdapterException because the model is empty and cannot be converted.
     */
    public function testAdapterWillThrowExceptionIfErrorWhenConvertingModelToEntity(): void
    {
        $this->expectException(AdapterException::class);

        $model = new WeatherItemModel();
        $adapter = new WeatherItemModelAdapter();
        $adapter->modelToEntity($model);
    }
}
