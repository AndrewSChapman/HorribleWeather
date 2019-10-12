<?php

namespace App\Tests\Unit\Core\Type;

use App\Core\Type\ConstrainedString;
use App\Core\Type\Exception\ConstraintException;
use PHPUnit\Framework\TestCase;

class ContainedStringTest extends TestCase
{
    public function testConstrainedStringWillThrowExceptionIfValueTooShort(): void
    {
        $this->expectException(ConstraintException::class);
        $this->getConstrainedString('');
    }

    public function testConstrainedStringWillThrowExceptionIfValueTooLong(): void
    {
        $this->expectException(ConstraintException::class);
        $this->getConstrainedString('I AM LONGER THAN 20 CHARACTERS');
    }

    public function testConstrainedStringWillAllowCorrectValue(): void
    {
        $myString = $this->getConstrainedString('Banana Man');
        $this->assertEquals('Banana Man', $myString->getValue());
    }

    private function getConstrainedString(string $value): ConstrainedString
    {
        return new Class($value) extends ConstrainedString {
            public function __construct(string $value)
            {
                parent::__construct($value, 1, 20);
            }
        };
    }
}