@extends('adminlte::page')

@section('title')
    @lang('messages.new_user')
@stop

@section('content')
    <div class="box box-primary">
        {!! Form::open(['route' => 'users.store']) !!}
            @csrf
            <div class="box-header with-border">
                <h3 class="box-title">@lang('messages.new_user')</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label>@lang('messages.name')</label>
                        <input required class="form-control" type="text" name="name">
                    </div>
                    <div class="col-sm-6 form-group">
                        <label>@lang('messages.email')</label>
                        <input required class="form-control" type="text" name="email">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label for="company_id">@lang('messages.company')</label>
                        <div class="input-group">
                            {!! Form::select('company_id', $companies->pluck('name','id'), 
                            null, [ 'class' => 'form-control', 'placeholder' => __('messages.selected')])!!}
                            <a href="{{route('companies.create')}}" class="input-group-addon btn btn-primary">@lang('messages.new_company')</a>
                        </div>
                    </div>
                    <div class="col-sm-6 form-group">
                        <label for='role_id'>@lang('messages.type')</label>
                        {!! Form::select('role_id', $roles->pluck('name','id'), 
                            null, [ 'class' => 'form-control', 'placeholder' => __('messages.selected')])!!}
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">@lang('messages.save')</button>
            </div>
        {{ Form::close() }}
    </div>
@stop