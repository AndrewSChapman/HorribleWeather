<?php

namespace App\Domains\Weather\Adapter;

use App\Core\Exception\AdapterException;
use App\Core\Type\CreatedAt;
use App\Core\Type\UpdatedAt;
use App\Domains\Location\Type\LocationName;
use App\Domains\Weather\Entity\WeatherItem;
use App\Domains\Weather\Enum\WeatherType;
use App\Domains\Weather\Model\WeatherItemModel;
use App\Domains\Location\Type\LocationId;
use App\Domains\Weather\Type\Temperature;
use App\Domains\Weather\Type\WeatherDescription;
use App\Domains\Weather\Type\WeatherIcon;
use App\Domains\Weather\Type\WeatherItemId;
use App\Domains\Weather\Type\WindSpeed;

class WeatherItemModelAdapter
{
    public function modelToEntity(WeatherItemModel $model, $withLocation = false): WeatherItem
    {
        try {
            $weatherItem = new WeatherItem(
                new WeatherItemId($model->id),
                new LocationId($model->location_id),
                new WeatherType($model->type),
                new WeatherDescription($model->description),
                new Temperature($model->temperature),
                new WindSpeed($model->wind_speed),
                new WeatherIcon($model->icon),
                new CreatedAt($model->created_at),
                new UpdatedAt($model->updated_at)
            );

            if ($withLocation) {
                $weatherItem->setLocationName(new LocationName($model->location->location));
            }

            return $weatherItem;
        } catch (\Exception $exception) {
            throw new AdapterException(get_class($this), $exception->getMessage());
        } catch (\TypeError $error) {
            throw new AdapterException(get_class($this), $error->getMessage());
        }
    }

    public function entityToModel(WeatherItem $weatherItem): WeatherItemModel
    {
        try {
            $model = new WeatherItemModel();

            $model->id = $weatherItem->getId()->getUuid()->toString();
            $model->created_at = $weatherItem->getCreatedAt()->getTimestamp();
            $model->updated_at = $weatherItem->getUpdatedAt()->getTimestamp();
            $model->location_id = (string)$weatherItem->getLocationId();
            $model->type = (string)$weatherItem->getType();
            $model->description = (string)$weatherItem->getDescription()->toString();
            $model->temperature = $weatherItem->getTemperature()->getValue();
            $model->wind_speed = $weatherItem->getWindSpeed()->getValue();
            $model->icon = $weatherItem->getWeatherIcon()->toString();

            return $model;
        } catch (\Exception $exception) {
            throw new AdapterException(get_class($this), $exception->getMessage());
        } catch (\TypeError $error) {
            throw new AdapterException(get_class($this), $error->getMessage());
        }
    }
}
