<?php

namespace App\Core\Exception;

class AdapterException extends \DomainException
{
    public function __construct(string $className, string $reason = '')
    {
        parent::__construct("Failure in $className adapter.  Reason: $reason");
    }
}
