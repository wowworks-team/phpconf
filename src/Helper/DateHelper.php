<?php

namespace App\Helper;

use DateTime;

class DateHelper
{
    public function getDateTime(?string $time = null): DateTime
    {
        return new DateTime($time);
    }
}
