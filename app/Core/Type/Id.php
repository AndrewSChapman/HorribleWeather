<?php

namespace App\Core\Type;

use App\Core\Type\Exception\ConstraintException;
use Ramsey\Uuid\Uuid;

/**
 * Class Id
 * @package App\Core\Type
 *
 * Creates and stores a UUID, useful for database identifier.
 */
abstract class Id
{
    private $uuid;

    /**
     * Id constructor.
     * @param string $uuid Leave empty to generate a new UUID
     */
    public function __construct(string $uuid = '', $generateNewIdIfEmpty = false)
    {
        if (!empty($uuid)) {
            $this->uuid = Uuid::fromString($uuid);
        } else {
            if (!$generateNewIdIfEmpty) {
                throw new ConstraintException(static::class . ' must have a valid value');
            }

            try {
                $this->uuid = Uuid::uuid4();
            } catch (\Exception $exception) {

            }
        }
    }

    public function getUuid(): \Ramsey\Uuid\UuidInterface
    {
        return $this->uuid;
    }

    public function __toString()
    {
        return $this->uuid->toString();
    }
}