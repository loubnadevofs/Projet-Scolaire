<?php

return [
    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'admin' => [
            'driver' => 'session',
            'provider' => 'users', // Utilise la même table users avec un champ role
        ],
        'enseignant' => [
            'driver' => 'session',
            'provider' => 'enseignants',
        ],
        'formateur' => [
            'driver' => 'session',
            'provider' => 'formateurs',
        ],
        'api' => [
            'driver' => 'token',
            'provider' => 'users',
            'hash' => false,
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],
        'enseignants' => [
            'driver' => 'eloquent',
            'model' => App\Models\Enseignant::class,
        ],
        'formateurs' => [
            'driver' => 'eloquent',
            'model' => App\Models\Formateur::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
        'enseignants' => [
            'provider' => 'enseignants',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,
];