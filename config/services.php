<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'vonage' => [
      'api_key'=>env('VONAGE_KEY'),
      'secret_key'=>env('VONAGE_SECRET'),
      'from'=>env('VONAGE_SMS_FROM'),
    ],

    'github' => [
        'client_id' => env('GITHUB_CLIENT_ID'),
        'client_secret' => env('GITHUB_CLIENT_SECRET'),
        'redirect' => env('OAUTH_CALLBACK_URL'),
    ],

      'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_OAUTH_CALLBACK_URL'),
    ],

    'paddle' => [
      'monthly' => env('Monthly_Plan'),
      'yearly' => env('Yearly_Plan'),
      'vendor_id'=>env('PADDLE_VENDOR_ID'),
      'vendor_auth_code'=>env('PADDLE_VENDOR_AUTH_CODE'), 
      'results_per_page'=>10,
     ],

    'paypal' => [
        'id' => env('PAYPAL_ID'),
        'secret' => env('PAYPAL_SECRET'),
        'url'=>[
            'executeAgreement'=>[
                'success'=>'http://localhost:8000/execute-agreement/true',
                'failure'=>'http://localhost:8000/execute-agreement/false'
            ]
        ]
    ],

    'zoom' => [
        'client_id'=> env('ZOOM_CLIENT_ID'),
        'client_secret'=> env('ZOOM_CLIENT_SECRET'), 
        'webhook_secret'=> env('ZOOM_WEBHOOK_SECRET_TOKEN'),
    ],



];
