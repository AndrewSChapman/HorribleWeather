<?php

namespace App\Core\Type;

use App\Core\Type\Exception\ConstraintException;

/**
 * Class ConstrainedString
 * @package App\Core\Type
 *
 * Must be extended to be used.
 * Ensures string values are within min/max length criteria.
 */
abstract class ConstrainedString
{
    /** @var string */
    private $value;

    public function __construct(string $value, int $minLength = 0, int $maxLength = 0)
    {
        $stringLen = strlen($value);

        if (($minLength > 0) && ($stringLen < $minLength)) {
            throw new ConstraintException(
                sprintf('Invalid %s, value must be at least %d characters', static::class, $minLength)
            );
        }

        if (($maxLength > 0) && ($stringLen > $maxLength)) {
            throw new ConstraintException(
                sprintf('Invalid %s, value must be no longer than %d characters', static::class, $maxLength)
            );
        }

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function toString(): string
    {
        return $this->value;
    }
}