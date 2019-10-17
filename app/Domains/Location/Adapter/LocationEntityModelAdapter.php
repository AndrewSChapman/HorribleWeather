<?php

namespace App\Domains\Location\Adapter;

use App\Core\Exception\AdapterException;
use App\Core\Type\CreatedAt;
use App\Core\Type\UpdatedAt;
use App\Domains\Location\Entity\LocationEntity;
use App\Domains\Location\Model\LocationModel;
use App\Domains\Location\Type\LocationId;
use App\Domains\Location\Type\LocationName;

class LocationEntityModelAdapter
{
    public function modelToEntity(LocationModel $model): LocationEntity
    {
        try {
            $entity = new LocationEntity(
                new LocationId($model->id),
                new LocationName($model->location),
                new CreatedAt($model->created_at),
                new UpdatedAt($model->updated_at)
            );

            return $entity;
        } catch (\Exception $exception) {
            throw new AdapterException(get_class($this), $exception->getMessage());
        } catch (\TypeError $error) {
            throw new AdapterException(get_class($this), $error->getMessage());
        }
    }

    public function entityToModel(LocationEntity $entity): LocationModel
    {
        try {
            $model = new LocationModel();

            $model->id = $entity->getId()->getUuid()->toString();
            $model->location = $entity->getLocationName()->getValue();
            $model->created_at = $entity->getCreatedAt()->getTimestamp();
            $model->updated_at = $entity->getUpdatedAt()->getTimestamp();

            return $model;
        } catch (\Exception $exception) {
            throw new AdapterException(get_class($this), $exception->getMessage());
        } catch (\TypeError $error) {
            throw new AdapterException(get_class($this), $error->getMessage());
        }
    }
}
