<?php

namespace common\config;

use common\eventHandlers\InsertEventHandler;
use Yii;
use yii\base\BootstrapInterface;
use yii\base\Event;
use yii\db\ActiveRecord;

class BootstrapEvents implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        $this->attachActiveRecordHandlers();
    }

    private function attachActiveRecordHandlers()
    {
        Event::on(ActiveRecord::class, ActiveRecord::EVENT_AFTER_INSERT, [
            Yii::createObject(InsertEventHandler::class),
            'handle'
        ]);
    }
}
