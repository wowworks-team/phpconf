<?php

namespace common\eventHandlers;

use common\services\LoggerService;
use yii\base\Event;
use yii\db\ActiveRecord;

class InsertEventHandler
{
    /** @var LoggerService */
    private $loggerService;

    public function __construct(LoggerService $loggerService)
    {
        $this->loggerService = $loggerService;
    }

    public function handle(Event $event)
    {
        if ($event->sender instanceof ActiveRecord) {
            // call service and do some logic
            $this->loggerService->logActiveRecord($event->sender);
        }
    }
}
