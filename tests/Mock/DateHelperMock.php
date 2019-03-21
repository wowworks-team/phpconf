<?php

namespace App\Tests\Mock;

use App\Helper\DateHelper;
use DateInterval;
use DateTime;

class DateHelperMock extends DateHelper
{
    /** @var DateInterval */
    private $diff;

    public function setCurrentDate(string $date)
    {
        $today = $this->getDateTime();
        $newDate = $this->getDateTime($date);
        $this->diff = $today->diff($newDate);
    }

    public function getDateTime(?string $time = null): DateTime
    {
        $dateTime = parent::getDateTime($time);
        return $this->diff ? $dateTime->add($this->diff) : $dateTime;
    }
}
