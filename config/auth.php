<?php

return [

    'multi' => [
        'user' => [
            'driver' => 'eloquent',
            'model' => App\User::class,
            'table' => 'users',
        ],
        'customer' => [
            'driver' => 'database',
            'table' => 'customers',
            'email' => 'customer.emails.password',
        ]
    ],

    'password' => [
        'email' => 'emails.password',
        'table' => 'password_resets',
        'expire' => 60,
    ],

];