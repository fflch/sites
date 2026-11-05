<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class SiteCrudTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function test_site_crud(): void
    {
        \App\Models\Site::truncate();

        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->clickLink('Entrar')
                ->waitFor('#loginUsuario') # Importante: Espera a página de login carregar
                ->typeSlowly('loginUsuario', '1111')
                ->press('Login')
                ->waitFor('.login_logout_link') # Importante: Espera a página de retornada carregar
                ->assertSee('SOLICITAR SITE')
                ->clickLink('Solicitar site')
                ->typeSlowly('dominio', 'siteteste')
                ->typeSlowly('justificativa', 'justificativa')
                ->select('categoria', 'Laboratório')
                ->press('Enviar')
                ->pause(2000)
                ->assertSee('siteteste.local.fflch.usp.br');

            $site_id = \App\Models\Site::select('id')->latest()->first();

            $browser->click("a[href='/sites/{$site_id->id}/edit']")
                ->typeSlowly('justificativa', 'justificativa alterada.')
                ->press('Enviar')
                ->assertSee('justificativa alterada.');

            $browser->click("button[data-delete='{$site_id->id}']")
                ->pause(2000)
                ->acceptDialog()
                ->pause(2000)
                ->assertDontSee('siteteste.local.fflch.usp.br');
        });
    }
}
