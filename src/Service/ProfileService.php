<?php

namespace App\Service;

use App\Entity\Profile;
use App\Helper\DateHelper;

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
        return $profile->getUpdatedAtDateTime() < $date;
    }
}
