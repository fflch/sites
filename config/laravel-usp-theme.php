<?php

$avisos =  [
    [
        'text' => 'Listar',
        'url'  => '/avisos',
    ],
    [
        'text' => 'Cadastrar',
        'url'  => '/avisos/create',
        'can'     => 'admin',
    ],
];

$right_menu = [
    [
        // menu utilizado para views da biblioteca senhaunica-socialite.
        'key' => 'senhaunica-socialite',
    ],
    [
        'key' => 'laravel-tools',
    ],
];


return [

    'title' => '',
    'skin' => env('USP_THEME_SKIN', 'uspdev'),
    'app_url' => config('app.url'),
    'logout_method' => 'POST',
    'logout_url' => config('app.url') . '/logout',
    'login_url' => config('app.url') . '/login',

    'menu' => [
        [
            'text' => 'Meus Sites',
            'url'  => '/sites',
            'can'  => 'sites.create'
        ],
        [
            'text'    => 'Avisos',
            'submenu' => $avisos,
            'can'     => 'admin',
        ],
        [
            'text' => 'Emails',
            'url'  => '/emails',
            'can'  => 'admin'
        ],
        [
            'text' => 'Solicitar site',
            'url' => '/sites/create',
            'can' => 'sites.create',
        ],
    ],
    'right_menu' => $right_menu

];
