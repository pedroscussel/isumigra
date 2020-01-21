@extends('adminlte::page')

@section('title')
    @lang('messages.container_type')
@stop

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <p class="box-title">@lang('messages.data')</p>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12"><label>@lang('messages.type'):</label> {{ $container_type->name }}</div>
            </div>
            <div class="row">
                <div class="col-md-12"><label>@lang('messages.description'):</label> {{ $container_type->description }}</div>
            </div>
            <div class="row">
                <div class="col-md-12"><label>@lang('messages.documents'):</label> 
                    @foreach ($container_type->documents as $d)
                            <p><a href="{{route('container_types.download',$d->id)}}">
                            <i class="fa fa-file"></i> {{ $d->name }}</p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <form method="POST" action="{{route('container_types.destroy',$container_type->id)}}">
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
