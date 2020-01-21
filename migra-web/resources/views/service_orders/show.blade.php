@extends('adminlte::page')

@section('title')
    @lang('messages.service_order')
@stop

@section('content')
@if($service_order) <!-- so pro phpunit -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <p class="box-title">@lang('messages.data')</p>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12"><label>@lang('messages.service_order_number'):</label> {{ $service_order->num_service }}</div>
            </div>
            <div class="row">
                <div class="col-md-6"><label>@lang('messages.created_by'):</label> {{ $service_order->user->name }}
                    @can('migra')
                        / <label>@lang('messages.company'):</label> {{ $service_order->owner->name }}
                    @endcan
                </div>
                <div class="col-md-6"><label>@lang('messages.hirer'):</label> {{ $service_order->company->name}}</div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label>@lang('messages.container'):</label>
                    @if($service_order->container_id)
                        {{ $service_order->container->name }}
                    @endif
                </div>
                <div class="col-md-6">
                    <label>@lang('messages.container_type'):</label>
                    @if($service_order->container_type_id)
                        {{ $service_order->containerType->name }}
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-md-6"><label>@lang('messages.origin_location'): </label>
                    {{ $service_order->addressSrc->companies->first()->name }}
                </div>
                <div class="col-md-6"><label>@lang('messages.destination_location'): </label>
                    {{ $service_order->addressDes->companies->first()->name }}
                </div>
            </div>
            <div class="row">
                <div class="col-md-6"><label>@lang('messages.origin_address'): </label>
                    {{ $service_order->addressSrc->getFullAddressAttribute() }}
                </div>
                <div class="col-md-6"><label>@lang('messages.destination_address'): </label>
                    {{ $service_order->addressDes->getFullAddressAttribute() }}
                </div>
            </div>
            <div class="row">
                <div class="col-md-6"><label>@lang('messages.material_declared'):</label> {{ $service_order->material->name }}</div>
                <div class="col-md-6"><label>@lang('messages.material_received'):</label> {{ $service_order->material_real }}</div>
            </div>
            <div class="row">
                <div class="col-md-6"><label>@lang('messages.quantity_declared'):</label> {{ $service_order->quantity }}</div>
                <div class="col-md-6"><label>@lang('messages.quantity_received'):</label> {{ $service_order->quantity_real }}</div>
            </div>
            <div class="row">
                <div class="col-md-12"><label>@lang('messages.truck'):</label> {{ $service_order->truck->license_plate}}</div>
            </div>
        </div>
        <div class="box-footer">
            @if (Gate::allows('operator'))
                <div class="row">
                    <div class="col-sm-1">
                        <a href="{{route('service_orders.edit', $service_order)}}">
                        <button type="button" class="btn btn-sm btn-primary">@lang('messages.edit')</button></a>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            {!! $map['js'] !!}
            {!! $map['html'] !!}
        </div>
    </div>
@endif
@stop

