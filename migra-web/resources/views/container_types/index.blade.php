@extends('adminlte::page')

@section('title', config('adminlte.title'))


@section('content')
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">@lang('messages.container_types')</h3>
        </div>
        <div class="box-body">
            <div class="col-xs-10 no-padding">
                <form role="search" action="{{route('container_types.index')}}" method="get">
                    @csrf
                    <label><input placeholder="@lang('messages.search')" type="search" name="search" class="input-sm form-control"></label>
                    <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>
                </form>
            </div>
            @if(Gate::allows(['operator']))
                <a href="{{route('container_types.create')}}"><button type="button" class="btn btn-sm btn-primary pull-right">
                <i class="fa fa-plus"></i></button></a>
            @endif
            <table class="table table-bordered table-condensed table-striped" >
                <thead>
                    <tr role="row">
                        <th>@sortablelink('name', __('messages.name'))</th>
                        <th class='text-center'>@lang('messages.size')</th>
                        <th class='text-center'>@lang('messages.bulk') (@lang('messages.cubic_meter'))</th>
                        @can('migra')
                            <th>@sortablelink('company.name', __('messages.company'))</th>
                        @endcan
                        <th style="width: 8%">@lang('messages.actions')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($container_types as $c)
                        <tr>
                            <td><a href='{{route('container_types.show', $c)}}'>{{ $c->name }}</a></td>
                            <td class='text-center'><a href='{{route('container_types.show', $c)}}'>{{ $c->size }}</a></td>
                            <td class='text-center'><a href='{{route('container_types.show', $c)}}'>{{ $c->bulk }}</a></td>
                            @can('migra')
                                <td><a href='{{route('container_types.show', $c)}}'>{{ $c->company->name }}</a></td>
                            @endcan
                            <td align="center">
                                @can('operator')
                                    <a href="{{route('container_types.edit',$c)}}" class="btn btn-xs btn-primary">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <button class='btn btn-xs btn-danger' data-toggle='modal' data-target='#modalExcludeConfirm'
                                        data-link="{{route('container_types.destroy', $c)}}" data-text='{{$c->name}}'>
                                        <i class="fa fa-trash"></i>
                                    </button>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        @can('migra')
                            <tr><td colspan="5" class='text-center bg-yellow'>@lang('messages.no_records_found')</td></tr>
                        @else
                            <tr><td colspan="4" class='text-center bg-yellow'>@lang('messages.no_records_found')</td></tr>
                        @endcan
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="box-footer">
            <div class="pull-right">
                {{$container_types->appends(\Request::except('page'))->render() }}
            </div>
        </div>
    </div>
@include('includes.modal')
@stop
