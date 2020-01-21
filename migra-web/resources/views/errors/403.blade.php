@extends('adminlte::master')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('/css/abort.css') }}">
    @yield('css')
@stop

@section('body_class', 'abort-page')

@section('body')
    <div class="abort-box">
        <div class="abort-logo">
            <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}"><img src="{{asset('images/migra_logo.png')}}" width="200px"></a>
        </div>
        <!-- /.login-logo -->
        <div class="abort-box-body">
            <div class='row'>
                <div class='col-sm-3'>
                    <h1 class='text-red'>403</h1>
                </div>
                <div class='col-sm-6'>
                    <p class="abort-box-msg">@lang('auth.403')</p>
                    <p><a href="{{ url()->previous() }}" class='abort-link'>Retorna</a></p>
                </div>
            </div>
            
        </div>

    </div>
@stop