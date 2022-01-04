<?php

/**
 * Default config values
 */
return [
    
    'route' => [
        'web-admin' => [
            'prefix'    => 'admin',
            'middleware' => ['web', \CeddyG\ClaraSentinel\Http\Middleware\SentinelAccessMiddleware::class]
        ],
        'api' => [
            'prefix'    => 'api/admin',
            'middleware' => ['api', \CeddyG\ClaraSentinel\Http\Middleware\SentinelAccessMiddleware::class.':api']
        ]
    ],
    
];
