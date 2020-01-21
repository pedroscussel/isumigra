@extends('adminlte::page')

@section('title')
    @lang('messages.security_test')
@stop

@section('content')









@php
////////////VARIAVEL
$serial = '0000000001';
///////////////////////////////////////////
$db = DB::connection('mongodb')->collection('mqtt')->get();
$value = $db->where($serial)->last();
if ($value) {
    $timestamp = $value["_id"]->getTimestamp();
    date_default_timezone_set("America/Sao_Paulo");
    $data = date("d/m/Y G:i:s T", $timestamp);
} else {
    $data = null;
}
dd($data, $value[$serial]);


/*
//se o json for com aspas simples dentro e sem escape
$esc = str_replace("'", "\"", $value["msg"]);
$js = json_decode($esc);
dd($value["msg"], $esc, $js);
*/

@endphp








<div class="box box-primary">
    <div class="box-header">
        @auth
        <h1>{{Auth::user()->name}}</h1>
        <h5><b>email: </b>{{Auth::user()->email}}</h5>
        <h5><b>empresa: </b>{{Auth::user()->company->name}}</h5>
        @endauth

        @guest
        <h1>Não autenticado</h1>
        @endguest
    </div>
    <div class="box-body">
        <h4>Testes</h4>
        <ul>
            <li><b>migra: </b>@can('migra') sim @else não @endcan </li>
            <li><b>root: </b>@can('root') sim @else não @endcan </li>

            <li><b>nivel:</b>@can('admin') admin @endcan
                @can('operator') operator @endcan
                @can('manager') manager @endcan
                @can('business') business @endcan
                @can('generator') generator @endcan </li>

            <li><b>outros:</b>@can('migra_manager') migra_manager @endcan
                @can('migra_business') migra_business @endcan
                @can('migra_operator') migra_operator @endcan
                @can('client') client @endcan
                @can('users') users @endcan </li>
        </ul>

    </div>
</div>
@stop

