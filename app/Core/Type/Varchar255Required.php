<?php

namespace App\Core\Type;

class Varchar255Required extends ConstrainedString
{
    public function __construct(string $value)
    {
        parent::__construct($value, 1, 255);
    }
}
