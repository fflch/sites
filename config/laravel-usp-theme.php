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
    ],

];
