<?php

namespace App\Helper;

use DateTime;

class DateHelper
{
    public function getDateTime(string $time = 'now'): DateTime
    {
        return new DateTime($time);
    }
}
