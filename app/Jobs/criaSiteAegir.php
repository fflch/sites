<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use GuzzleHttp\Client;

class criaSiteAegir implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $alvo;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($alvo)
    {
        $this->alvo = $alvo;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $dnszone = config('solicitasite.dnszone');
        $alvo = $this->alvo . $dnszone;
        $site_modelo = config('solicitasite.modelo');
        $id_node_bd = config('solicitasite.id_node_bd');
        $id_node_plataforma = config('solicitasite.id_node_plataforma');

        $client = new Client([
            'base_uri' => 'http://aegir.fflch.usp.br'
        ]);

        $res = $client->request('POST', '/aegir/saas/task/', [
            'form_params' => [
                'target' => $site_modelo,
                'type' => 'clone',
                'options[new_uri]' => $alvo,
                'options[database]' => $id_node_bd,
                'options[target_platform]' => $id_node_plataforma,
                'api-key' => 'ZYODpIU-GhDtTJThA2Z-HQ'
            ]
        ]);
    }
}
