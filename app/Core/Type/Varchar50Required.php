<?php

namespace App\Core\Type;

class Varchar50Required extends ConstrainedString
{
    public function __construct(string $value)
    {
        parent::__construct($value, 1, 50);
    }
}
