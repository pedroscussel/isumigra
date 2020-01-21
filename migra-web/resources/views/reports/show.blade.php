@extends('reports.create')

@section('report')

<style>@media print{a[href]:after{content:none}}</style> 
<div class="box box-primary">
    <div class="box-header">
        @can('migra')
            <div class="row">
                <div class='col-md-12'>
                    <label>@lang('messages.info_migra')</label>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <label>@lang('messages.serial'): </label> {{ $container->serial }}
                </div>
                <div class="col-md-4">
                    <label>@lang('messages.container_type'): </label>
                    @if($container->originalType->id)
                    {{ $container->originalType->name }} ({{ $container->originalType->size }})
                    @endif
                </div>
                <div class="col-md-2">
                    <label>@lang('messages.device'): </label> {{ $container->device->name }}
                </div>
                <div class="col-md-3"><label>@lang('messages.buyer'): </label> {{ $container->company->name }}</div>
            </div>
        <hr style="margin:0">
        @endcan
        <div class="row">
            <div class='col-md-12'>
                <label>@lang('messages.info')</label>
            </div>
            <div class="col-md-3">
                <label>@lang('messages.name'): </label> {{ $container->name }}
            </div>
            <div class="col-md-6">
                <label>@lang('messages.type'): </label>
                @if($container->type->id)
                {{ $container->type->name }} ({{ $container->type->size }})
                @endif
            </div>
            <div class="col-md-3"><label>@lang('messages.localization'):</label> {{ $container->companyService->name }}</div>
        </div>
    </div>
    <div class="box-body">
        @foreach ($service_orders as $s)
        <hr style="margin-top:0;margin-bottom:5px;">
        <div class="row">
            <div class='col-md-12'>
                <label>@lang('messages.service_order'): </label> <a href="{{route('service_orders.show',$s)}}">{{$s->num_service}}</a>
            </div>
            <div class='col-md-3'>
                <label>@lang('messages.hirer'): </label> <a href="{{route('companies.show',$s->company)}}">{{$s->company->name}}</a>
            </div>
            <div class='col-md-3'>
                <label>@lang('messages.from'): </label> <a href="{{route('companies.show',$s->addressSrc->companies->first())}}">{{$s->addressSrc->companies->first()->name}}</a>
            </div>
            <div class='col-md-3'>
                <label>@lang('messages.to'): </label> <a href="{{route('companies.show',$s->addressDes->companies->first())}}">{{$s->addressDes->companies->first()->name}}</a>
            </div>
            <div class='col-md-3'>
                <label>@lang('messages.time'): </label> {{$s->daysSinceCreated()}}
            </div>
        </div>
        @endforeach
    </div>
    <div class="box-footer">
        @lang('messages.created_at'): {{$now}}
    </div>
</div>    
<script>
document.getElementById('footer').innerHTML = '<button class="btn btn-sm btn-primary" onclick="print()">@lang("messages.print")</button>';
</script>
@endsection
