@extends('adminlte::page')

@section('title')
    @lang('messages.material')
@stop

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <p class="box-title">@lang('messages.data')</p>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12"><label>@lang('messages.name'):</label> {{ $material->name }}</div>
            </div>
            <div class="row">
                <div class="col-md-12"><label>@lang('messages.description'):</label> {{ $material->description }}</div>
            </div>
            <div class="row">
                <div class="col-md-12"><label>@lang('messages.density'):</label> {{$material->density}} m&sup3;/kg</div>
            </div>
        </div>
        <div class="box-footer">
            @can('update',$material)
                <a href="{{route('materials.edit',$material)}}">
                <button type="button" class="btn btn-primary">@lang('messages.edit')</button></a>
            @endcan
            @can('delete',$material)
                <button class='btn btn-danger' data-toggle='modal' data-target='#modalExcludeConfirm' data-link="{{route('materials.destroy', $material)}}" data-text='{{$material->name}}'>@lang('messages.remove')</button>
            @endcan
        </div>
    </div>
    @include('includes.modal')
@stop