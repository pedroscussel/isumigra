@extends('adminlte::page')

@section('title')
    @lang('messages.edit_company')
@stop

@section('content')
    <form method="POST" action="{{route('companies.update',$company)}}">
        @csrf
        @method('PATCH')
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">@lang('messages.edit_company')</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label>@lang('messages.name')</label>
                        <input required type="text" class="form-control" name="name" value="{{$company->name}}">
                    </div>
                    <div class="col-sm-6 form-group">
                        <label>@lang('messages.trading_name')</label>
                        <input required type="text" class="form-control" name="trading_name" value="{{$company->trading_name}}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label for="cnpj">@lang('messages.cnpj')</label>
                        <input required type="text" class="form-control" name="cnpj" value="{{$company->cnpj}}">
                    </div>
                    <div class="col-sm-6 form-group">
                        <label>@lang('messages.company_type')</label>
                        <select required class="js-example-basic-single" style="width:100%" name="company_type" >
                            @foreach ($company_type as $c)
                                @if($c->id == $company->company_type_id)
                                    <option selected value="{{ $c->id }}">{{ $c->name }}</option>
                                @else
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 form-group">
                         <label for="street">@lang('messages.street')</label>
                         <input required type="text" class="form-control" name="street" value="{{ $company->address->street }}">
                     </div>
                     <div class="col-sm-4 form-group">
                         <label for="number">@lang('messages.number')</label>
                         <input required type="text" class="form-control" name="number" value="{{ $company->address->number }}">
                     </div>
                     <div class="col-sm-4 form-group">
                         <label for="complement">@lang('messages.complement')</label>
                         <input type="text" class="form-control" name="complement" value="{{ $company->address->complement }}">
                     </div>
                 </div>
                <div class="row">
                    <div class="col-sm-4 form-group">
                        <label>@lang('messages.country')</label>
                        <select required class="js-example-basic-single" style="width:100%" name="country">
                            @foreach ($country as $c)
                                @if($c->id == $company->address->country()->id)
                                    <option selected value="{{ $c->id }}">{{ $c->name }}</option>
                                @else
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-4 form-group">
                        <label>@lang('messages.state')</label>
                        <select required class="js-example-basic-single" style="width:100%" name="state">
                            @foreach ($state as $s)
                                @if($s->id == $company->address->state()->id)
                                    <option selected value="{{ $s->id }}">{{$s->name}}</option>
                                @else
                                    <option value="{{ $s->id }}">{{$s->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-4 form-group">
                        <label>@lang('messages.city')</label>
                        <select required class="js-example-basic-single" style="width:100%" name="city">
                            @foreach ($city as $c)
                                @if($c->id == $company->address->city->id)
                                <option selected value="{{ $c->id }}">{{$c->name}}</option>
                                @elseif($c->state_id == $company->address->city->state_id)
                                <option value="{{ $c->id }}">{{$c->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>  
            <div class="box-footer">
                <button type="submit" class="btn btn-sm btn-primary">@lang('messages.save')</button>
            </div>
        </div>
    </form>
    <script src="{{ asset('vendor/adminlte/vendor/jquery/dist/jquery.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        //dynamic dropdown list for states and cities
        $(document).ready(function() {
            var route = "{{asset('/states/')}}"
            $('select[name="country"]').on('change', function() {
                var stateID = $(this).val();
                if(stateID) {
                    $.ajax({
                        url: route+'/'+stateID+'/get',
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
            var route = "{{asset('/cities/')}}"
            $('select[name="state"]').on('change', function() {
                var stateID = $(this).val();
                if(stateID) {
                    $.ajax({
                        url: route+'/'+stateID+'/get',
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
