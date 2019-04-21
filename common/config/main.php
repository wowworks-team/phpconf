<?php
return [
    // ...
    'bootstrap' => [
        'common\config\BootstrapContainer',
        'common\config\BootstrapEvents',
    ],
    // https://www.yiiframework.com/doc/guide/2.0/en/concept-configurations#application-configurations
    // https://www.yiiframework.com/doc/guide/2.0/en/concept-di-container#advanced-practical-usage
    'container' => [
        'definitions' => [
            'yii\widgets\LinkPager' => ['maxButtonCount' => 5]
        ],
        'singletons' => [
            // Dependency Injection Container singletons configuration
        ]
    ],
    'components' => [
        // ...
    ],
];
