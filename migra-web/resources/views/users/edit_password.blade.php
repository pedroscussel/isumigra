@extends('adminlte::page')


@section('content')
    <form autocomplete="nope" method="POST" action="{{route('users.update_password')}}">
    @csrf
        <div class="box box-primary">
            <div class='box-header border'>
                <h3 class='box-title'>@lang('messages.edit_password')</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12 form-group">
                        <label>@lang('messages.current_password')</label>
                        <input required type="password" class="form-control" name="old_password">
                    </div>
                    <div class="col-sm-12 form-group">
                        <label>@lang('messages.new_password')</label>    
                        <input required type="password" class="form-control" name="new_password">
                    </div>
                    <div class="col-sm-12 form-group">
                        <label>@lang('messages.check_password')</label>
                        <input required type="password" class="form-control" name="new_password_confirmation">
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-sm btn-primary">@lang('messages.save')</button>
            </div>
        </div>
    </form>
@stop