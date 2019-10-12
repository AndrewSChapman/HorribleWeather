<?php

namespace App\Tests\Unit\Core\Type;

use App\Core\Type\Exception\InvalidTimeException;
use App\Core\Type\Time;
use App\Core\Type\WholeNumber;
use PHPUnit\Framework\TestCase;

class TimeTest extends TestCase
{
    public function testTimeWillReportCorrectHoursMinutesAndSeconds(): void
    {
        for ($hour = 0; $hour < 24; $hour++) {
            for ($minute = 0; $minute < 60; $minute++) {
                for ($second = 0; $second < 60; $second++) {
                    $totalSecs = $second + ($minute * 60) + ($hour * 3600);
                    $time = new Time(new WholeNumber($totalSecs));

                    $this->assertEquals($hour, $time->getHour()->getValue());
                    $this->assertEquals($minute, $time->getMinute()->getValue());
                    $this->assertEquals($second, $time->getSeconds()->getValue());
                }
            }
        }
    }

    /**
     * @dataProvider timeValueProvider
     */
    public function testTimeWillConvertToStringCorrectly($hour, $minute, $second, $expectedTimeString): void
    {
        $totalSecs = $second + ($minute * 60) + ($hour * 3600);
        $time = new Time(new WholeNumber($totalSecs));
        $this->assertEquals($expectedTimeString, $time->toString());
    }

    /**
     * @dataProvider timeValueProvider
     */
    public function testTimeWillConstructFromTimeStringCorrectly($hour, $minute, $second, $timeString): void
    {
        $totalSecs = $second + ($minute * 60) + ($hour * 3600);
        $time = new Time(new WholeNumber($totalSecs));

        $timeFromString = Time::fromString($timeString);

        $this->assertTrue($time->equals($timeFromString));
    }

    /**
     * @dataProvider invalidTimeStringValueProvider
     */
    public function testTimeWillThrowExceptionIfTimeStringInvalid($invalidTimeString): void
    {
        $this->expectException(InvalidTimeException::class);
        $timeFromString = Time::fromString($invalidTimeString);
    }

    public function timeValueProvider(): array
    {
        return [
            [0, 0, 0, '00:00:00'],
            [0, 15, 30, '00:15:30'],
            [11, 59, 59, '11:59:59'],
            [22, 45, 12, '22:45:12'],
        ];
    }

    public function invalidTimeStringValueProvider(): array
    {
        return [
            ['FISH'],
            ['00:00'],
            ['0e:00:00'],
            ['00:0e:00'],
            ['00:00:0e'],
            ['24:00:00'],
            ['00:60:00'],
            ['00:00:60'],
            ['-1:00:00'],
        ];
    }
}