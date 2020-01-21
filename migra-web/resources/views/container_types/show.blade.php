@extends('adminlte::page')

@section('title')
    @lang('messages.service_order')
@stop

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <p class="box-title">@lang('messages.data')</p>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12"><label>@lang('messages.type'):</label> {{ $container_type->name }}</div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label>@lang('messages.description'):</label>
                    <p>{{ $container_type->description }}</p>
                </div>
            </div>
            <div class="row">
                    <div class="col-sm-3">
                        <label for='width'>@lang('messages.width')</label>
                        <div class='input-group'>
                            <span class='input-group-text text-right'>{{$container_type->width}}</span>
                            <span class='input-group-addon'>@lang('messages.meters')</span>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <label for='length'>@lang('messages.length')</label>
                        <div class='input-group'>
                            <span class='input-group-text text-right'>{{$container_type->length}}</span>
                            <span class='input-group-addon'>@lang('messages.meters')</span>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <label for='height'>@lang('messages.height')</label>
                        <div class='input-group'>
                            <span class='input-group-text text-right'>{{$container_type->height}}</span>
                            <span class='input-group-addon'>@lang('messages.meters')</span>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <label for='traceable'>
                            @lang('messages.traceable')
                        </label><br>
                        <input type="checkbox" class='form-check' onclick="return false;"
                            name="traceable" id="traceable" value="1" {{$container_type->traceable?"checked":""}}>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <label for='bulk'>@lang('messages.bulk')</label>
                        <div class='input-group'>
                            <span class='input-group-text text-right'>{{$container_type->bulk}}</span>
                            <span class='input-group-addon'>@lang('messages.cubic_meter')</span>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <label for='weight'>@lang('messages.weight')</label>
                        <div class='input-group'>
                            <span class='input-group-text text-right'>{{$container_type->weight}}</span>
                            <span class='input-group-addon'>kg</span>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <label for='carrying_capacity'>@lang('messages.capacity')</label>
                        <div class='input-group'>
                            <span class='input-group-text text-right'>{{$container_type->carrying_capacity}}</span>
                            <span class='input-group-addon'>t</span>
                        </div>
                    </div>
                </div>

        </div>
        <div class="box-footer">
            @if(Gate::allows('operator'))
                <div class="row">
                    <div class="col-sm-1">
                        <a href="{{route('container_types.edit',$container_type->id,'edit')}}">
                        <button type="button" class="btn btn-sm btn-block btn-primary">@lang('messages.edit')</button></a>
                    </div>
                    <div class="col-sm-1">
                        <a href="{{route('container_types.remove',$container_type->id,'remove')}}">
                        <button type="button" class="btn btn-sm btn-block btn-danger">@lang('messages.remove')</button></a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@include('container_types.documents')
@include('container_types.modal_add_document')
@include('includes.modal')
@stop
