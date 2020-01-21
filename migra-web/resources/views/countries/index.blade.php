@extends('adminlte::page')

@section('title')
    @lang('messages.countries')
@stop

@section('content')  
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">@lang('messages.countries')</h3>
        </div>
        <div class="box-body">
            <div class="col-xs-10 no-padding">
                <form role="search" action="{{route('countries.index')}}" method="GET">
                    @csrf
                    <label><input placeholder="@lang('messages.search')" type="search" name="search"  class="input-sm form-control" ></label>
                    <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>
                </form>
            </div>
            <a href="{{route('countries.create')}}"><button type="button" class="btn btn-sm btn-primary pull-right">
            <i class="fa fa-plus"></i></button></a>
            <table class="table table-bordered table-condensed table-striped">
                <thead>
                    <tr role="row">
                        <th>@sortablelink('name', __('messages.country'))</th>
                        <th width="8%">@lang('messages.actions')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($countries as $c)
                        <tr>
                            <td><a href="{{route('countries.edit',$c->id,'edit')}}">{{ $c->name }}</a></td>
                            <td align="center">
                                <a href="{{route('countries.edit',$c->id,'edit')}}" class="btn btn-xs btn-primary">
                                <i class="fa fa-edit"></i></a>
                                <button class='btn btn-xs btn-danger' data-toggle='modal' data-target='#modalExcludeConfirm' data-link="{{route('countries.destroy', $c)}}" data-text='{{$c->name}}'><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="box-footer">
            <div class="pull-right">
                {{$countries->appends(\Request::except('page'))->render() }}
            </div>
        </div>
    </div>
    @include('includes.modal')
@stop
