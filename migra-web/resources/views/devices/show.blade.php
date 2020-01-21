@extends('adminlte::page')

@section('title')
    @lang('messages.device')
@stop

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <p class="box-title">@lang('messages.device')</p>
        </div>
        <div class="box-body">
            @include('devices._show')
        </div>
        <div class="box-footer">
            @can('migra_operator')
                <div class="row">
                    <div class="col-sm-1">
                        <a href="{{route('devices.edit',$device,'edit')}}">
                        <button type="button" class="btn btn-sm btn-block btn-primary">@lang('messages.edit')</button></a>
                    </div>
                    <div class="col-sm-1">
                        <a href="{{route('devices.remove',$device,'remove')}}">
                        <button type="button" class="btn btn-sm btn-block btn-danger">@lang('messages.remove')</button></a>
                    </div>   
                    <div class='col-md-10 text-right'>
                        <span class=''>
                            <i >{{__('messages.created_and_update',
                                        ['c_at'=>$device->created_at->format('d/m/Y H:i'),
                                        'u_at'=>$device->updated_at->format('d/m/Y H:i')]
                                    )}} </i>
                        </span>
                    </div>
                </div>
            @endcan
        </div>
    </div>
    
@stop