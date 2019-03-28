<?php

namespace common\config;

use common\services\Jira\JiraService;
use Yii;
use yii\base\BootstrapInterface;

class BootstrapContainer implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        $container = Yii::$container;

        $container->setSingleton(
            JiraService::class,
            [
                'class' => JiraService::class,
            ],
            [
                $app->params['jira']['host'],
                $app->params['jira']['user'],
                $app->params['jira']['token'],
            ]
        );
    }
}
