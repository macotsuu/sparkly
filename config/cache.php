<?php

return [
    'default' => 'redis',
    'adapters' => [
        'redis' => [
            'host' => env('REDIS_HOST', 'localhost'),
            'port' => env('REDIS_PORT', 6379)
        ]
    ]
];