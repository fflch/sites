@extends('master')

@section('title', 'Dashboard')

@section('content_header')
@stop

@section('content')
@parent
<form method="POST" role="form" class="form-inline" action="/sites/{{ $site->id }}">
{{ csrf_field() }}
{{ method_field('patch') }}

        <div class="form-group">
            <label>DNS do site (opcional):</label>
            <input name="dns" class="form-control" value="{{ old('dns', $site->dns ?? '') }}" placeholder="{{ config('sites.dns') }}">
            <small class="form-text text-muted">Deixe em branco para usar o valor padrão do sistema: {{ config('sites.dns') }}</small>
        </div>
            <button type="submit" class="btn btn-primary"> Enviar </button>
</form>

@stop
