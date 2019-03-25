<?php

namespace App\ActiveRecord;

use DateTime;
use yii\db\ActiveRecord;

/**
 * Class Profile
 *
 * @property string $updated_at
 */
class Profile extends ActiveRecord
{
    public function getUpdatedAtDateTime(): ?DateTime
    {
        return $this->updated_at ? new DateTime($this->updated_at) : null;
    }
}
