@extends('adminlte::page')

@section('title')
    @lang('messages.new_truck')
@stop

@section('content')
    <div class="box box-primary">
        {!!Form::open(['route' => 'trucks.store'])!!}
            @csrf
            <div class="box-header">
                <h3 class="box-title">@lang('messages.trucks')</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label for='license_plate'>@lang('messages.license_plate')</label>    
                        <input required autofocus type="text" class="form-control" name="license_plate" value='{{old('license_plate')}}'>
                    </div>
                    <div class="col-sm-6 form-group">
                        <label for='name'>@lang('messages.identify')</label>
                        <input type="text" class="form-control" name="name" value='{{old('name')}}'>
                    </div>
                </div>
                @if (Gate::allows(['migra_operator']))
                    <div class="row">
                        <div class="col-sm-12 form-group">
                            {!!Form::select('company_id',\App\Company::all()->pluck('name', 'id'), Auth()->user()->company_id, 
                                ['class'=>'form-control js-example-basic-single'])!!}
                        </div>
                    </div>
                @else
                    <input type='hidden' name='company_id' value='{{Auth()->user()->company_id}}'>
                @endif
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-sm btn-primary">@lang('messages.save')</button>
            </div>
        {!!Form::close()!!}
    </div>
@stop