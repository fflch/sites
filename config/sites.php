<?php

return [
    'dnszone' => env('DNSZONE', 'site.local.br'),
    'unidades_usp' => env('UNIDADES_USP',false),
    'deploy_secret_key' => env('DEPLOY_SECRET_KEY', false),
    'admins' => env('SENHAUNICA_ADMINS'),
    'dns' => env('DNS', '192.168.0.1'),
];
