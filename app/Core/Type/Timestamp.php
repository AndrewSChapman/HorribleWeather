<?php
namespace App\Core\Type;

use App\Core\Type\Exception\ConstraintException;

/**
 * Class Timestamp
 * @package App\Core\Type
 *
 * Represents a unix timestamp.
 */
abstract class Timestamp
{
    /** @var int */
    private $timestamp;

    public function __construct($init = null)
    {
        if ((is_null($init)) || (empty($init))) {
            $this->timestamp = time();
        } else if (is_numeric($init)) {
            $this->timestamp = $init;
        } else {
            $this->timestamp = strtotime($init);

            if ($this->timestamp === false) {
                throw new ConstraintException("Invalid timestamp value value '$init'");
            }
        }
    }

    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    public function __toString()
    {
        return date('Y-m-d H:i:s', $this->timestamp);
    }
}