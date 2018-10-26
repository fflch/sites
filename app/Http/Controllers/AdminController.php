<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Site;
use GuzzleHttp\Client;
use App\Jobs\clonaSiteAegir;
use App\Jobs\desabilitaSiteAegir;
use App\Jobs\habilitaSiteAegir;
use App\Jobs\deletaSiteAegir;

class AdminController extends Controller
{
    private $dns_zone;

    public function __construct()
    {
        $this->dns_zone = config('solicitasite.dns_zone');
    }

    public function listaSites()
    {
        $client = new Client([
             'base_uri' => 'http://aegir.fflch.usp.br/',
        ]);
        $res = $client->request('GET','/aegir/saas/site.json', ['query' => ['api-key' => 'ZYODpIU-GhDtTJThA2Z-HQ']]);
        $sites_aegir = json_decode($res->getBody());

        $dnszone = $this->dns_zone;
        $sites = Site::all()->sortBy('dominio');
        return view('admin/lista-sites', compact('sites','dnszone','sites_aegir'));
    }

    public function listaTodosSites()
    {
        $client = new Client([
             'base_uri' => 'http://aegir.fflch.usp.br/',
        ]);
        $res = $client->request('GET','/aegir/saas/site.json', ['query' => ['api-key' => 'ZYODpIU-GhDtTJThA2Z-HQ']]);
        $sites_aegir = json_decode($res->getBody());
        $dnszone = $this->dns_zone;
        $sites = Site::all()->sortBy('dominio');
        return view('admin/lista-todos-sites', compact('sites','dnszone','sites_aegir'));
    }

    public function cloneSite(Request $request, Site $site)
    {
      
      $alvo = $site->dominio . $this->dns_zone;
      clonaSiteAegir::dispatch($alvo);

      $request->session()->flash('alert-info', 'Clonagem do site em andamento');
      return redirect('/sites');
    }

    public function disableSite(Request $request, Site $site)
    {
      $alvo = $site->dominio . $this->dns_zone;
      desabilitaSiteAegir::dispatch($alvo);

      $request->session()->flash('alert-info', 'Desabilitação do site em andamento');
      return redirect('/sites');
    }

    public function enableSite(Request $request, Site $site)
    {
      $alvo = $site->dominio . $this->dns_zone;
      habilitaSiteAegir::dispatch($alvo);

      $request->session()->flash('alert-info', 'Habilitação do site em andamento');
      return redirect('/sites');
    }

    public function deleteSite(Request $request, Site $site)
    {
      $alvo = $site->dominio . $this->dns_zone;
      deletaSiteAegir::dispatch($alvo);

      $request->session()->flash('alert-info', 'Deleção do site em andamento');
      return redirect('/sites');
    }
}
