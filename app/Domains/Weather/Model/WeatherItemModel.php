<?php

namespace App\Domains\Weather\Model;

use App\Domains\Location\Model\LocationModel;
use Illuminate\Database\Eloquent\Model;

class WeatherItemModel extends Model
{
    protected $keyType = 'string';

    public function getDateFormat()
    {
        return 'U';
    }

    public function getTable()
    {
        return 'weather_item';
    }

    public function location()
    {
        return $this->hasOne(
            'App\Domains\Location\Model\LocationModel',
            'id',
            'location_id'
        );
    }
}
