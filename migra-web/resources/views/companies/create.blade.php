@extends('adminlte::page')

@section('title')
    @lang('messages.new_company')
@stop

@section('content')
    <div class="box box-primary">
        <form method='POST' action="{{route('companies.store')}}">
            @csrf
            <div class="box-header with-border">
                <h3 class="box-title">@lang('messages.new_company')</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label for="name">@lang('messages.name')</label>
                        <input required autofocus type="text" class="form-control" name="name" >
                    </div>
                    <div class="col-sm-6 form-group">
                        <label>@lang('messages.trading_name')</label>
                        <input type="text" class="form-control" name="trading_name">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label>@lang('messages.cnpj')</label>
                        <input required type="text" class="form-control" name="cnpj" >
                    </div>
                    <div class="col-sm-6 form-group">
                        <label>@lang('messages.company_type')</label>
                        <select required class="js-example-basic-single" style="width:100%" name="company_type">
                            <option value=""></option>
                            @foreach ($company_type as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 form-group">
                        <label for="street">@lang('messages.street')</label>
                        <input required type="text" class="form-control" name="street">
                    </div>
                    <div class="col-sm-4 form-group">
                        <label for="number">@lang('messages.number')</label>
                        <input required type="text" class="form-control" name="number">
                    </div>
                    <div class="col-sm-4 form-group">
                        <label for="complement">@lang('messages.complement')</label>
                        <input type="text" class="form-control" name="complement">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 form-group">
                        <label>@lang('messages.country')</label>
                        <select required class="js-example-basic-single" style="width:100%" name="country">
                            <option value=""></option>
                            @foreach ($country as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-4 form-group">
                        <label>@lang('messages.state')</label>
                        <select required class="js-example-basic-single" style="width:100%" style="width:100%" name="state">
                            <option selected value=""></option>
                        </select>
                    </div>
                    <div class="col-sm-4 form-group">
                        <label>@lang('messages.city')</label>
                        <select required class="js-example-basic-single" style="width:100%" name="city">
                            <option selected value=""></option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <!--<input type="hidden" name="route" value="{//////{ $_SERVER['HTTP_REFERER'] }}">-->
                <button type="submit" class="btn btn-sm btn-primary">@lang('messages.save')</button>
            </div>
        </div>
    </form>
    <script src="{{ asset('vendor/adminlte/vendor/jquery/dist/jquery.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        //dynamic dropdown list for states and cities
        $(document).ready(function() {
            var route = "{{asset('/country/')}}"
            $('select[name="country"]').on('change', function() {
                var countryID = $(this).val();
                if(countryID) {
                    $.ajax({
                        url: route+'/'+countryID+'/states',
                        type: "GET",
                        dataType: "json",
                        success:function(data) {
                            $('select[name="state"]').empty().append('<option value=""></option>');
                            $('select[name="city"]').empty().append('<option value=""></option>');
                            $.each(data, function(key, value) {
                                $('select[name="state"]').append('<option value="'+ key +'">'+ value +'</option>');
                            });
                        }
                    });
                }else{
                    $('select[name="state"]').empty();
                    $('select[name="city"]').empty();
                }
            });
        });
        $(document).ready(function() {
        var route = "{{asset('/state/')}}"
            $('select[name="state"]').on('change', function() {
                var stateID = $(this).val();
                if(stateID) {
                    $.ajax({
                        url: route+'/'+stateID+'/cities',
                        type: "GET",
                        dataType: "json",
                        success:function(data) {
                            $('select[name="city"]').empty().append('<option value=""></option>');
                            $.each(data, function(key, value) {
                                $('select[name="city"]').append('<option value="'+ key +'">'+ value +'</option>');
                            });
                        }
                    });
                }else{
                    $('select[name="city"]').empty();
                }
            });
        });
    </script>
@stop
