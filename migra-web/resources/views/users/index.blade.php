@extends('adminlte::page')


@section('content')
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">@lang('messages.users')</h3>
        </div>
        <div class="box-body">
            <div class="col-xs-10 no-padding">
                <form role="search" action="{{route('users.index')}}" method="GET">
                    @csrf
                    <label><input placeholder="@lang('messages.search')" type="search" name="search" class="input-sm form-control" ></label>
                    <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>
                </form>
            </div>
            @if (Gate::allows(['admin', 'operator']))
            <a href="{{route('users.create')}}"><button type="button" class="btn btn-sm  btn-primary pull-right">
            <i class="fa fa-plus"></i></button></a>
            @endif
            <table class="table table-striped table-bordered table-condensed">
                <thead>
                    <tr>
                        <th>@sortablelink('name', __('messages.name'))</th>
                        <th>@sortablelink('company.name', __('messages.company'))</th>
                        @can('admin')
                        <th>@lang('messages.type')</th>
                        @endcan
                        <th style="width: 8%">@lang('messages.actions')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $u)
                        <tr>
                            <td><a href="{{route('users.show',$u->id)}}">{{ $u->name }}</a></td>
                            <td><a href="{{route('users.show',$u->id)}}">{{$u->company->name }}</a></td>   
                            @can('admin')
                            <td>
                                @if($u->roles->first())
                                <a href="{{route('users.show',$u->id)}}">{{ $u->roles->first()->name }}</a>
                                @endif
                            </td>
                            @endcan
                            <td align="center">
                                <a href="{{route('users.show',$u->id)}}"><button type="button" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></button></a>
                                @can('admin')
                                <button class='btn btn-xs btn-danger' data-toggle='modal' data-target='#modalExcludeConfirm' data-link="{{route('users.destroy', $u)}}" data-text='{{$u->name}}'><i class="fa fa-trash"></i></button>
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
                {{$users->appends(\Request::except('page'))->render() }}
            </div>
        </div>
    </div>
@include('includes.modal')
@stop