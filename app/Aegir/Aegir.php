<?php

namespace App\Aegir;
use GuzzleHttp\Client;

class Aegir
{
    private $aegir_host;
    private $aegir_key;
    private $aegir_protocol;

    // variável para testar aegir está no ar
    private $client;
    private $clientStatus = true;

    public function __construct()
    {
        // variáveis em config/aegir.php
        $this->aegir_protocol = config('aegir.protocol');
        $this->aegir_host = config('aegir.host');
        $this->aegir_key = config('aegir.key');
        
        $this->client = new Client([
             'base_uri' => "{$this->aegir_protocol}://{$this->aegir_host}",
        ]);

        // verifica se o aegir está atendendo requisições
        try {
            $this->client->request('GET',"/aegir/saas/site/{$this->aegir_host}.json", 
                    ['query' => ['api-key' => $this->aegir_key]]);
        } catch(\Exception $e) {
            $this->clientStatus = false;
        }
    }

    public function verificaStatus($dominio)
    {
        if($this->clientStatus) {

            $res = $client->request('GET',"/aegir/saas/site/{$dominio}.json", ['query' => ['api-key' => $this->aegir_key]]);
             var_dump($res); die();
            $body = json_decode($res->getBody());
            var_dump($body); die();
            
        } else {
            return 'Servidor Offline';
        }
    }

}
