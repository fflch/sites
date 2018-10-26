<?php
    /*
    |--------------------------------------------------------------------------
    | Configurações customizadas do Projeto Solicita Site
    |--------------------------------------------------------------------------
    | 
    | TODO: Documentar os parâmetros:
    |
    SITE_MODELO=
    ID_NODE_BD=
    ID_NODE_PLATAFORMA=
    */
return [
    'modelo' => env('SITE_MODELO', false),
    'id_node_bd' => env('ID_NODE_BD', false),
    'id_node_plataforma' => env('ID_NODE_PLATAFORMA',false),

    /*
    |--------------------------------------------------------------------------
    | Zona DNS dos sites
    |--------------------------------------------------------------------------
    |   Deve seguir o seguinte formato: 
    |   .meu.site.maneiro.com.br
    |   ^ não esquecer do ponto no início
    */
    'dns_zone' => env("DNSZONE", '')

];