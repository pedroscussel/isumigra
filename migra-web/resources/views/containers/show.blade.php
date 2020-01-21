@extends('adminlte::page')

@section('title')
    @lang('messages.container')
@stop

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <p class="box-title">@lang('messages.data')</p>
        </div>
        <div class="box-body">

            @can('migra')
            <div class="row">
                <div class='col-md-12'>
                    <h4 class='box-title'>Informações Migra</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label>@lang('messages.serial'):</label> {{ $container->serial }}
                </div>
                <div class="col-md-6">
                    <label>@lang('messages.original_container_type'):</label>

                    @if($container->originalType->id)
                    <a href='{{route('container_types.show', $container->originalType->id)}}'>{{ $container->originalType->name }}</a> ({{ $container->originalType->size }})
                    @endif

                </div>
            </div>
            <div class="row">
                <div class="col-md-12"><label>@lang('messages.buyer'):</label> <a href="{{route('companies.show',$container->company)}}">{{ $container->company->name }}</a></div>
            </div>

            <div class="row">
                <div class="col-md-12"><label>@lang('messages.device'):</label> <a href="{{route('devices.show',$container->device)}}">{{ $container->device->name }}</a></div>
            </div>
            <hr>
            @endcan

            <div class="row">
                <div class="col-md-6">
                    <label>@lang('messages.name'):</label> {{ $container->name }}
                </div>
                <div class="col-md-6">
                    <label>@lang('messages.type'):</label>
                    @if($container->type->id)
                    <a href='{{route('container_types.show', $container->type->id)}}'>{{ $container->type->name }}</a> ({{ $container->type->size }})
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-md-12"><label>@lang('messages.localization'):</label> <a href="{{route('companies.show',$container->companyService)}}">{{ $container->companyService->name }}</a></div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label>@lang('messages.active_service_order'):</label><a href="{{route('service_orders.show',$container->activeServiceOrder)}}"> {{ $container->activeServiceOrder->number }}</a></div>
            </div>
            <div class="row">
                <div class="col-md-12"><label>@lang('messages.number_of', ['class' => __('messages.service_orders')]):</label> {{ $container->serviceOrder->count() }}</div>
            </div>
            <div class="row">
                <div class="col-md-12"><label>@lang('messages.documents'):</label>

                    @foreach ($container->type->documents as $d)
                        <p><a href="{{route('container_types.download',$d)}}">
                        <i class="fa fa-file"></i> {{ $d->name }} </a></p>
                    @endforeach
                </div>
            </div>
            @can('migra')
                <div class="row">
                    <div class="col-md-12"><label>@lang('messages.documents') MIGRA:</label>
                        @foreach ($container->originalType->documents as $d)
                            <p><a href="{{route('container_types.download',$d)}}">
                            <i class="fa fa-file"></i> {{ $d->name }}</a></p>
                        @endforeach
                    </div>
                </div>
            @endcan
        </div>
        <div class="box-footer">
            @can('operator')
                <div class="row">
                    <div class="col-md-6">
                        <a href="{{route('containers.edit',$container)}}">
                        <button type="button" class="btn btn-primary">@lang('messages.edit')</button></a>
                        <a href="{{route('containers.remove',$container)}}">
                        <button type="button" class="btn btn-danger">@lang('messages.remove')</button></a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{route('reports.create',$container)}}">
                        <button type="button" class="btn btn-primary pull-right">@lang('messages.create_reports')</button></a>
                    </div>
                </div>
            @endcan
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{$container->serviceOrder->count()}}</h3>
                    <p>@lang('messages.number_of', ['class' => __('messages.service_orders')])</p>
                </div>
                <div class="icon">
                    <i class="fa fa-cube"></i>
                </div>
                <div class="small-box-footer"></div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="small-box bg-{{$container->device->color}}">
                <div class="inner">
                    <h3>{{$container->device->volume * 100}} %</h3>
                    <p>@lang('messages.volume')</p>
                </div>
                <div class="icon">
                    <i class="fa fa-tachometer"></i>
                </div>
                <div class="small-box-footer"></div>
            </div>
        </div>
    </div>
@stop
