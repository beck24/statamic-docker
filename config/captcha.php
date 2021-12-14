<?php

return [
    'service' => 'Recaptcha', // options: Recaptcha / Hcaptcha
    'sitekey' => env('CAPTCHA_SITEKEY', ''),
    'secret' => env('CAPTCHA_SECRET', ''),
    'collections' => [],
    'forms' => [
        'contact',
        'future_applicant'
    ],
    'user_login' => false,
    'user_registration' => false,
    'error_message' => 'Captcha failed.',
    'disclaimer' => '',
    'invisible' => false,
    'hide_badge' => true,
    'enable_api_routes' => false,
];
