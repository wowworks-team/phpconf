<?php

use App\Entity\Profile;
use App\Helper\DateHelper;
use App\Service\ProfileService;
use App\Tests\Mock\DateHelperMock;

class ProfileTest extends \PHPUnit\Framework\TestCase
{
    public function testGetUpdatedAt()
    {
        $object = new Profile();
        $object->updated_at = null;
        $this->assertNull($object->getUpdatedAtDateTime());

        $object->updated_at = '2019-01-01';
        $this->assertInstanceOf(DateTime::class, $object->getUpdatedAtDateTime());
    }

    // not working example, depends on current time
    public function testIsInactiveBad()
    {
        $helper = new DateHelper();
        $service = new ProfileService($helper);
        $profile = new Profile();

        $profile->updated_at = '2018-01-01';
        $this->assertTrue($service->isInactive($profile));

        $profile->updated_at = '2019-01-01';
        $this->assertFalse($service->isInactive($profile));
    }

    public function testIsInactive()
    {
        $helper = new DateHelperMock();
        $service = new ProfileService($helper);
        $profile = new Profile();

        $helper->setCurrentDate('2019-01-01');
        $profile->updated_at = '2018-01-01';
        $this->assertTrue($service->isInactive($profile));

        $helper->setCurrentDate('2019-01-01');
        $profile->updated_at = '2019-01-01';
        $this->assertFalse($service->isInactive($profile));
    }
}
