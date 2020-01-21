@extends('adminlte::page')

@section('title')
    @lang('messages.edit_truck')
@stop

@section('content')
    <div class="box box-primary">
        {!! Form::model($truck, ['route' => ['trucks.update', $truck]]) !!}
        {{ method_field('PATCH') }}
            @csrf
            <div class="box-header">
                <h3 class="box-title">@lang('messages.trucks')</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label for='license_plate'>@lang('messages.license_plate')</label>    
                        <input required autofocus type="text" class="form-control" name="license_plate" value='{{$truck->license_plate}}'>
                    </div>
                    <div class="col-sm-6 form-group">
                        <label for='name'>@lang('messages.identify')</label>
                        <input type="text" class="form-control" name="name" value='{{$truck->name}}'>
                    </div>
                </div>
                @if (Gate::allows(['migra_operator']))
                    <div class="row">
                        <div class="col-sm-12 form-group">
                            {!!Form::select('company_id',\App\Company::all()->pluck('name', 'id'), $truck->company_id, 
                                ['class'=>'form-control js-example-basic-single'])!!}
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-sm-6">
                        <label>@lang('messages.is_defect')
                            <input type="checkbox" name='is_defect' value='1' class="minimal-red" {{$truck->is_defect?"checked":""}}>
                        </label>
                    </div>
                    <div class="col-sm-6">
                        <label>@lang('messages.is_outofservice')
                            <input type="checkbox" name='is_outofservice' value='1' class="minimal-red" {{$truck->is_outofservice?"checked":""}}>
                        </label>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-sm btn-primary">@lang('messages.save')</button>
            </div>
        {!!Form::close()!!}
    </div>
@stop