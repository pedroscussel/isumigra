@extends('adminlte::page')

@section('title')
    @lang('messages.edit_user')
@stop

@section('content')
    {!! Form::model($user, ['route' => ['users.update', $user]]) !!}
        {{ method_field('PATCH') }}
        @csrf
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">@lang('messages.edit_user')</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label>@lang('messages.name')</label>
                        <input required class="form-control" type="text" name="name" value="{{ $user->name }}">
                    </div>
                    <div class="col-sm-6 form-group">
                        <label>E-mail</label>
                        <input required class="form-control" type="text" name="email" value="{{ $user->email }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label for='role_id'>@lang('messages.type')</label>
                        {!! Form::select('role_id', $roles->pluck('name','id'), 
                            $user->roles->first()?$user->roles->first()->id:null, [ 'class' => 'form-control', 'placeholder' => __('messages.selected')])!!}
                    </div>
                    <div class="col-sm-6 form-group">
                        <label for="company_id">@lang('messages.company')</label>
                        <div class="input-group">
                            {!! Form::select('company_id', $companies->pluck('name','id'), 
                                $user->company_id, [ 'class' => 'form-control', 'placeholder' => __('messages.selected')])!!}
                            <a href="{{route('companies.create')}}" class="input-group-addon btn btn-primary">@lang('messages.new_company')</a>
                        </div>
                    </div>
                        
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-sm btn-primary">@lang('messages.save')</button>
            </div>
        </div>
    {{ Form::close() }}
@stop