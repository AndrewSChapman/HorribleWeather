<?php

namespace App\Core\Type\Exception;

class InvalidJsonException extends \DomainException
{
    /**
     * InvalidJsonException constructor.
     */
    public function __construct(string $className, string $reason = 'The provided JSON was invalid')
    {
        parent::__construct("$className::$reason");
    }
}
