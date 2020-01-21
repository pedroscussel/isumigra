@extends('adminlte::page')

@section('title')
    @lang('messages.new_material')
@stop

@section('content')
    <div class="box box-primary">
        <form method="POST" action="{{route('materials.store')}}">
            @csrf
            <div class="box-header with-border">
                <h3 class="box-title">@lang('messages.new_material')</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label>@lang('messages.name')</label>
                        <input required type="text" class="form-control" name="name">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label>@lang('messages.description')</label>    
                        <textarea required type="text" class="form-control" name="description"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label>@lang('messages.density')</label>
                        <input type="text" class="form-control" name="density">
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">@lang('messages.save')</button>
            </div>
        </form>
    </div>
@stop