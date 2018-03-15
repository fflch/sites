@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
@stop

@section('content')

@foreach ($sites as $site)

<a href="/sites/{{ $site->id }}/show">{{ $site->dominio }}{{ $dnszone }}</a>

<a href="/sites/{{ $site->id }}/edit">Editar</a>

<form method="POST" action="/sites/{{ $site->id }}">
{{ csrf_field() }} 
{{ method_field('delete') }}
<button type="submit">Apagar</button>
</form>
<br>

@endforeach

@stop
