<?php

namespace App\Domains\Location\Model;

use Illuminate\Database\Eloquent\Model;

class LocationModel extends Model
{
    protected $keyType = 'string';

    public function getDateFormat()
    {
        return 'U';
    }

    public function getTable()
    {
        return 'location';
    }
}
