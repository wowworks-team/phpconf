<?php

namespace App\Tests\Mock;

use DateTime;
use PHPUnit\Framework\TestCase;

class DateHelperMockTest extends TestCase
{
    const TIME_DELTA = 5;

    /** @var DateHelperMock */
    private $object;

    protected function setUp()
    {
        parent::setUp();
        $this->object = new DateHelperMock();
    }

    public function testGetDateTimeDefault()
    {
        $expected = new DateTime();
        $actual = $this->object->getDateTime();
        $this->assertEquals($expected, $actual, '', self::TIME_DELTA);
    }

    /**
     * @param string $currentDate
     * @param string $expected
     * @param string $time
     * @dataProvider dataProvider
     */
    public function testGetDateTime($currentDate, $expected, $time)
    {
        $expected = new DateTime($expected ? : $currentDate);
        $this->object->setCurrentDate($currentDate);
        $actual = $this->object->getDateTime($time);
        $this->assertEquals($expected, $actual, '', self::TIME_DELTA);
    }

    public function dataProvider(): array
    {
        return [
            ['now', null, null],
            ['now', null, 'now'],
            ['2000-01-01', null, null],
            ['2200-01-01', null, null],
            ['2000-01-01', '2000-01-02', '+1 day'],
            ['2000-01-01', '1999-12-31', '-1 day'],
            ['2200-01-01', '2200-01-02', '+1 day'],
            ['2200-01-01', '2199-12-31', '-1 day'],
        ];
    }
}
