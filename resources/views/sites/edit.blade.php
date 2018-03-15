@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
@stop

@section('content')

<form method="POST" action="/sites/{{ $site->id  }}">
{{ csrf_field() }}
{{ method_field('patch') }}
Domínio: <input name="dominio" value="{{ $site->dominio }}">{{ $dnszone }}<br>
<button type="submit"> Salvar </button>
</form>


@stop
