<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => '',
        'secret' => '',
    ],

    'mandrill' => [
        'secret' => '',
    ],

    'ses' => [
        'key'    => '',
        'secret' => '',
        'region' => 'us-east-1',
    ],

    'stripe' => [
        'model'  => App\User::class,
        'key'    => '',
        'secret' => '',
    ],
	
	'facebook' => [
		'client_id' => '163718891061423',
		'client_secret' => '16b5e67353f5ff44ec75c8258cbe4bbd',
		'redirect' => (PHP_SAPI === 'cli'?false:url('/kayit/facebook')) // url helper function won't work when using cli (php artisan). If really needed, it's posibble add application url to .env file.
	],
	
	'twitter' => [
		'client_id' => 'Zx99CefNr03wZn7Y51MxR6YRx',
		'client_secret' => '6ldEtQKxJDrtlc1Whsl4BrmGzOp0yugepGyZOELmOKwI9p1V5y',
		'redirect' => (PHP_SAPI === 'cli'?false:url('/kayit/twitter'))
	]
];
