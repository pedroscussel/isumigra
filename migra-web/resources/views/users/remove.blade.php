@extends('adminlte::page')

@section('title')
    @lang('messages.remove_user')
@stop

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <p class="box-title">@lang('messages.data')</p>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12"><label>@lang('messages.name'):</label> {{ $user->name }}</div>
            </div>
            <div class="row">
                <div class="col-md-12"><label>@lang('messages.company'):</label> {{ $user->company->name }}</div>
            </div>
            <div class="row">
                <div class="col-md-12"><label>@lang('messages.email'):</label> {{ $user->email }}</div>
            </div>
            <div class="row">
                <div class="col-md-12"><label>@lang('messages.type'):</label> {{ $user->roles->first()->name }}</div>
            </div>
        </div>
    </div>
    <form method="POST" action="{{route('users.destroy', $user->id)}}">
        @csrf
        @method('DELETE')
        <div class="box">
            <div class="box-header with-border">
                <p>@lang('messages.remove_record')</p>
                <h4>@lang('messages.remove_record_warning')</h4>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-3">
                        <button class="btn btn-sm btn-danger">@lang('messages.remove')</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop

