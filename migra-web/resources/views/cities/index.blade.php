@extends('adminlte::page')

@section('title')
    @lang('messages.cities')
@stop

@section('content')
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">@lang('messages.cities')</h3>
        </div>
        <div class="box-body">
            <div class="col-xs-10 no-padding">
                <form role="search" action="{{route('cities.index')}}" method="GET">
                    @csrf
                    <label><input placeholder="@lang('messages.search')" type="search" name="search"  class="input-sm form-control" ></label>
                    <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>
                </form>
            </div>
            <a href="{{route('cities.create')}}"><button type="button" class="btn btn-sm btn-primary pull-right">
            <i class="fa fa-plus"></i></button></a>
            <table class="table table-bordered table-condensed table-striped">
                <thead>
                    <tr role="row">
                        <th>@sortablelink('name', __('messages.name'))</th>
                        <th>@sortablelink('state_id', __('messages.state'))</th>
                        <th width='8%' >@lang('messages.actions')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cities as $c)
                        <tr role="row" class="odd">
                            <td><a href="{{route('cities.edit', $c)}}">{{ $c->name }}</a></td>
                            <td>{{$c->state->name }}</td>
                            <td align="center">
                                <a href="{{route('cities.edit', $c)}}" class="btn btn-xs btn-primary" ><i class="fa fa-edit"></i></a>
                                <button class='btn btn-xs btn-danger' data-toggle='modal' data-target='#modalExcludeConfirm' data-link="{{route('cities.destroy', $c)}}" data-text='{{$c->name}}'><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class='text-center bg-yellow'>@lang('messages.no_records_found')</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="box-footer">
            <div class="pull-right">
                {{$cities->appends(\Request::except('page'))->render() }}
            </div>
        </div>
    </div>
    @include('includes.modal')
@stop
