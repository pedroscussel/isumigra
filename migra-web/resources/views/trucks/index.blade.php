@extends('adminlte::page')


@section('content')
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">@lang('messages.trucks')</h3>
        </div>
        <div class="box-body">
            <div class="col-xs-10 no-padding">
                <form role="search" action="{{route('trucks.index')}}" method="GET">
                    @csrf
                    <label ><input placeholder="@lang('messages.search')" type="search" name="search" class="input-sm form-control"></label>
                    <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>
                </form>
            </div>
            @if (Gate::allows(['operator']))
                <a href="{{route('trucks.create')}}"><button type="button" class="btn btn-sm btn-primary pull-right">
                <i class="fa fa-plus"></i></button></a>
            @endif
            <table class="table table-striped table-bordered table-condensed">
                <thead>
                    <tr>
                        <th style="width: 32%">@sortablelink('license_plate', __('messages.license_plate'))</th>
                        <th>@sortablelink('name', __('messages.identify'))</th>
                        <th>@sortablelink('is_defect', __('messages.is_defect'))</th>
                        <th>@sortablelink('is_outofservice', __('messages.is_outofservice'))</th>
                        @if (Gate::allows('migra'))
                        <th style="width: 32%">@sortablelink('company.name', __('messages.company'))</th>
                        @endif
                        <th width="8%">@lang('messages.actions')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($trucks as $t)
                        <tr>
                            <td><a href='{{route('trucks.show',$t)}}'>{{ $t->license_plate }}</a></td>
                            <td><a href='{{route('trucks.show',$t)}}'>{{ $t->name }}</a></td>
                            <td class='text-center'>
                                @if($t->is_defect)
                                    <span class="label label-danger">@lang('messages.yes')</span>
                                @endif
                            </td>
                            <td class='text-center'>
                                @if($t->is_outofservice)
                                    <span class="label label-danger">@lang('messages.yes')</span>
                                @endif
                                
                            </td>
                            @if (Gate::allows('migra'))
                            <td><a href='{{route('trucks.show',$t)}}'>{{ optional($t->company)->name}}</a></td>
                            @endif
                            <td align="center">
                                <a href="{{route('trucks.show',$t)}}"><button class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></button></a>
                                @can('admin')
                                <button class='btn btn-xs btn-danger' data-toggle='modal' data-target='#modalExcludeConfirm' data-link="{{route('trucks.destroy', $t)}}" data-text='{{$t->license_plate}}'><i class="fa fa-trash"></i></button>
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
        <div class="pull-right">
            {{$trucks->appends(\Request::except('page'))->render() }}
        </div>
    </div>
@include('includes.modal')
@stop