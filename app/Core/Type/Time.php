<?php

namespace App\Core\Type;

use App\Core\Type\Exception\ConstraintException;
use App\Core\Type\Exception\InvalidTimeException;

/**
 * Class Time
 * @package App\Core\Type
 *
 * Stores a time value as seconds since midnight.
 * Can be constructed via time string with Time::fromString('09:45:00')
 */
class Time
{
    /** @var WholeNumber */
    private $secondsSinceMidnight;

    public const SECS_IN_DAY = 86400;
    public const SECS_IN_HOUR = 3600;
    public const SECS_IN_MINUTE = 60;

    public function __construct(WholeNumber $secondsSinceMidnight)
    {
        if ($secondsSinceMidnight->getValue() >= self::SECS_IN_DAY) {
            throw new ConstraintException('Invalid constructor value for ' . static::class);
        }

        $this->secondsSinceMidnight = $secondsSinceMidnight;
    }

    public static function fromString(string $timeString): self
    {
        if (strlen($timeString) != 8) {
            throw new InvalidTimeException("The time string $timeString is invalid");
        }

        $parts = array_filter(explode(':', $timeString), function($part) {
            return is_numeric($part);
        });

        if (count($parts) != 3) {
            throw new InvalidTimeException("The time string $timeString is invalid");
        }

        $hour = intval($parts[0]);
        $minutes = intval($parts[1]);
        $seconds = intval($parts[2]);

        if (($hour < 0) || ($hour > 23)) {
            throw new InvalidTimeException("The time string $timeString is invalid");
        }

        if (($minutes < 0) || ($minutes > 59)) {
            throw new InvalidTimeException("The time string $timeString is invalid");
        }

        if (($seconds < 0) || ($seconds > 59)) {
            throw new InvalidTimeException("The time string $timeString is invalid");
        }

        $totalSeconds = $seconds + ($minutes * self::SECS_IN_MINUTE) + ($hour * self::SECS_IN_HOUR);

        return new self(new WholeNumber($totalSeconds));
    }

    public function getSecondsSinceMidnight(): WholeNumber
    {
        return $this->secondsSinceMidnight;
    }

    public function toString(): string
    {
        return $this->padNumber($this->getHour()) . ':' .
            $this->padNumber($this->getMinute()) . ':' .
            $this->padNumber($this->getSeconds());
    }

    public function getHour(): WholeNumber
    {
        return new WholeNumber(floor($this->secondsSinceMidnight->getValue() / self::SECS_IN_HOUR));
    }

    public function getMinute(): WholeNumber
    {
        $secondsRemainder = $this->secondsSinceMidnight->getValue() % self::SECS_IN_HOUR;
        return new WholeNumber(floor($secondsRemainder / self::SECS_IN_MINUTE));
    }

    public function getSeconds(): WholeNumber
    {
        return new WholeNumber($this->secondsSinceMidnight->getValue() % self::SECS_IN_MINUTE);
    }

    public function equals(Time $anotherTime): bool
    {
        return $this->getSecondsSinceMidnight()->getValue() === $anotherTime->getSecondsSinceMidnight()->getValue();
    }

    public function isGreaterThan(Time $anotherTime): bool
    {
        return $this->getSecondsSinceMidnight()->getValue() > $anotherTime->getSecondsSinceMidnight()->getValue();
    }

    public function isGreaterThanOrEqualTo(Time $anotherTime): bool
    {
        return $this->getSecondsSinceMidnight()->getValue() >= $anotherTime->getSecondsSinceMidnight()->getValue();
    }

    public function isLessThan(Time $anotherTime): bool
    {
        return $this->getSecondsSinceMidnight()->getValue() < $anotherTime->getSecondsSinceMidnight()->getValue();
    }

    public function isLessThanOrEqualTo(Time $anotherTime): bool
    {
        return $this->getSecondsSinceMidnight()->getValue() <= $anotherTime->getSecondsSinceMidnight()->getValue();
    }

    private function padNumber(WholeNumber $value): string
    {
        $intVal = $value->getValue();
        if ($intVal < 10) {
            return '0' . $intVal;
        }

        return strval($intVal);
    }
}