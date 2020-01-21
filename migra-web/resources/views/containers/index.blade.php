@extends('adminlte::page')

@section('title')
    @lang('messages.containers')
@stop

@section('content')
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">@lang('messages.containers')</h3>
        </div>
        <div class="box-body">
            <div class="col-xs-10 no-padding">
                <form role="search" action="{{route('containers.index')}}" method="GET">
                    @csrf
                    <label><input placeholder="@lang('messages.search')" type="search" name="search" class="input-sm form-control"></label>
                    <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>
                </form>
            </div>
            @can('operator')
                <a href="{{route('containers.create')}}"><button type="button" class="btn btn-sm btn-primary pull-right">
                <i class="fa fa-plus"></i></button></a>
            @endcan
            <table class="table table-striped table-bordered table-condensed">
                <thead>
                    <tr>
                        @can('migra')
                            <th>@sortablelink('serial', __('messages.serial'))</th>
                            <th>@sortablelink('company.name', __('messages.company'))</th>
                        @endcan
                        <th>@sortablelink('name', __('messages.name'))</th>
                        <th>@lang('messages.type')</th>
                        <th style="width: 8%">@lang('messages.actions')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($containers as $c)
                        <tr>
                            @can('migra')
                                <td><a href="{{route('containers.show',$c)}}">{{ $c->serial }}</a></td>
                                <td><a href="{{route('containers.show',$c)}}">{{ $c->company->name }}</a></td>
                            @endcan
                            <td><a href="{{route('containers.show',$c)}}">{{ $c->name }}</a></td>
                            @can('migra')
                                <td><a href="{{route('containers.show',$c)}}">{{ $c->originalType->name }}</a></td>
                            @else
                                <td>@if($c->type){{ $c->type->name }}@endcan</td>
                            @endcan
                            <td align="center"><a href="{{route('containers.show',$c)}}">
                                <button   type="button" class="btn btn-primary btn-xs">
                                <i class="fa fa-edit"></i></button></a>
                                @can('operator')
                                    <button class='btn btn-xs btn-danger' data-toggle='modal' data-target='#modalExcludeConfirm' data-link="{{route('containers.destroy', $c)}}" data-text='{{$c->name}}'><i class="fa fa-trash"></i></button>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        @can('migra')
                        <tr><td colspan="4" class='text-center bg-yellow'>@lang('messages.no_records_found')</td></tr>
                        @else
                        <tr><td colspan="2" class='text-center bg-yellow'>@lang('messages.no_records_found')</td></tr>
                        @endcan
                    @endforelse
                </tbody>
            </table>    
        </div>
        <div class="box-footer">
            <div class="pull-right">
                {{$containers->appends(\Request::except('page'))->render() }}
            </div>
        </div>
    </div>
    @include('includes.modal')
@stop