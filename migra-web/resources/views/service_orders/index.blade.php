@extends('adminlte::page')

@section('title')
    @lang('messages.service_orders')
@stop

@section('content')
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">@lang('messages.service_orders')</h3>
        </div>
        <div class="box-body">
            <div class="col-xs-10 no-padding">
                <form role="search" action="{{route('service_orders.index')}}" method="GET">
                    @csrf
                    <label><input placeholder="@lang('messages.search')" type="search" name="search" class="input-sm form-control" ></label>
                    <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>
                </form>
            </div>
            @if(Gate::allows('operator'))
                <a href="{{route('service_orders.create')}}"><button type="button" class="btn btn-sm btn-primary pull-right">
                <i class="fa fa-plus"></i></button></a>
            @endif
            <table class="table table-striped table-bordered table-condensed">
                <thead>
                    <tr>
                        <th style="width: 25%">@sortablelink('num_service', __('messages.number'))</th>
                        @if(Gate::allows('migra'))<th>@sortablelink('owner.name', __('messages.company'))</th>@endif
                        <th>@sortablelink('company.name', __('messages.hirer'))</th>
                        <th style="width: 8%">@lang('messages.actions')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($service_orders as $s)
                        <tr>
                            <td><a href="{{route('service_orders.show',$s)}}">{{ $s->num_service }}</a></td>
                            <td><a href="{{route('service_orders.show',$s)}}">{{ $s->owner->trading_name }}</a></td>
                            @if(Gate::allows('migra'))<td><a href="{{route('service_orders.show',$s)}}">{{ $s->company->trading_name }}</a></td> @endif
                            <td align="center"><a href="{{route('service_orders.show',$s)}}">
                                <button type="button" class="btn btn-primary btn-xs">
                                <i class="fa fa-edit"></i></button></a>
                            </td>
                        </tr>
                    @empty
                        @can('migra')
                        <tr><td colspan="3" class='text-center bg-yellow'>@lang('messages.no_records_found')</td></tr>
                        @else
                        <tr><td colspan="3" class='text-center bg-yellow'>@lang('messages.no_records_found')</td></tr>
                        @endcan
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="pull-right">
            {{$service_orders->appends(\Request::except('page'))->render() }}
        </div>
    </div>
@stop
