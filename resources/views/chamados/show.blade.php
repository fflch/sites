@extends('master')

@section('title', 'Dashboard')

@section('content_header')
@stop

@section('javascripts_bottom')
@parent
<script>CKEDITOR.replace( 'comentario' );</script>
@stop

@section('content')
@parent

    <div class="card bg-light mb-3">
      <div class="card-header">{{ $chamado->user->name }} - {{ Carbon\Carbon::parse($chamado->created_at)->format('d/m/Y H:i') }}</div>
      <div class="card-body">
        <b>id</b>: {{ $chamado->id }}<br>

        <b>site</b>: {{ $chamado->site->dominio.config('sites.dnszone') }} <br>
        <b>status</b>: {{ $chamado->status }}<br>
        <b>tipo</b>: {{ $chamado->tipo }} <br>
        <p class="card-text">{!! $chamado->descricao !!}</p>
        @if(!is_null($chamado->fechado_em))
        <div><b>Fechado em</b>: {{ Carbon\Carbon::parse($chamado->fechado_em)->format('d/m/Y H:i') }}</div>
        @endif
      </div>
    </div>

@forelse ($chamado->comentarios->sortBy('created_at') as $comentario)

    <div class="card bg-light mb-3">
      <div class="card-header">{{ $comentario->user->name }} - {{ Carbon\Carbon::parse($comentario->created_at)->format('d/m/Y H:i') }}</div>
      <div class="card-body">
        <p class="card-text">{!! $comentario->comentario !!}</p>
      </div>
    </div>

@empty
    Não há comentários
@endforelse

  <div class="form-group">
    @include('chamados.partials.files')
  </div>

  <div class="form-group">
  <br>
  <b>Arquivos carregados:</b><br>
  @forelse ($chamado->files_chamado as $file_chamado)
      <a href="/files_chamados/{{ $file_chamado->id }}"><img width="150px" src="/files_chamados/{{ $file_chamado->id }}"></a>
  @empty
    Não há arquivos carregados
  @endforelse
  </div>

  <form method="POST" role="form" action="{{ route('comentarios.store', [$chamado->id]) }}">
      @csrf

      <div class="form-group">
        <label for="comentario"><b>Novo comentário:</b></label>
        <textarea class="form-control" id="comentario" name="comentario" rows="7"></textarea>
      </div>

      @if($chamado->status == 'aberto')
      <div class="form-group">
        <button type="submit" class="btn btn-primary" value="">Enviar</button>
      </div>

        <div class="form-group">
          <button type="submit" class="btn btn-danger" name="status" value="fechar">Enviar e fechar chamado</button>
      </div>
      @else
        <div class="form-group">
          <button type="submit" class="btn btn-danger" name="status" value="abrir">Enviar e reabrir chamado</button>
      </div>
      @endif
  </form>

@stop

