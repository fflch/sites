<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AvisoCrudTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function test_aviso_crud(): void
    {
        \App\Models\Aviso::truncate();

        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->clickLink('Entrar')
                ->waitFor('#loginUsuario') # Importante: Espera a página de login carregar
                ->typeSlowly('loginUsuario', '1111')
                ->press('Login')
                ->waitFor('.login_logout_link'); # Importante: Espera a página de retornada carregar;
            
            $browser->clickLink('Avisos')
                ->click("a[href='/avisos/create']")
                ->assertSee('Cadastro de Avisos')
                ->typeSlowly('titulo', 'aviso teste')
                ->typeSlowly('corpo', 'mensagem')
                ->typeSlowly('divulgacao_home_ate', '20/01/2040')
                ->press('Salvar')
                ->assertSee('aviso teste');
            
            $aviso_id = \App\Models\Aviso::select('id')->latest()->first();

            $browser->click("a[href='/avisos/{$aviso_id->id}/edit']")
                ->assertSee('Edição de Aviso')
                ->typeSlowly('corpo', 'mensagem alterada.')
                ->press('Salvar')
                ->assertSee('mensagem alterada.')
                ->pause(4000)
                ->clickLink('Voltar')
                ->assertSee('Avisos');
            
            $browser->click("form[action='/avisos/{$aviso_id->id}'] button")
                ->assertSee('Avisos');
        });
    }
}
