<?php

namespace App\Domains\Weather\Repository;

use App\Core\Exception\ModalSaveException;
use App\Domains\Weather\Adapter\WeatherItemModelAdapter;
use App\Domains\Weather\Collection\WeatherItemCollection;
use App\Domains\Weather\Entity\WeatherItem;
use App\Domains\Weather\Model\WeatherItemModel;
use Illuminate\Support\Facades\DB;

class WeatherItemRepository implements WeatherItemRepositoryInterface
{
    /** @var WeatherItemModelAdapter */
    private $modelAdapter;

    public function __construct()
    {
        $this->modelAdapter = new WeatherItemModelAdapter();
    }

    /**
     * @param WeatherItem $weatherItem
     * @throws ModalSaveException
     */
    public function save(WeatherItem $weatherItem): void
    {
        $model = $this->modelAdapter->entityToModel($weatherItem);

        if(!$model->save()) {
            throw new ModalSaveException(get_class($model));
        }
    }

    public function getCurrentWeather(): WeatherItemCollection
    {
        $weatherItemCollection = new WeatherItemCollection();

        // Get the timestamp of the most recently harvested weather items
        $sql = <<<SQL
            SELECT MAX(created_at) as created_at
            FROM weather_item
SQL;

        $mostRecentStamp = time();
        $mostRecent = DB::select($sql);
        if (count($mostRecent) === 1) {
            $mostRecentStamp = $mostRecent[0]->created_at;
        }

        // Now load all the weather items with a matching stamp
        // also eager load the locations using the ::with syntax.
        $modelItems = WeatherItemModel::with('location')
            ->where('created_at', '=', $mostRecentStamp)
            ->get();

        foreach ($modelItems as $modelItem) {
            $weatherItemCollection->add($this->modelAdapter->modelToEntity($modelItem));
        }

        return $weatherItemCollection;
    }
}
