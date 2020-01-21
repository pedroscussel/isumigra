@extends('adminlte::page')

@section('title')
    @lang('messages.remove_container')
@stop

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <p class="box-title">@lang('messages.data')</p>
        </div>
        <div class="box-body">
            @can('migra')
                <div class="row">
                    <div class="col-md-12"><label>@lang('messages.serial'):</label> {{ $container->serial }}</div>
                </div>
                <div class="row">
                    <div class="col-md-12"><label>@lang('messages.original_container_type'):</label> {{ $container->originalType->name }}</div>
                </div>
                <div class="row">
                    <div class="col-md-12"><label>@lang('messages.buyer'):</label> <a href="{{route('companies.show',$container->company)}}">{{ $container->company->name }}</a></div>
                </div>
                <div class="row">
                    <div class="col-md-12"><label>@lang('messages.localization'):</label> <a href="{{route('companies.show',$container->companyService)}}">{{ $container->companyService->name }}</a></div>
                </div>
                <div class="row">
                    <div class="col-md-12"><label>@lang('messages.device'):</label> <a href="{{route('devices.show',$container->device)}}">{{ $container->device->name }}</a></div>
                </div>
            @endcan
            <div class="row">
                <div class="col-md-12"><label>@lang('messages.name'):</label> {{ $container->name }}</div>
            </div>
            <div class="row">
                <div class="col-md-12"><label>@lang('messages.type'):</label> {{ $container->type->name }}</div>
            </div>
            <div class="row">
                <div class="col-md-12"><label>@lang('messages.active_service_order'):</label><a href="{{route('service_orders.show',$container->activeServiceOrder)}}"> {{ $container->activeServiceOrder->number }}</a></div>
            </div>
            <div class="row">
                <div class="col-md-12"><label>@lang('messages.number_of', ['class' => __('messages.service_orders')]):</label> {{ $container->serviceOrder->count() }}</div>
            </div>
            <div class="row">
                <div class="col-md-12"><label>@lang('messages.documents'):</label> 
                    @can('migra')
                        @foreach ($container->type->documents as $d)
                            <p><a href="{{route('container_types.download',$d)}}">
                            <i class="fa fa-file"></i> {{ $d->name }}</p>
                        @endforeach
                    @endcan
                    @foreach ($container->originalType->documents as $d)
                        <p><a href="{{route('container_types.download',$d)}}">
                        <i class="fa fa-file"></i> {{ $d->name }}</p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <form method="POST" action="{{route('containers.destroy',$container)}}">
        @csrf
        @method('DELETE')
        <div class="box">
            <div class="box-header with-border">
                <p>@lang('messages.remove_record')</p>
                <h4>@lang('messages.remove_record_warning')</h4>
            </div>
            <div class="box-body">
                <button class="btn btn-danger">@lang('messages.remove')</button>
            </div>
        </div>
    </form>
@stop

