<?php

namespace App\Core\Type;

use InvalidArgumentException;

/**
 * Uses reflection to make sure values are from the list of class constants
 */
abstract class AbstractEnum
{
    /** @var string */
    protected $value;

    /**
     * @throws \ReflectionException
     */
    public function __construct(string $value)
    {
        $this->check($value);
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }

    public function is($value): bool
    {
        return ($this->value === (string)$value);
    }

    public function in(array $values): bool
    {
        return in_array($this->value, $values);
    }

    public function notIn(array $values): bool
    {
        return !$this->in($values);
    }

    public function isNot($value): bool
    {
        return !$this->is($value);
    }

    /**
     * @throws \ReflectionException
     */
    public static function valueList(): array
    {
        $refl = new \ReflectionClass(static::class);
        return $refl->getConstants();
    }

    /**
     * @throws \ReflectionException
     */
    private function check(string $value): void
    {
        $refl = new \ReflectionClass($this);

        if (!in_array($value, $refl->getConstants(), true)) {
            $className = static::class;
            $allowedValues = implode(', ', $refl->getConstants());
            throw new InvalidArgumentException(
                "{$className} Value must be one of the pre-defined constants. {$value} is not in list " .
                "of allowed values ({$allowedValues})"
            );
        }
    }
}
