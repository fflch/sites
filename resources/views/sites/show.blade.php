@extends('master')

@section('title', 'Dashboard')

@section('content_header')
@stop

@section('content')
@parent

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Site</th>
                <th>Pessoas</th>
                <th>Ações</th>
            </tr>
        </thead>

        <tbody>
            @include('sites/partials/site')

        <tr>
            <td colspan="3"><b>Justificativa: </b>{!! $site->justificativa !!}</td>
        </tr>
</tbody>
</table>
</div>

@stop

