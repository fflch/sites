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
            ->select('dominio', 'dns')
            ->toBase()
            ->get();
        $content = '';
        foreach( $sites as $site ) {
            $dns = $site->dns ?? config('sites.dns');
            $suffix =  config('sites.dnszone') . '. IN A ' . $dns;
            if ( $site->dominio <> 'www') {
                $content .= $site->dominio . $suffix . PHP_EOL;
                $content .= 'www.' . $site->dominio . $suffix . PHP_EOL;
            } else {
                $content .= mb_substr($suffix, 1) . PHP_EOL;
                $content .= $site->dominio . $suffix . PHP_EOL;
            }
        }

        return response($content, 200)->header('Content-Type', 'text/plain');
    }
}
