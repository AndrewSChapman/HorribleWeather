<?php

namespace App\Domains\Weather\Exception;

class FailedToFetchWeatherException extends \DomainException
{
    public function __construct(string $reason)
    {
        parent::__construct("Failed to fetch the weather.  Reason: $reason");
    }
}
