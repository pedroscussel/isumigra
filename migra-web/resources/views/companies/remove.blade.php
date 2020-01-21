@extends('adminlte::page')

@section('title')
    @lang('messages.remove_company')
@stop

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <p class="box-title">@lang('messages.data')</p>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12"><label>@lang('messages.name'):</label> {{ $company->name }}</div>
            </div>
            <div class="row">
                <div class="col-md-12"><label>@lang('messages.trading_name'):</label> {{ $company->trading_name }}</div>
            </div>
            <div class="row">
                <div class="col-md-12"><label>@lang('messages.cnpj'):</label> {{ $company->cnpj }}</div>
            </div>
            <div class="row">
                <div class="col-md-12"><label>@lang('messages.address'):</label> {{$company->getFullAddressAttribute()}}</div>
            </div>
        </div>
    </div>
    <form method="POST" action="{{route('companies.destroy',$company)}}">
        @csrf
        @method('DELETE')
        <div class="box">
            <div class="box-header with-border">
                <p>@lang('messages.remove_record')</p>
                <h4>@lang('messages.remove_record_warning')</h4>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-1">
                        <button class="btn btn-sm  btn-danger">@lang('messages.remove')</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop

