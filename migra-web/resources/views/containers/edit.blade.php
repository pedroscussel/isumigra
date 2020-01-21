@extends('adminlte::page')

@section('title')
    @lang('messages.edit_container')
@stop

@section('content')
    <div class="box box-primary">
        {!! Form::model($container, ['route' => ['containers.update', $container]]) !!}
            {{ method_field('PATCH') }}
            @csrf
            <div class="box-header with-border">
                <h3 class="box-title">@lang('messages.edit_container')</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-6 form-group">
                        @can('migra')
                            <label>@lang('messages.serial')</label>
                            <input required type="text" class="form-control" name="serial" value="{{$container->serial}}">
                        @else
                            <label>@lang('messages.name')</label>
                            <input required type="text" class="form-control" name="name" value="{{$container->name}}">
                        @endcan
                    </div>
                    <div class="col-sm-6 form-group">
                        <label>@lang('messages.container_type')</label>    
                        <div class="input-group">
                            {!!Form::select('container_type_id', $container_type->pluck('name', 'id'), $container->container_type_id, ['class' => 'form-control js-example-basic-single'])!!}  
                            <a href="{{route('container_types.create')}}" class="input-group-addon btn btn-primary">@lang('messages.insert')</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 form-group">
                        @can('migra')
                            <label>@lang('messages.buyer')</label>
                            <div class="input-group">
                                {!!Form::select('company_id', $company->pluck('name', 'id'), $container->company_id, ['class' => 'form-control js-example-basic-single'])!!}  
                                <a href="{{route('companies.create')}}" class="input-group-addon btn btn-primary">@lang('messages.new_company')</a>
                            </div>
                        @endcan                       
                    </div>
                    <div class="col-sm-6 form-group">
                        @can('migra')
                            <label>@lang('messages.device')</label>
                            <div class="input-group">
                                {!!Form::select('device_id', $device->pluck('name', 'id'), $container->device_id, ['class' => 'form-control js-example-basic-single'])!!}  
                                <a href="{{route('devices.create')}}" class="input-group-addon btn btn-primary">@lang('messages.new_device')</a>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">@lang('messages.save')</button>
            </div>
        {!! Form::close() !!}
    </div>
@stop
