@extends('adminlte::page')

@section('title')
    @lang('messages.new_device')
@stop

@section('content')
    {!! Form::open(['route' => 'devices.store']) !!}
        @csrf
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">@lang('messages.new_device')</h3>
            </div>
            <div class="box-body">
                <div class="col-sm-6 form-group">
                    <label for='model_device_id'>@lang('messages.model')</label>
                    {!!Form::select('model_device_id',
                        \App\ModelDevice::all()->pluck('name','id'),null,
                        ['class'=>'form-control js-example-basic-single', 'placeholder'=>__('messages.selected')])!!}
                </div>
                <div class="col-sm-6 form-group">
                    <label for='model_device_id'>@lang('messages.container')</label>
                    {!!Form::select('container_id',
                        $containers->pluck('name','id'),
                        null,
                        ['class'=>'form-control js-example-basic-single', 'placeholder'=>__('messages.selected')]
                        )!!}
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-sm btn-primary">@lang('messages.save')</button>
            </div>
        </div>
    {!! Form::close() !!}
@stop
