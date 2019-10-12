<?php

namespace App\Tests\Unit\Core\Type;

use App\Core\Type\DayNumber;
use App\Core\Type\Exception\ConstraintException;
use PHPUnit\Framework\TestCase;

class DayNumberTest extends TestCase
{
    /**
     * @dataProvider correctValueProvider
     */
    public function testDayNumberAllowsValidValues(int $value): void
    {
        $wholeNumber = new DayNumber($value);
        $this->assertEquals($value, $wholeNumber->getValue());
    }

    /**
     * @dataProvider incorrectValueProvider
     */
    public function testDayNumberAllowsInvalidValues(int $value): void
    {
        $this->expectException(ConstraintException::class);
        $wholeNumber = new DayNumber($value);
    }

    public function correctValueProvider(): array
    {
        return [
            [0],
            [1],
            [2],
            [3],
            [4],
            [5],
            [6],
        ];
    }

    public function incorrectValueProvider(): array
    {
        return [
            [-1],
            [7],
            [8]
        ];
    }
}