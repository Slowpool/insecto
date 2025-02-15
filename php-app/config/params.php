<?php

return [
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'sender',

    'yiisoft/yii-swagger' => [
        'annotation-paths' => [
            '@app/controllers/API' // Directory where annotations are used
        ],
        'cacheTTL' => 60 // Enables caching and sets TTL, "null" value means infinite cache TTL.
    ],
];
