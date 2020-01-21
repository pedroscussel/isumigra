@extends('adminlte::page')

@section('title')
    @lang('messages.company')
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
        <div class="box-footer">
            <div class="row">
                @can('operator')
                    <div class="col-sm-1">
                        <a href="{{route('companies.edit',$company)}}">
                        <button type="button" class="btn btn-sm btn-block btn-primary">@lang('messages.edit')</button></a>
                    </div>
                @endcan
                @can('admin')
                    <div class="col-sm-1">
                        <a href="{{route('companies.remove',$company)}}">
                        <button type="button" class="btn btn-sm btn-block btn-danger">@lang('messages.remove')</button></a>
                    </div>
                @endcan
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{$company->containers->count()}}</h3>
                    <p>@lang('messages.containers')</p>
                </div>
                <div class="icon">
                    <i class="fa fa-cube"></i>
                </div>
                <div class="small-box-footer"></div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{$company->countFullContainers()}}</h3>
                    <p>@lang('messages.full_plural')</p>
                </div>
                <div class="icon">
                    <i class="fa fa-exclamation"></i>
                </div>
                <div class="small-box-footer"></div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="small-box bg-orange">
                <div class="inner">
                    <h3>{{$company->countHalfFullContainers()}}</h3>
                    <p>@lang('messages.filling')</p>
                </div>
                <div class="icon">
                    <i class="fa fa-minus"></i>
                </div>
                <div class="small-box-footer"></div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{$company->countEmptyContainers()}}</h3>
                    <p>@lang('messages.empty_plural')</p>
                </div>
                <div class="icon">
                    <i class="fa fa-check"></i>
                </div>
                <div class="small-box-footer"></div>
            </div>
        </div>
    </div>




@stop

