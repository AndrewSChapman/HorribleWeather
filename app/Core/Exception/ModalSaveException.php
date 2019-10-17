<?php

namespace App\Core\Exception;

class ModalSaveException extends \Exception
{
    /**
     * ModalSaveException constructor.
     */
    public function __construct(string $className)
    {
        parent::__construct("$className failed to save record");
    }
}
