<?php

/**
 * Default config values
 */
return [
    
    'route' => [
        'api' => [
            'prefix'    => 'api/admin',
            'middleware' => ['api', \CeddyG\ClaraSentinel\Http\Middleware\SentinelAccessMiddleware::class.':api']
        ]
    ],
    
    'size' => [
        'small' => 76,
        'medium' => 246,
        'large' => 492,
    ],
    
    'encode' => [
        'extension' => 'jpg',
        'quality' => 80,
    ]
    
];
