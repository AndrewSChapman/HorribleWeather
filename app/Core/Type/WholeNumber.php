<?php

namespace App\Core\Type;

use App\Core\Type\Exception\ConstraintException;

/**
 * Class WholeNumber
 * @package App\Core\Type
 *
 * Ensures that numbers are whole numbers (0 or greater than 0.  Negative numbers are not allowed).
 */
class WholeNumber
{
    /** @var int */
    protected $value;

    public function __construct(int $value)
    {
        if ($value < 0) {
            throw new ConstraintException('WholeNumber must be >= 0');
        }

        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    public function toString(): string
    {
        return strval($this->value);
    }

    public function increment(): void
    {
        $this->value++;
    }
}