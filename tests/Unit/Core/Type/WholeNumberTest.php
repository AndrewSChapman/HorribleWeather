<?php

namespace App\Tests\Unit\Core\Type;

use App\Core\Type\Exception\ConstraintException;
use App\Core\Type\WholeNumber;
use PHPUnit\Framework\TestCase;

class WholeNumberTest extends TestCase
{
    /**
     * @dataProvider correctValueProvider
     */
    public function testWholeNumberAllowsValidValues(int $value): void
    {
        $wholeNumber = new WholeNumber($value);
        $this->assertEquals($value, $wholeNumber->getValue());
    }

    /**
     * @dataProvider incorrectValueProvider
     */
    public function testWholeNumberAllowsInvalidValues(int $value): void
    {
        $this->expectException(ConstraintException::class);
        $wholeNumber = new WholeNumber($value);
    }

    public function correctValueProvider(): array
    {
        return [
            [0],
            [1],
            [100],
            [1000]
        ];
    }

    public function incorrectValueProvider(): array
    {
        return [
            [-1],
            [-100],
            [-1000]
        ];
    }
}