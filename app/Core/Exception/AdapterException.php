<?php

namespace App\Core\Exception;

/**
 * Throw one of these when an adapter fails to adapt something.
 */
class AdapterException extends \DomainException
{
    public function __construct(string $className, string $reason = '')
    {
        parent::__construct("Failure in $className adapter.  Reason: $reason");
    }
}
