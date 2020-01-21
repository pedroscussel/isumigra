@extends('adminlte::page')

@section('title')
    @lang('messages.materials')
@stop

@section('content')
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">@lang('messages.materials')</h3>
        </div>
        <div class="box-body">
            <div class="col-xs-10 no-padding">
                <form role="search" action="{{route('materials.index')}}" method="GET">
                    @csrf
                    <label><input placeholder="@lang('messages.search')" type="search" name="search" class="input-sm form-control"></label>
                    <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>
                </form>
            </div>
            @can('operator')
                <a href="{{route('materials.create')}}"><button type="button" class="btn btn-sm btn-primary pull-right">
                <i class="fa fa-plus"></i></button></a>
            @endcan
            <table class="table table-striped table-bordered table-condensed">
                <thead>
                    <tr>
                        <th>@sortablelink('name', __('messages.name'))</th>
                        @can('migra')
                            <th>@sortablelink('company.name', __('messages.company'))</th>
                        @endcan
                        <th style="width: 8%">@lang('messages.actions')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($materials as $m)
                        <tr>
                            <td><a href="{{route('materials.show',$m)}}">{{ $m->name }}</a></td>
                            @can('migra')
                                <td><a href="{{route('materials.show',$m)}}">{{ $m->company->name }}</a></td>
                            @endcan
                            <td align="center">
                                @can('update',$m)
                                    <a href="{{route('materials.show',$m)}}">
                                    <button type="button" class="btn btn-primary btn-xs">
                                @endcan
                                @can('delete',$m)
                                    <i class="fa fa-edit"></i></button></a>
                                    <button class='btn btn-xs btn-danger' data-toggle='modal' data-target='#modalExcludeConfirm' data-link="{{route('materials.destroy', $m)}}" data-text='{{$m->name}}'><i class="fa fa-trash"></i></button>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        @can('migra')
                        <tr><td colspan="2" class='text-center bg-yellow'>@lang('messages.no_records_found')</td></tr>
                        @else
                        <tr><td colspan="1" class='text-center bg-yellow'>@lang('messages.no_records_found')</td></tr>
                        @endcan
                    @endforelse
                </tbody>
            </table>    
        </div>
        <div class="box-footer">
            <div class="pull-right">
                {{$materials->appends(\Request::except('page'))->render() }}
            </div>
        </div>
    </div>
    @include('includes.modal')
@stop