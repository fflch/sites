<tr>
<td>
  <a href="/sites/{{ $site->id }}">{{ $site->dominio }}{{ config('sites.dnszone') }}</a> 
  <a href="/sites/{{ $site->id }}/edit"> <i class="fas fa-edit"></i> </a> <br>
  <b>categoria: </b>{{ $site->categoria }}<br>
  <b>status: </b>
    @if ($site->status == 'Solicitado') 
        Aguardando aprovação 
    @else 
        {{ $site->status }}
    @endif
  <br>
  <b>chamados: </b> <a href="/chamados/{{ $site->id }}"> {{ $site->chamados->where('status','aberto')->count() }} abertos</a> <!--a href="/chamados/{{ $site->id }}/create"> <i class="fas fa-plus"></i> </a--><br>
</td>

<td>
  <b>Responsável:</b> {{ $site->owner }} - {{ \Uspdev\Replicado\Pessoa::dump($site->owner)['nompes'] }} - {{ \Uspdev\Replicado\Pessoa::email($site->owner) }}

  <br><br>
  <ul class="list-group">
    @if(!empty($site->numeros_usp)) <li class="list-group-item"> <b>Administradores:</b> </li> @endif
    @foreach(explode(',', $site->numeros_usp) as $numero_usp)
      @if(!empty($numero_usp))
          <li class="list-group-item">
               @can('sites.update',$site)
                    <form method="POST" action="/sites/{{ $site->id }}" style="display:inline">
                    @csrf
                    @method('patch')
                    <input type="hidden" name="deleteadmin" value="{{ $numero_usp }}">
                    <button type="submit" class="delete-item btn"><i class="fas fa-trash-alt"></i></button>
                    </form>
               @endcan
               
@if(\App\Models\User::where('codpes',$numero_usp)->first())
{{ $numero_usp }} - {{ \App\Models\User::where('codpes',$numero_usp)->first()->name }} - {{ \App\Models\User::where('codpes',$numero_usp)->first()->email }}
@else
{{ $numero_usp }} - <b>Usuário ainda não fez login</b>
@endif

          </li>
      @endif
    @endforeach
  </ul>
</td>

<td>
    <ul class="list-group">
        @if(config('app.env') == 'production')
          @php($port = '')
        @else
          @php($port = ':8088')
        @endif
        @if($site->status != "Solicitado" && $site->status != "Aprovado - Em Processamento")
          <li class="list-group-item">
            <a href="http://{{ $site->dominio }}{{ config('sites.dnszone') }}{{$port}}/loginbytoken/?temp_token={{$hashlogin}}&codpes={{ Auth::user()->codpes }}" class="" target="_blank">
              Logon <i class="fas fa-sign-in-alt"></i>
            </a></li>
        @endif

        @can('sites.update',$site)
           <li class="list-group-item"><a href="/sites/{{ $site->id }}/novoadmin">Adicionar administrador <i class="fas fa-user-plus"></i></a></li>
        @endcan

        @can('sites.update',$site)
            <li class="list-group-item"><a href="/sites/{{ $site->id }}/changeowner" class="">Mudar responsável </a></li>
        @endcan

        @can('admin')
            
            @if($site->status == 'Solicitado')
                <li class="list-group-item">
                    <form method="POST" action="/sites/{{ $site->id }}">
                    @csrf
                    @method('patch')
                    <input type="hidden" name="aprovar" value="aprovar">
                    <button type="submit" class="btn btn-success">Aprovar <i class="fas fa-thumbs-up"></i></button>
                    </form>
                </li>
                <li class="list-group-item">
                    <form method="POST" action="/sites/{{ $site->id }}">
                    @csrf
                    @method('delete')
                    <button type="submit" class="delete-item btn btn-danger">Deletar <i class="fas fa-trash-alt"></i></button>
                    </form>
                </li>          
            @endif

            @if ($site->status == "Aprovado - Habilitado")
              <li class="list-group-item">
              <form method="POST" action="/sites/{{ $site->id }}/disable">
              @csrf
              <button type="submit" class="btn btn-info">Desabilitar</button>
              </form>
              </li>
            @elseif ($site->status == "Aprovado - Desabilitado")
              <li class="list-group-item">
              <form method="POST" action="/sites/{{ $site->id }}/enable">
              @csrf
              <button type="submit" class="btn btn-success">Habilitar</button>
              </form>
              </li>
              <li class="list-group-item">
                <form method="POST" action="/sites/{{ $site->id }}">
                @csrf
                @method('delete')
                <button type="submit" class="delete-item btn btn-danger">Deletar <i class="fas fa-trash-alt"></i></button>
                </form>
              </li>
            @elseif ($site->status == "Aprovado - Em Processamento") 
            <li class="list-group-item">
                    <form method="POST" action="/sites/{{ $site->id }}">
                    @csrf
                    @method('patch')
                    <input type="hidden" name="voltar_solicitacao" value="voltar_solicitacao">
                    <button type="submit" class="btn btn-secondary">Voltar Solicitação</button>
                    </form>
                </li>
            @endif
        @endcan
</form>
    </ul>
</td>
</tr>
