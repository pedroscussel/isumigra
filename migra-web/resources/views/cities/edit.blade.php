@extends('adminlte::page')

@section('title', config('adminlte.title'))

@section('content_header')
@stop

@section('content')
<div class="col-md-12">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">@lang('messages.edit_city')</h3>
        </div>
        <div class="box-body">
            {!! Form::model($city,['method' => 'PATCH','route' => ['cities.update', $city]]) !!}
            <div class="form-group">
                <label for="name">@lang('messages.city_name')</label>
                {!! Form::text('name', null, array('placeholder' => 'Nome','class' => 'form-control', 'id'=>'name')) !!} 
            </div>
            <div class='row'>
                <div class="form-group col-md-6">
                    <label for="name">@lang('messages.country')</label>
                    {!! Form::select('country_id', \App\Country::orderBy('name')->pluck('name','id'), 
                    $city->state->country_id, [ 'class' => 'form-control'])!!}
                </div>
                <div class="form-group col-md-6">
                    <label for="name">@lang('messages.state')</label>
                    {!! Form::select('state_id', \App\State::where('country_id', $city->state->country_id)->orderBy('name')->pluck('name','id'), 
                    $city->state_id, [ 'class' => 'form-control'])!!}
                </div>
            </div>
            
        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-primary">@lang('messages.save')</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@include('includes.changestatecity')
@stop