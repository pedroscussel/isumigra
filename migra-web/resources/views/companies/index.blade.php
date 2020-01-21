@extends('adminlte::page')

@section('title')
    @lang('messages.companies')
@stop

@section('content')
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">@lang('messages.companies')</h3>
        </div>
        <div class="box-body">
            <div class="col-xs-10 no-padding">
                <form role="search" action="{{route('companies.index')}}" method="GET">
                    @csrf
                    <label><input placeholder="@lang('messages.search')" type="search" name="search" class="input-sm form-control"></label>
                    <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>
                </form>
            </div>
            @can('operator')
                <a href="{{route('companies.create')}}"><button type="button" class="btn btn-sm  btn-primary pull-right">
                <i class="fa fa-plus"></i></button></a>
            @endcan
            <table class="table table-striped table-bordered table-condensed">
                <thead> 
                    <tr>
                        <th>@sortablelink('name', __('messages.name'))</th>
                        @can('migra')<th>@sortablelink('owner_id', __('messages.belongs_to'))</th>@endcan
                        <th style="width: 50%">@lang('messages.address')</th>
                        <th style="width: 8%">@lang('messages.actions')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($companies as $c)
                        <tr>
                            <td><a href="{{route('companies.show',$c)}}">{{ $c->name }}</a></td>
                            @can('migra')
                                <td><a href="{{route('companies.show',$c)}}">{{$c->owner->trading_name}}</a></td>
                            @endcan
                            <td>
                                <a href="{{route('companies.show',$c)}}">{{ $c->full_address}}</a>
                            </td>
                            <td align="center">
                                <a href="{{ route('companies.show',$c) }}"><button   type="button" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></button></a>
                                @can('admin')
                                <button class='btn btn-xs btn-danger' data-toggle='modal' data-target='#modalExcludeConfirm' data-link="{{route('companies.destroy', $c)}}" data-text='{{$c->name}}'><i class="fa fa-trash"></i></button>
                                @endcan
                            </td> 
                        </tr>
                    @empty
                        @can('migra')
                        <tr><td colspan="3" class='text-center bg-yellow'>@lang('messages.no_records_found')</td></tr>
                        @else
                        <tr><td colspan="2" class='text-center bg-yellow'>@lang('messages.no_records_found')</td></tr>
                        @endcan
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="box-footer">
            <div class="pull-right">
                {{$companies->appends(\Request::except('page'))->render() }}
            </div>
        </div>
    </div>
@include('includes.modal')
@stop

