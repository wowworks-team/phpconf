<?php

/**
 * Class Profile
 *
 * @property string $updated_at
 */
class Profile extends \yii\db\ActiveRecord
{
    public function getUpdatedAt(): ?DateTime
    {
        return $this->updated_at ? new DateTime($this->updated_at) : null;
    }

    // some logic with date
    public function isInactive(): bool
    {
        $date = new DateTime('-3 month');
        return $this->getUpdatedAt() < $date;
    }
}

class ProfileTest extends \PHPUnit\Framework\TestCase
{
    /** @var Profile */
    private $object;

    protected function setUp()
    {
        parent::setUp();
        $this->object = new Profile();
    }

    public function testGetUpdatedAt()
    {
        $this->object->updated_at = null;
        $this->assertNull($this->object->getUpdatedAt());

        $this->object->updated_at = '2019-01-01';
        $this->assertInstanceOf(DateTime::class, $this->object->getUpdatedAt());
    }

    public function testIsInactive()
    {
        // ... ???
    }
}
