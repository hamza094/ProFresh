<?php

return [
    /**
     * To disable the pixel injection, set this to false.
     */
    'inject-pixel' => true,

    /**
     * To disable injecting tracking links, set this to false.
     */
    'track-links' => true,

    /**
     * Optionally expire old emails, set to 0 to keep forever.
     */
    'expire-days' => 60,

    /**
     * Where should the pingback URL route be?
     */
    'route' => [
        'prefix' => 'email',
        'middleware' => ['api'],
    ],

    /**
     * Where should the admin route be?
     */
    'admin-route' => [
        'enabled' => true, // Should the admin routes be enabled?
        'prefix' => 'email-manager',
        'middleware' => [
            'web',
            'can:see-sent-emails'
        ],
    ],

    /**
     * Admin Tamplate
     * example
     * 'name' => 'layouts.app' for Default emailTraking use 'emailTrakingViews::layouts.app'
     * 'section' => 'content' for Default emailTraking use 'content'
     * 'styles_section' => 'styles' for Default emailTraking use 'styles'
     */
    'admin-template' => [
        'name' => 'emailTrakingViews::layouts.app',
        'section' => 'content',
    ],

    /**
     * Number of emails per page in the admin view
     */
    'emails-per-page' => 30,

    /**
     * Date Format
     */
    'date-format' => 'm/d/Y g:i a',

    /**
     * Default database connection name (optional - use null for default)
     */
    'connection' => null,

    /**
     * The SNS notification topic - if set, discard all notifications not in this topic.
     */
    'sns-topic' => null,

    /**
     * Determines whether or not the body of the email is logged in the sent_emails table
     */
    'log-content' => true,

    /**
     * What queue should we dispatch our tracking jobs to?  Null will use the default queue.
     */
    'tracker-queue' => null,

];
