<?php

namespace App\Domains\Location\Repository\LocationRepository;

use App\Core\Exception\ModalSaveException;
use App\Domains\Location\Adapter\LocationEntityModelAdapter;
use App\Domains\Location\Collection\LocationEntityCollection;
use App\Domains\Location\Entity\LocationEntity;
use App\Domains\Location\Model\LocationModel;

class LocationRepository implements LocationRepositoryInterface
{
    /** @var LocationEntityModelAdapter */
    private $modelAdapter;

    public function __construct()
    {
        $this->modelAdapter = new LocationEntityModelAdapter();
    }

    /**
     * @param LocationEntity $entity
     * @throws ModalSaveException
     */
    public function save(LocationEntity $entity): void
    {
        $model = $this->modelAdapter->entityToModel($entity);

        if(!$model->save()) {
            throw new ModalSaveException(get_class($model));
        }
    }

    public function getAllLocations(): LocationEntityCollection
    {
        $collection = new LocationEntityCollection();

        $modelItems = LocationModel::query()
            ->get();

        foreach ($modelItems as $modelItem) {
            $collection->add($this->modelAdapter->modelToEntity($modelItem));
        }

        return $collection;
    }
}
