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
		'client_id' => '1636769806607460',
		'client_secret' => '6170f625bdfec0145c10e9e5e796b52b',
		'redirect' => (PHP_SAPI === 'cli'?false:url('/kayit/facebook')) // url helper function won't work when using cli (php artisan). If really needed, it's posibble add application url to .env file.
	],
	
	'twitter' => [
		'client_id' => 'HB3za62hSn0GVhf0JklwOwKjh',
		'client_secret' => 'nv8mzeTUruA1ThEahTu3Jng10G7ZrMHMgHiAgPY42e4Oa6FYdy',
		'redirect' => (PHP_SAPI === 'cli'?false:url('/kayit/twitter'))
	],

    'paypal' => [
        'client_id' => 'AYmx0okMy4WPulZLuY59T5ga3cLTFTfxzJrAtLKFSJGv_aP8ODoSHKIu4jQ0I-gugXtLJJTebtiQNAPb',
        'secret' => 'EGIk-_2ph8ytFvV4rXDcfGK_fCcyawmn3G2p3WqNKJbEbNGljVSrX4rGXXaUiqpfGdM9xDZ11R94Fxlc'
    ],
];
