<?php

namespace App\Http\Controllers;

use App\Site;
use Illuminate\Http\Request;
use Auth;
use App\Jobs\criaSiteAegir;
use App\Aegir\Aegir;


class SiteController extends Controller
{
    private $aegir;
    private $dns_zone;

    public function __construct()
    {
        $this->middleware('can:admin');
        $this->aegir = new Aegir;
        $this->dns_zone = config('solicitasite.dns_zone');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dnszone = $this->dns_zone;
        //$sites = Site::all()->where('owner',\Auth::user()->codpes)->sortBy('dominio');
        $sites = Site::all();

        // Busca o status dos sites no aegir
        foreach($sites as $site){
            $site->status = $this->aegir->verificaStatus($site->dominio);
        }

        return view('sites/index', compact('sites','dnszone'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dnszone = $this->dns_zone;

        return view('sites/create', compact('dnszone')); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $site = new Site;
      $site->dominio = $request->dominio;
      $alvo = $site->dominio;
      $site->numeros_usp = $request->numeros_usp;
      $site->owner = \Auth::user()->codpes;
      $site->save();

      criaSiteAegir::dispatch($alvo);

      $request->session()->flash('alert-info', 'Criação do site em andamento');
      return redirect('/sites');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function show(Site $site)
    {
        $data = [
            //Full Qualified Domain Name
            'fqdn' => $site->dominio . $this->dns_zone
        ];
        return view ('sites/show', compact('site'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function edit(Site $site)
    {
        return view('sites/edit', compact('site'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Site $site)
    {
        $site->dominio = $request->dominio;
        $site->numeros_usp = $request->numeros_usp;
        $site->owner = \Auth::user()->codpes;
        $site->save();
        return redirect("/sites/$site->id");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function destroy(Site $site)
    {
        $site->delete();
        return redirect('/');
    }

    public function Owners(Request $request, $site)
    {
        /*
        if($request->apikey != env('AEGIR_KEY'))
        {
            return response('Unauthorized action.', 403);
        }
        */

        $dominio = str_replace('.fflch.usp.br','',$site);
        $site = Site::where('dominio',$dominio)->first();
        $numeros_usp = $site->owner . ','. str_replace(' ', '', $site->numeros_usp);

        return response()->json($numeros_usp);
    }
}
