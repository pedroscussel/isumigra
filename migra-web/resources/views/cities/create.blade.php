@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
@stop

@section('content')
<div class="col-md-12">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">@lang('messages.new_city')</h3>
        </div>
        {!!Form::model($city, ['route' => ['cities.store', $city]])!!}
            <div class="box-body">
                <div class="form-group">
                    <label for="name">@lang('messages.city')</label>
                    <input type="text" class="form-control" id="name" placeholder="Nome" name="name">
                </div>
                <div class='row'>
                    <div class="form-group col-md-6">
                        <label for="name">@lang('messages.country')</label>
                        {!! Form::select('country_id', \App\Country::orderBy('name')->pluck('name','id'), 
                        \App\Country::getDefault()->id, [ 'class' => 'form-control'])!!}
                    </div>
                    <div class="form-group col-md-6">
                        <label for="name">@lang('messages.state_name')</label>
                        {!! Form::select('state_id', \App\Country::getDefaultStates()->pluck('name','id'), 
                        $city->state_id, [ 'class' => 'form-control'])!!}
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">@lang('messages.save')</button>
            </div>
        {!!Form::close()!!}
    </div>
</div>
@include('includes.changestatecity')
@stop

