<?php

return [
    'dnszone' => env('DNSZONE', false),
    'unidades_usp' => env('UNIDADES_USP',false),
    'deploy_secret_key' => env('DEPLOY_SECRET_KEY', false),
    'admins' => env('SENHAUNICA_ADMINS'),
    'webserver_aprovado' => env('WEBSERVER_APROVADO', '192.168.0.1'),
    'webserver_nao_aprovado' => env('WEBSERVER_NAO_APROVADO', '192.168.0.2'),
];
