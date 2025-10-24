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
        $suffix =  config('sites.dnszone') . '. IN A ' . config('sites.webserver');
        foreach( $sites as $site ) {
            if ( $site->dominio <> 'www') {
                $content .= $site->dominio . $suffix . PHP_EOL;
                $content .= 'www.' . $site->dominio . $suffix . PHP_EOL;
            }
        }

        return response($content, 200)->header('Content-Type', 'text/plain');
    }
}
