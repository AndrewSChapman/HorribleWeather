<?php

namespace App\Domains\Weather\Type;

use App\Core\Type\Exception\ConstraintException;

/**
 * Class Temperature
 * @package App\Core\Type
 *
 * Holds a temperature value in celsius
 */
class Temperature
{
    /** @var float */
    protected $value;

    public function __construct(float $value)
    {
        if (($value < -273.15) || ($value > 100)) {
            throw new ConstraintException('Temperatures must fall in the range of -273.15 to 100');
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
