@extends('adminlte::page')

@section('title')
    @lang('messages.new_container')
@stop

@section('content')
    <div class="box box-primary">
        {!! Form::open(['route' => 'containers.store']) !!}
            @csrf
            <div class="box-header with-border">
                <h3 class="box-title">@lang('messages.new_container')</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-6 form-group">
                        @can('migra')
                            <label>@lang('messages.serial')</label>
                            <input required type="text" class="form-control" name="serial">
                        @else
                            <label>@lang('messages.name')</label>
                            <input required type="text" class="form-control" name="name">
                        @endcan
                    </div>
                    <div class="col-sm-6 form-group">
                        <label>@lang('messages.container_type')</label>
                        <div class="input-group">
                            {!!Form::select('container_type_id',
                                $container_type->pluck('name', 'id'),
                                null,
                                [
                                    'class' => 'form-control js-example-basic-single',
                                    'placeholder' => __('messages.selected')/*,
                                    'required'*/
                                ]
                            )!!}
                            <a href="{{route('container_types.create')}}" class="input-group-addon btn btn-primary">
                                @lang('messages.insert')
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 form-group">
                        @can('migra')
                            <label>@lang('messages.buyer')</label>
                            <div class="input-group">
                                {!!Form::select('company_id',
                                    $company->pluck('name', 'id'),
                                    null,
                                    [
                                        'class' => 'form-control js-example-basic-single',
                                        'placeholder' => __('messages.selected')/*,
                                        'required'*/
                                    ]
                                )!!}
                                <a href="{{route('companies.create')}}" class="input-group-addon btn btn-primary">
                                    @lang('messages.new_company')
                                </a>
                            </div>
                        @else
                            <input type="hidden" value="{{Auth::user()->company_id}}" name="company_id" >
                        @endcan
                    </div>
                    <div class="col-sm-6 form-group">
                        @can('migra')
                            <label>@lang('messages.device')</label>
                            <div class="input-group">
                                {!!Form::select('device_id',
                                    $device->pluck('name', 'id'),
                                    null,
                                    [
                                        'class' => 'form-control js-example-basic-single',
                                        'placeholder' => __('messages.selected')/*,
                                        'required'*/
                                    ]
                                )!!}
                                <a href="{{route('devices.create')}}" class="input-group-addon btn btn-primary">
                                    @lang('messages.new_device')
                                </a>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-sm btn-primary">@lang('messages.save')</button>
            </div>
        {{ Form::close() }}
    </div>
@stop
