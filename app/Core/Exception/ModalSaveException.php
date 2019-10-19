<?php

namespace App\Core\Exception;

/**
 * Throw one of these when a model fails to save data.
 */
class ModalSaveException extends \Exception
{
    public function __construct(string $className)
    {
        parent::__construct("$className failed to save record");
    }
}
