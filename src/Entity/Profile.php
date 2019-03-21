<?php

namespace App\Entity;

use DateTime;

/**
 * Class Profile
 *
 * @property string $updated_at
 */
class Profile
{
    public function getUpdatedAtDateTime(): ?DateTime
    {
        return $this->updated_at ? new DateTime($this->updated_at) : null;
    }
}
