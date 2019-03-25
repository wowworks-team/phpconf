<?php

namespace App\Tests\ActiveRecord;

use App\ActiveRecord\Profile;
use Mockery;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Exception;
use DateTime;

class ProfileTest extends TestCase
{
    public function testGetUpdatedAtDateTimeFailed()
    {
        $object = new Profile();
        $object->getUpdatedAtDateTime();
    }

    /**
     * @dataProvider emptyDataProvider
     * @param $value
     */
    public function testGetUpdatedAtDateTimeWithEmpty($value)
    {
        $object = $this->getMock();
        $object->updated_at = $value;
        $this->assertNull($object->getUpdatedAtDateTime());
    }

    public function emptyDataProvider(): array
    {
        return [
            [null],
            [''],
            [0],
            [false],
        ];
    }

    /**
     * @dataProvider wrongFormatDataProvider
     * @param $value
     */
    public function testGetUpdatedAtDateTimeWithWrongFormat($value)
    {
        $object = $this->getMock();
        $object->updated_at = $value;
        $this->expectException(Exception::class);
        $object->getUpdatedAtDateTime();
    }

    public function wrongFormatDataProvider(): array
    {
        return [
            ['123'],
            [123],
            ['some text'],
        ];
    }

    /**
     * @dataProvider dateTimeDataProvider
     * @param $value
     */
    public function testGetUpdatedAtDateTime($value)
    {
        $object = $this->getMock();
        $object->updated_at = $value;
        $this->assertInstanceOf(DateTime::class, $object->getUpdatedAtDateTime());
    }

    public function dateTimeDataProvider(): array
    {
        return [
            ['now'],
            ['2019-01-01'],
            ['tomorrow'],
            ['+1 day'],
        ];
    }

    /**
     * @return Profile|Mockery\Mock
     */
    private function getMock()
    {
        /** @var Profile|Mockery\Mock $object */
        $object = Mockery::mock(Profile::class);
        $object->shouldReceive('attributes')->andReturn(['updated_at']);
        $object->makePartial();

        return $object;
    }
}
