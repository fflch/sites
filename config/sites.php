<?php

return [
    'dnszone' => env('DNSZONE', false),
    'unidades_usp' => env('UNIDADES_USP',false),
    'deploy_secret_key' => env('DEPLOY_SECRET_KEY', false),
    'admins' => env('ADMINS'),
    'webserver' => env('WEBSERVER', '192.168.0.1'),
];
