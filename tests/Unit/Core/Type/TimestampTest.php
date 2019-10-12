<?php
namespace Tests\Unit\ChapmanDigital\Util\Type;

use App\Core\Type\Exception\ConstraintException;
use App\Core\Type\Timestamp;
use PHPUnit\Framework\TestCase;

class TimestampTest extends TestCase
{
    public function testTimestampWillCreateCorrectlyIfInitNotProvided(): void
    {
        $timestamp = $this->getTimestamp();
        $this->assertGreaterThan(0, $timestamp->getTimestamp());
    }

    public function testTimestampWillCreateCorrectlyIfInitialTimestampProvided(): void
    {
        $timestamp = $this->getTimestamp(1560081124);
        $this->assertEquals(1560081124, $timestamp->getTimestamp());
        $this->assertEquals('2019-06-09 11:52:04', $timestamp->__toString());
    }

    public function testTimestampWillCreateCorrectlyIfInitialDateTimeProvided(): void
    {
        $timestamp = $this->getTimestamp('2019-06-09 11:52:04');
        $this->assertEquals(1560081124, $timestamp->getTimestamp());
        $this->assertEquals('2019-06-09 11:52:04', $timestamp->__toString());
    }

    public function testTimestampWillThrowExceptionIfInitialDateTimeInvalid(): void
    {
        $this->expectException(ConstraintException::class);
        $timestamp = $this->getTimestamp('NOT A VALID DATE');
    }

    private function getTimestamp($init = ''): Timestamp
    {
        return new Class($init) extends Timestamp
        {
            public function __construct($init = null)
            {
                parent::__construct($init);
            }
        };
    }
}