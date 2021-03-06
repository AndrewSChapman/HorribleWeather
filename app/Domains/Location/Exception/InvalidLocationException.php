<?php

namespace App\Domains\Location\Exception;

use App\Domains\Location\Type\LocationName;

class InvalidLocationException extends \DomainException
{
    public function __construct(LocationName $locationName)
    {
        parent::__construct("The location: ${locationName} is invalid");
    }
}
