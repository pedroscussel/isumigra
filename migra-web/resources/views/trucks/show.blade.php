@extends('adminlte::page')

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <p class="box-title">@lang('messages.truck') @lang('messages.license_plate') {{$truck->license_plate}}</p>
        </div>
        <div class="box-body">
             @include('trucks._show')
        </div>
        <div class="box-footer">
            @if (Gate::allows('operator'))
                <div class="row">
                    <div class="col-sm-1">
                        <a href="{{route('trucks.edit',$truck->id,'edit')}}">
                        <button class="btn btn-sm btn-block btn-primary">@lang('messages.edit')</button></a>
                    </div>

                    <div class="col-sm-1">
                        <a href="{{route('trucks.remove',$truck->id,'remove')}}">
                        <button class="btn btn-sm btn-block btn-danger">@lang('messages.remove')</button></a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@stop

