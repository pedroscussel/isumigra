@extends('adminlte::page')

@section('title')
    @lang('messages.states')
@stop

@section('content')
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">@lang('messages.states')</h3>
        </div>
        <div class="box-body">
            <div class="col-xs-10 no-padding">
                <form role="search" action="{{route('states.index')}}" method="GET">
                    @csrf
                    <label><input placeholder="@lang('messages.search')" type="search" name="search"  class="input-sm form-control" ></label>
                    <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>
                </form>
            </div>
            <a href="{{route('states.create')}}"><button type="button" class="btn btn-sm btn-primary pull-right">
            <i class="fa fa-plus"></i></button></a>
            <table class="table table-bordered table-condensed table-striped">
                <thead>
                    <tr role="row">
                        <th>@sortablelink('name', __('messages.name'))</th>
                        <th>@sortablelink('country.name',__('messages.country'))</th>
                        <th width='8%'>@lang('messages.actions')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse  ($states as $s)
                    <tr role="row" class="odd">
                        <td><a href="{{route('states.edit', $s)}}">{{ $s->name }}</a></td>
                        <td><a href="{{route('states.edit', $s)}}">{{$s->country->name }}</a></td>
                        <td align="center">
                            <a href="{{route('states.edit', $s)}}" class="btn btn-xs btn-primary" ><i class="fa fa-edit"></i></a>
                            <button class='btn btn-xs btn-danger' data-toggle='modal' data-target='#modalExcludeConfirm' data-link="{{route('states.destroy', $s)}}" data-text='{{$s->name}}'><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class='text-center bg-yellow'>@lang('message.no_records_found')</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="box-footer">
            <div class="pull-right">
                {{$states->appends(\Request::except('page'))->render() }}
            </div>
        </div>
    </div>
@include('includes.modal')
@stop
@section('js')
<script src="{{ asset('js/others.js') }}" defer></script>
@stop