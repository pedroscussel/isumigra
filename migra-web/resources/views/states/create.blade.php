@extends('adminlte::page')

@section('title', config('adminlte.title'))

@section('content_header')
@stop

@section('content')
<div class="col-md-12">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">@lang('messages.new_state')</h3>
        </div>
        <form role="form" action="{{route('states.store')}}" method="POST">
            @csrf
            <div class="box-body">
                <div class="form-group">
                    <label for="name">@lang('messages.state_name')</label>
                    <input type="text" class="form-control" id="name" placeholder="{{__('messages.name')}}" name="name" value="{{ old('name') }}">
                </div>
                <div class='row'>
                    <div class="form-group col-md-6">
                        <label for="name">@lang('messages.abbreviation')</label>
                        <input type="text" class="form-control" id="abbreviation" placeholder="{{__('messages.abbreviation')}}" name="abbreviation" value="{{ old('abbreviation') }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label>@lang('messages.country')</label>
                        {{\Form::select('country_id', \App\Country::orderBy('name')->pluck('name', 'id'),old('country_id'),['class'=>"form-control", 'placeholder'=>__('messages.selected')])}}
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">@lang('messages.save')</button>
            </div>
        </form>
  </div>
</div>
@stop
