@extends('adminlte::page')

@section('title')
    @lang('messages.edit_service_order')
@stop

@section('content')
@if($service_order) <!-- so pro phpunit -->
    <div class="box box-primary">
        <div class='box-header'>
            <h3 class='box-title'>@lang('messages.edit_service_order')</h3>
        </div>
        {!! Form::model($service_order, ['route' => ['service_orders.update', $service_order]]) !!}
            {{ method_field('PATCH') }}
            @csrf
            <div class="box-body with-border">
                <div class="row">
                    <div class="col-sm-2 form-group">
                        <label>@lang('messages.service_order_number')</label>
                        <input required class="form-control" type="text" style="text-align:right" value="{{$number}}" name="number">
                    </div>
                    <div class="col-sm-10 form-group">
                        <label>@lang('messages.hirer')</label>
                        <div class='input-group'>
                            {!!Form::select('company_id', $companies->pluck('name', 'id'), $service_order->company_id, ['class' => 'form-control js-example-basic-single'])!!}
                            <a href="{{route('companies.create')}}" class='input-group-addon btn btn-primary'>@lang('messages.new_company')</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label>@lang('messages.origin_location')</label>
                        {!!Form::select('origin_company', $companies->pluck('name', 'id'), $companies->where('address_id', $service_order->address_src_id), ['class' => 'form-control js-example-basic-single'])!!}
                    </div>
                    <div class="col-sm-6 form-group">
                        <label>@lang('messages.destination_location')</label>
                        {!!Form::select('destination_company', $companies->pluck('name', 'id'), $companies->where('address_id', $service_order->address_des_id), ['class' => 'form-control js-example-basic-single'])!!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label>@lang('messages.address')</label>
                        {!!Form::select('origin_address', $address_src, $address_src, ['class' => 'form-control js-example-basic-single'])!!}
                    </div>
                    <div class="col-sm-6 form-group">
                        <label>@lang('messages.address')</label>
                        {!!Form::select('destination_address', $address_des, $address_des, ['class' => 'form-control js-example-basic-single'])!!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label>@lang('messages.container')</label>
                        @if ($service_order->container_id)
                            {!!Form::select('container_id', $containers->pluck('name', 'id'), $service_order->container_id, ['class' => 'form-control js-example-basic-single'])!!}
                        @else
                            {!!Form::select('container_id', $containers->pluck('name', 'id'), null, ['class' => 'form-control js-example-basic-single', 'placeholder' => __('messages.selected')])!!}
                        @endif
                    </div>
                    <div class="col-sm-6 form-group">
                        <label>@lang('messages.container_type')</label>
                        @if ($service_order->container_type_id)
                            {!!Form::select('container_type_id', $container_types->pluck('name', 'id'), $service_order->container_type_id, ['class' => 'form-control js-example-basic-single'])!!}
                        @else
                            {!!Form::select('container_type_id', $container_types->pluck('name', 'id'), null, ['class' => 'form-control js-example-basic-single', 'placeholder' => __('messages.selected')])!!}
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label>@lang('messages.material')</label>
                        <div class='input-group'>
                            @if($service_order->material_real)
                                {!!Form::select('material_id', $materials->pluck('name', 'id'), $service_order->material_real, ['class' => 'form-control js-example-basic-single'])!!}
                            @else
                                {!!Form::select('material_id', $materials->pluck('name', 'id'), $service_order->material_id, ['class' => 'form-control js-example-basic-single'])!!}
                            @endcan
                            <a href="{{route('materials.create')}}" class='input-group-addon btn btn-primary'>@lang('messages.new_material')</a>
                        </div>
                    </div>
                    <div class="col-sm-5 form-group">
                        <label>@lang('messages.quantity')</label>
                        <input required class="form-control" value="{{ $quantity }}" type="text" name="quantity">
                    </div>
                    <div class="col-sm-1 form-group">
                        <label>@lang('messages.unity')</label>
                        <select class="js-example-basic-single" style="width:100%" name="unity">
                            <option value="Kg">Kg</option>
                            <option value="Ton">Ton</option>
                            <option value="m&sup3;">m&sup3;</option>
                            <option value="L">L</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label>@lang('messages.truck')</label>
                        {!!Form::select('truck_id', $trucks->pluck('license_plate', 'id'), $service_order->truck_id, ['class' => 'form-control js-example-basic-single'])!!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <label>@lang('messages.finish') <input type="checkbox" class='form-check' name="finish" value="1"></label>
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
@endif
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
