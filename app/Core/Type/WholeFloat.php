<?php

namespace App\Core\Type;

use App\Core\Type\Exception\ConstraintException;

/**
 * Class WholeFloat
 * @package App\Core\Type
 *
 * Ensures that numbers are whole floating point numbers (0 or greater than 0.  Negative numbers are not allowed).
 */
class WholeFloat
{
    /** @var float */
    protected $value;

    public function __construct(float $value)
    {
        if ($value < 0) {
            throw new ConstraintException('WholeNumber must be >= 0');
        }

        $this->value = $value;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function toString(): string
    {
        return strval($this->value);
    }
}
