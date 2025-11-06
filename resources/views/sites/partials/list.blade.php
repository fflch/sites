
<div class="card">
  <div class="card-header"><b>Relação dos sites da FFLCH</b></div>
<div class="card-body">

Total de sites existentes: <b>{{ $sites->where('status','!=','Solicitado')->count() }}</b> <br>
Total de sites ainda não aprovados: <b>{{ $sites->where('status','Solicitado')->count() }} </b>

<br><br>
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">Site</th>
      <th scope="col">Responsável</th>
      <th scope="col">Categoria</th>
      <th scope="col">Status</th>
    </tr>
  </thead>
  <tbody>
    @foreach($sites->sortBy('categoria') as $site)
        <tr>
          <td> 
            @if($site->status == 'aprovado')
              <a target="_blank" href="http://{{$site->dominio.config('sites.dnszone')}}">
                {{$site->dominio.config('sites.dnszone')}}
              </a>
            @else
              {{$site->dominio.config('sites.dnszone')}}
            @endif
          </td>
          <td> {{ $site->responsavel->name ?? '' }} </td>
          <td>{{ $site->categoria }}</td>
          <td>{{ $site->status }}</td>
        </tr>
    @endforeach
  </tbody>
</table>

</div>