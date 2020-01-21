@extends('adminlte::page')

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <p class="box-title">@lang('messages.data')</p>
        </div>
        
        <div class="box-body">

            @include('trucks._show')
        </div>  

    </div>
    {!!Form::open(['route' => ['trucks.destroy',$truck->id] , 'method' => 'DELETE'])!!}

    <div class="box">
        <div class="box-header with-border">
            <p>@lang('messages.remove_record')</p>
            <h4>@lang('messages.remove_record_warning')</h4>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-sm-3">
                    <button class="btn btn-sm btn-danger">@lang('messages.remove')</button>
                </div>
            </div>
        </div>
    </div>
    {!!Form::close()!!}
@stop

