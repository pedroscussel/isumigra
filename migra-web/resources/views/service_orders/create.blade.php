@extends('adminlte::page')

@section('title')
    @lang('messages.new_service_order')
@stop

@section('content')
    <div class="box box-primary">
        <div class='box-header'>
            <h3 class='box-title'>@lang('messages.new_service_order')</h3>
        </div>

        {!! Form::open(['route' => 'service_orders.store']) !!}
            @csrf
            <div class="box-body with-border">
                <div class="row">
                    <div class="col-sm-2 form-group">
                        <label>@lang('messages.service_order_number')</label>
                        <input class="form-control" style="text-align:right" type="text" value="{{$number}}" name="number">
                    </div>
                    <div class="col-sm-10 form-group">
                        <label>@lang('messages.hirer')</label>
                        <div class='input-group'>
                            {!!Form::select('company_id', $companies->pluck('name', 'id'), null, ['required', 'class' => 'form-control js-example-basic-single', 'placeholder' => __('messages.selected')])!!}
                            <a href="{{route('companies.create')}}" class='input-group-addon btn btn-primary'>@lang('messages.new_company')</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label>@lang('messages.origin_location')</label>
                        {!!Form::select('origin_company', $companies->pluck('name', 'id'), null, ['class' => 'form-control js-example-basic-single', 'placeholder' => __('messages.selected')])!!}
                    </div>
                    <div class="col-sm-6 form-group">
                        <label>@lang('messages.destination_location')</label>
                        {!!Form::select('destination_company', $companies->pluck('name', 'id'), null, ['class' => 'form-control js-example-basic-single', 'placeholder' => __('messages.selected')])!!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label>@lang('messages.address')</label>
                        <select class="js-example-basic-single" style="width:100%" name="origin_address">
                            <option selected value="">@lang('messages.selected') @lang('messages.origin_location')</option>
                        </select>
                    </div>
                    <div class="col-sm-6 form-group">
                        <label>@lang('messages.address')</label>
                        <select class="js-example-basic-single" style="width:100%" name="destination_address">
                            <option selected value="">@lang('messages.selected') @lang('messages.destination_location')</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label>@lang('messages.container')</label>
                        @if ($container)
                            {!!Form::select('container_id', $containers->pluck('name', 'id'), $containers->where('id',$container->id)->pluck('name', 'id'), ['class' => 'form-control js-example-basic-single'])!!}
                        @else
                            <select class="js-example-basic-single" style="width:100%" name="container_id">
                                <option selected  value="">@lang('messages.selected') @lang('messages.origin_location')</option>
                            </select>
                        @endif
                    </div>
                    <div class="col-sm-6 form-group">
                        <label>@lang('messages.container_type')</label>
                        @if ($container)
                            {!!Form::select('container_type_id', $container_types->pluck('name', 'id'), $container_types->where('id',$container->type->id)->pluck('name', 'id'), ['class' => 'form-control js-example-basic-single'])!!}
                        @else
                            {!!Form::select('container_type_id', $container_types->pluck('name', 'id'), null, ['class' => 'form-control js-example-basic-single', 'placeholder' => __('messages.selected')])!!}
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label>@lang('messages.material')</label>
                        <div class='input-group'>
                            {!!Form::select('material_id', $materials->pluck('name', 'id'), null, ['class' => 'form-control js-example-basic-single', 'placeholder' => __('messages.selected')])!!}
                            <a href="{{route('materials.create')}}" class='input-group-addon btn btn-primary'>@lang('messages.new_material')</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label>@lang('messages.truck')</label>
                        {!!Form::select('truck_id', $trucks->pluck('license_plate', 'id'), null, ['class' => 'form-control js-example-basic-single', 'placeholder' => __('messages.selected')])!!}
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div class="row col-md-1">
                    <button type="submit" class="btn btn-sm btn-primary">@lang('messages.save')</button>
                </div>
            </div>
        {{ Form::close() }}
    </div>
@stop

@push('js')
<script>
        var route = "{{asset('company')}}";
        $('select[name="origin_company"]').on('change', function(){
            var company_id = $(this).val();
            if(company_id) {
                    $.ajax({
                        url: route+'/'+company_id+'/addresses',
                        type: "GET",
                        dataType: "json",
                        success:function(data) {
                            $('select[name="origin_address"]').empty().append('<option value="">@lang('messages.selected')</option>');
                            $.each(data, function(key, value) {
                                $('select[name="origin_address"]').append('<option value="'+ key +'">'+ value +'</option>');
                            });
                        }
                    });
                    $.ajax({
                        url: route+'/'+company_id+'/containers',
                        type: "GET",
                        dataType: "json",
                        success:function(data) {
                            $('select[name="container_id"]').empty().append('<option value="">@lang('messages.selected')</option>');
                            $.each(data, function(key, value) {
                                $('select[name="container_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                            });
                        }
                    });
                } else {
                    $('select[name="container_id"]').empty();
                    $('select[name="origin_address"]').empty();
                }
        });

        $('select[name="destination_company"]').on('change', function(){
            var company_id = $(this).val();
            if(company_id) {
                    $.ajax({
                        url: route+'/'+company_id+'/addresses',
                        type: "GET",
                        dataType: "json",
                        success:function(data) {
                            $('select[name="destination_address"]').empty().append('<option value="">@lang('messages.selected')</option>');
                            $.each(data, function(key, value) {
                                $('select[name="destination_address"]').append('<option value="'+ key +'">'+ value +'</option>');
                            });
                        }
                    });
                } else {
                    $('select[name="destination_address"]').empty();
                }
        });

</script>
@endpush
