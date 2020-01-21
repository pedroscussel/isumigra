@extends('adminlte::page')


@section('content')
    <div class="box box-primary">
        <form enctype="multipart/form-data" method="POST" action="{{route('container_types.store')}}">
            @csrf
            <div class="box-header with-border">
                <h3 class="box-title">@lang('messages.new_container_type')</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12 form-group">
                        <label for='name'>@lang('messages.name')</label>
                        <input type="text" class="form-control" name="name" id='name' value='{{old('name')}}'>
                    </div>
                </div>
                <div class='row'>
                    <div class="col-sm-12 form-group">
                        <label for="description">@lang('messages.description')</label>
                        <textarea name='description' class='form-control' id='description'>{{old('description')}}</textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3 form-group">
                        <label for='width'>@lang('messages.width')</label>
                        <div class='input-group'>
                            <input type="text" class="form-control" name="width" id="width"
                                value="{{old('width')}}" placeholder='0,00'>
                            <span class='input-group-addon'>@lang('messages.meters')</span>
                        </div>
                    </div>
                    <div class="col-sm-3 form-group">
                        <label for='length'>@lang('messages.length')</label>
                        <div class='input-group'>
                            <input type="text" class="form-control" name="length" id="length"
                                value="{{old('length')}}" placeholder='0,00'>
                            <span class='input-group-addon'>@lang('messages.meters')</span>
                        </div>
                    </div>
                    <div class="col-sm-3 form-group">
                        <label for='height'>@lang('messages.height')</label>
                        <div class='input-group'>
                            <input type="text" class="form-control" name="height" id="height"
                                value="{{old('height')}}" placeholder='0,00'>
                            <span class='input-group-addon'>@lang('messages.meters')</span>
                        </div>
                    </div>
                    <div class="col-sm-3 form-group">
                        <label for='traceable'>
                            @lang('messages.traceable')
                        </label><br>
                        <input type="checkbox" class='form-check' name="traceable" id="traceable" value="1">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3 form-group">
                        <label for='bulk'>@lang('messages.bulk')</label>
                        <div class='input-group'>
                            <input type="text" class="form-control" name="bulk" id="bulk"  value="{{old('bulk')}}" placeholder='0,00'>
                            <span class='input-group-addon'>@lang('messages.cubic_meter')</span>
                        </div>
                    </div>
                    <div class="col-sm-3 form-group">
                        <label for='weight'>@lang('messages.weight')</label>
                        <div class='input-group'>
                            <input type="text" class="form-control" name="weight" id="weight"
                                value="{{old('weight')}}" placeholder='0,00'>
                            <span class='input-group-addon'>kg</span>
                        </div>
                    </div>
                    <div class="col-sm-3 form-group">
                        <label for='carrying_capacity'>@lang('messages.capacity')</label>
                        <div class='input-group'>
                            <input type="text" class="form-control" name="carrying_capacity" id="carrying_capacity"
                                value="{{old('carrying_capacity')}}" placeholder='0,00'>
                            <span class='input-group-addon'>t</span>
                        </div>
                    </div>
                </div>
                @can('migra')
                <div class="row">
                    <div class="col-sm-12">
                        <label for='width'>@lang('messages.company')</label>
                        {!!Form::select('company_id', \App\Company::orderBy('name')->pluck('name', 'id'),
                            Auth::user()->company_id, ['class'=> 'form-control js-example-basic-single'])!!}
                    </div>
                </div>
                @else
                    <input type="hidden" class="form-control" name="company_id" id='company_id' value="{{Auth::user()->company_id}}">
                @endcan
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-sm btn-primary">@lang('messages.save')</button>
            </div>
        </form>
    </div>

@stop

