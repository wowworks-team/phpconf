<?php

/**
 * Class Profile
 *
 * @property string $updated_at
 */
class Profile extends \yii\db\ActiveRecord
{
    public function getUpdatedAtDateTime(): ?DateTime
    {
        return $this->updated_at ? new DateTime($this->updated_at) : null;
    }
}

class DateHelper
{
    public function getDateTime(string $time = 'now'): DateTime
    {
        return new DateTime($time);
    }
}

class ProfileService
{
    /** @var DateHelper */
    private $dateHelper;

    /**
     * ProfileService constructor.
     * @param DateHelper $dateHelper
     */
    public function __construct(DateHelper $dateHelper)
    {
        $this->dateHelper = $dateHelper;
    }

    public function isInactive(Profile $profile): bool
    {
        $date = $this->dateHelper->getDateTime('-3 month');
        return $profile->getUpdatedAt() < $date;
    }
}

class DateHelperMock extends DateHelper
{
    /** @var DateInterval */
    private $diff = '+0 day';

    public function setCurrentDate(string $date)
    {
        $today = $this->getDateTime();
        $newDate = $this->getDateTime($date);
        $this->diff = $today->diff($newDate);
    }

    public function getDateTime(string $time = 'now'): DateTime
    {
        return parent::getDateTime($time)->sub($this->diff);
    }
}

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
