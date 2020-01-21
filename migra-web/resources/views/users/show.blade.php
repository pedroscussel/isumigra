@extends('adminlte::page')



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
        <div class="box-footer">

                @if(Auth::user()->id == $user->id || Gate::allows('operator'))
                    <a href="{{route('users.edit',$user->id,'edit')}}" class='btn btn-primary'>@lang('messages.edit')</a>
                @endif
                
                @if (Gate::allows('admin'))
                    <a href="{{route('users.remove',$user->id,'remove')}}" class="btn btn-danger">@lang('messages.remove')</a>
                @endif

        </div>
    </div>
@stop

