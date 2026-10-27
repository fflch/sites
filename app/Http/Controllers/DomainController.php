<?php

namespace App\Http\Controllers;

use App\Models\Site;

class DomainController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $sites = Site::orderBy('dominio', 'ASC')
            ->select('dominio')
            ->toBase()
            ->get();
        $content = '';
        foreach( $sites as $site ) {
            # hotfix para problema php: Thiago
            if($site->status == "Aprovado - Habilitado"){
                $suffix =  config('sites.dnszone') . '. IN A ' . config('sites.webserver_aprovado');
            } else {
                $suffix =  config('sites.dnszone') . '. IN A ' . config('sites.webserver_nao_aprovado');
            }
            if ( $site->dominio <> 'www') {
                $content .= $site->dominio . $suffix . PHP_EOL;
                $content .= 'www.' . $site->dominio . $suffix . PHP_EOL;
            }
        }

        return response($content, 200)->header('Content-Type', 'text/plain');
    }
}
