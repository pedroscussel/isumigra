@extends('adminlte::page')

@section('title', config('adminlte.title'))

@section('content_header')
@stop

@section('content')
<div class="col-md-12">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">@lang('messages.edit_country')</h3>
        </div>
        {!! Form::model($country,['method' => 'PATCH','route' => ['countries.update', $country]]) !!}
        <div class="box-body">
            <div class="form-group">
                <label for="name">@lang('messages.name')</label>
                <input type="text" class="form-control" id="name" placeholder="{{__('messages.name')}}" name="name" value="{{$country->name}}">
            </div>
            <div class="form-group">
                <label for="name">@lang('messages.abbreviation')</label>
                <input type="text" value="{{$country->abbreviation}}" class="form-control" id="abbreviation" maxlength=3 placeholder="{{__('messages.abbreviation')}}" name="abbreviation">
            </div>
        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-primary">@lang('messages.save')</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@stop