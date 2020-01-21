@extends('adminlte::page')

@section('title')
    @lang('messages.devices')
@stop

@section('content')
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">@lang('messages.devices')</h3>
        </div>
        <div class="box-body">
            <div class="col-xs-10 no-padding">
                <form role="search" action="{{route('devices.index')}}" method="GET">
                    @csrf
                    <label><input placeholder="@lang('messages.search')" type="search" name="search" class="input-sm form-control"></label>
                    <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>
                </form>
            </div>
            @can('migra_operator')
                <a href="{{route('devices.create')}}"><button type="button" class="btn btn-sm btn-primary pull-right">
                <i class="fa fa-plus"></i></button></a>
            @endcan
            <table class="table table-striped table-bordered table-condensed">
                <thead>
                    <tr>
                        <th>@sortablelink('name', __('messages.serial'))</th>
                        <th>@sortablelink('modelDevice.name', __('messages.model'))</th>
                        <th>@sortablelink('bat', __('messages.battery'))</th>
                        <th>@sortablelink('created_at', __('messages.created_at'))</th>
                        <th style="width: 8%">@lang('messages.actions')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($devices as $d)
                    <tr>
                        <td><a href="{{route('devices.show',$d)}}">{{ $d->name }}</a></td>
                        <td><a href="{{route('devices.show',$d)}}">{{ $d->modelDevice->name }}</a></td>
                        <td><a href="{{route('devices.show',$d)}}">{{ $d->bat }}</a></td>
                        <td><a href="{{route('devices.show',$d)}}">{{ $d->created_at->format('d/m/Y H:i:s') }}</a></td>
                        <td align="center"><a href="{{route('devices.show',$d)}}">
                            <button type="button" class="btn btn-xs btn-primary">
                            <i class="fa fa-edit"></i></button></a>
                            @can('migra_admin')
                                <button class='btn btn-xs btn-danger' data-toggle='modal' data-target='#modalExcludeConfirm' data-link="{{route('devices.destroy', $d)}}" data-text='{{$d->name}}'><i class="fa fa-trash"></i></button>
                            @endcan
                        </td> 
                    </tr>
                    @empty
                        <tr><td colspan="4" class='text-center bg-yellow'>@lang('messages.no_records_found')</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="box-footer">
            <div class="pull-right">
                {{$devices->appends(\Request::except('page'))->render() }}
            </div>
        </div>
    </div>
@include('includes.modal')
@stop