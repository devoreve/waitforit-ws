<?php

return [
    'defaults' => [
        'guard' => env('AUTH_GUARD', 'user'),
    ],
    'guards' => [
        'user' => [
            'driver' => 'jwt',
            'provider' => 'user',
        ]
    ],
    'providers' => [
        'user' => [
            'driver' => 'eloquent',
            'model' => App\User::class
        ]
    ]
];