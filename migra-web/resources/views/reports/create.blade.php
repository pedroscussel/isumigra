@extends('adminlte::page')

@section('title')
@lang('messages.reports')
@stop

@section('content')

{!!Form::open(['route' => ['reports.show',$container->id]])!!}

<div class="box box-primary no-print" >
    
    <div class="box-body">
        <div class="row">
            <div class="col-sm-2 form-group">
                <label>@lang('messages.date_init')</label>
                <input class="form-control" type="date" name="start_date" value="{{$from}}">
            </div>
            <div class="col-sm-2 form-group">
                <label>@lang('messages.date_finish')</label>
                <input class="form-control" type="date" name="end_date" value="{{$to}}">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-1">
                <input type="checkbox" name="">
                <label>Opção 1</label>
            </div>
            <div class="col-sm-1">
                <input type="checkbox" name="">
                <label>Opção 2</label>
            </div>
            <div class="col-sm-1">
                <input type="checkbox" name="">
                <label>Opção 3</label>
            </div>
            <div class="col-sm-1">
                <input type="checkbox" name="">
                <label>Opção 4</label>
            </div>
        </div>
    </div>
    <div class="box-footer">
        <div class="row">
            <div class="col-md-1">
                <button type="submit" class="btn btn-sm btn-primary">@lang('messages.create_reports')</button>
            </div>
            <div class="col-md-1" id="footer"></div>
        </div>
    </div>
</div>
{!!Form::close()!!}
@yield('report')
@stop

