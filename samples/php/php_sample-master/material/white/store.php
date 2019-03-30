<?php

return [


    /**
     * General
     */
    'name'      => 'lavender commerce',
    'logo'      => 'images/logo.svg',
    'email'     => 'support@lavendercommerce.com',
    'phone'     => null,
    'address'   => 'not set',
    'hours'     => null,

    /**
     * Account
     */
    // registration options
    'signup_email' => true, // send email on signup?
    'signup_confirm' => true, // user must be confirmed?

    // login throttling
    // todo options per auth type
    'login_cache_field' => 'email', // throttle login by this field
    'throttle_limit' => 9, // number of failed attempts
    'throttle_time_period' => 2, // seconds; concurrent requests must be under this limit

    // passwords
    'password_reset_expiration' => 7, // hours

    // account emails
    'email_reset_password' =>       'emails.passwordreset', // with $user and $token.
    'email_account_confirmation' => 'emails.confirm', // with $user


    /**
     * Catalog
     */
    'product_count' => 5,


    /**
     * Message Types: are used to create and display global messages
     * throughout the application. By default, these are displayed
     * in the layouts.elements.messages template by MessageComposer
     * ex: Message::addSuccess("foo")
     * echo Message::getSuccess() //foo
     */
    'message_types' => ['success', 'notice', 'warning', 'error'],


    'store_rules' => [

        10 => 'App\Handlers\Rules\EnvMatch',

        20 => 'App\Handlers\Rules\CookieMatch',

        30 => 'App\Handlers\Rules\DomainMatch',

        40 => 'App\Handlers\Rules\SubdomainMatch',

    ],
];
