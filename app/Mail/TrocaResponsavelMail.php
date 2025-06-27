<?php

namespace App\Mail;

use App\Models\Site;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TrocaResponsavelMail extends Mailable
{
    use Queueable, SerializesModels;

    public $site;
    public $user;
    public $novo_responsavel;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($site, $novo_responsavel)
    {
        $this->site = $site;
        $this->novo_responsavel = $novo_responsavel;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "Troca do reponsável do site {$this->site->dominio}" . config('sites.dnszone');
        $user = User::where('codpes',$this->site->owner)->first();
        $novo_responsavel = User::where('codpes',$this->novo_responsavel)->first();

        $to = array();
        if ($user){
            $owner_nusp = $user->codpes;
            $owner_nome = $user->name;
            array_push($to, $user->email);
        }
        else{
            $owner_nusp = "Usuário ainda não fez login";
            $owner_nome = "Usuário ainda não fez login";
            array_push($to, config('mail.from.address'));
        }

        if($novo_responsavel){
            $novo_responsavel_nusp = $novo_responsavel->codpes;
            $novo_responsavel_nome = $novo_responsavel->name;
            array_push($to, $novo_responsavel->email);
        }
        else{
            $novo_responsavel_nusp = $this->novo_responsavel;
            $novo_responsavel_nome = "Usuário ainda não fez login";
        }

        return $this->view('emails.troca_responsavel')
                    ->to($to)
                    ->from(config('mail.from.address'))
                    ->replyTo(config('mail.reply_to.address'))
                    ->subject($subject)
                    ->with([
                        'site'                  => $this->site,
                        'name'                  => $owner_nome,
                        'nusp'                  => $owner_nusp,
                        'name_novo_responsavel' => $novo_responsavel_nome,
                        'nusp_novo_responsavel' => $novo_responsavel_nusp,
                    ]);
    }
}
