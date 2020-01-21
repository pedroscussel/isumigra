@extends('adminlte::page')

@section('title')
    @lang('messages.home')
@stop

@push('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/gmap.css')}}">
@endpush

@section('content')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class='box-title'>@lang('messages.filters')</h3>
        </div>
        <div class="box-body">
            {!!Form::open(['route' => 'home', 'method' => 'get'])!!}
                <div class="input-group">
                    @if(Gate::allows('migra'))
                        {!!Form::select('company_id', App\Company::all()->pluck('name', 'id'), $company_id, ["class"=>'form-control js-example-basic-single', 'id'=>'company_id'])!!}
                    @else
                        {!!Form::select('company_id', App\Company::onlyCompany(\Auth::user()->company_id)->pluck('name', 'id'), $company_id, ["class"=>'form-control js-example-basic-single', 'id'=>'company_id'])!!}
                    @endif
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-info btn-flat"><i class="fa fa-search"></i></button>
                    </span>
                </div>
            {!!Form::close()!!}
        </div>
    </div>
    <div class="row">
        <div class="col-lg-2">
            <a href="{{route('home', ['company_id' => $company_id] ) }}">
                <div id="all" class="small-box bg-aqua">
                    <div class="inner">
                        @if(Gate::allows('migra') && $company_id === Auth::user()->company_id)
                            <h3>{{$company->countAllContainers()}}</h3>
                        @else
                            <h3>{{$company->containers->count()}}</h3>
                        @endif
                        <p>@lang('messages.containers')</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-cube"></i>
                    </div>
                    <div class="small-box-footer">@lang('messages.filter') <i class="fa fa-arrow-circle-right"></i></div>
                </div>
            </a>
        </div>
        <div class="col-lg-2">
            <a href="{{route('home', ['company_id' => $company_id, 'filter' => 'full'] ) }}">
                <div id="full" class="small-box bg-red">
                    <div class="inner">
                        @if(Gate::allows('migra') && $company_id === Auth::user()->company_id)
                            <h3>{{$company->countAllFullContainers()}}</h3>
                        @else
                            <h3>{{$company->countFullContainers()}}</h3>
                        @endif
                        <p>@lang('messages.full_plural')</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-exclamation"></i>
                    </div>
                    <div class="small-box-footer">@lang('messages.filter') <i class="fa fa-arrow-circle-right"></i></div>
                </div>
            </a>
        </div>
        <div class="col-lg-2">
            <a href="{{route('home', ['company_id' => $company_id, 'filter' => 'halffull'] ) }}">
                <div id="halffull" class="small-box bg-orange">
                    <div class="inner">
                        @if(Gate::allows('migra') && $company_id === Auth::user()->company_id)
                            <h3>{{$company->countAllHalfFullContainers()}}</h3>
                        @else
                            <h3>{{$company->countHalfFullContainers()}}</h3>
                        @endif
                        <p>@lang('messages.filling')</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-minus"></i>
                    </div>
                    <div class="small-box-footer">@lang('messages.filter') <i class="fa fa-arrow-circle-right"></i></div>
                </div>
            </a>
        </div>
        <div class="col-lg-2">
            <a href="{{route('home', ['company_id' => $company_id, 'filter' => 'empty'] ) }}">
                <div id="empty" class="small-box bg-green">
                    <div class="inner">
                        @if(Gate::allows('migra') && $company_id === Auth::user()->company_id)
                            <h3>{{$company->countAllEmptyContainers()}}</h3>
                        @else
                            <h3>{{$company->countEmptyContainers()}}</h3>
                        @endif
                        <p>@lang('messages.empty_plural')</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-check"></i>
                    </div>
                    <div class="small-box-footer">@lang('messages.filter') <i class="fa fa-arrow-circle-right"></i></div>
                </div>
            </a>
        </div>
        <div class="col-lg-2">
            <a href="{{route('home', ['company_id' => $company_id, 'filter' => 'lowbattery'] ) }}">
                <div id="lowbattery" class="small-box bg-blue">
                    <div class="inner">
                        @if(Gate::allows('migra') && $company_id === Auth::user()->company_id)
                            <h3>{{$company->countAllLowBatteryContainers()}}</h3>
                        @else
                            <h3>{{$company->countLowBatteryContainers()}}</h3>
                        @endif
                            <p>@lang('messages.low_battery')</p>
                        </div>
                    <div class="icon">
                        <i class="fa fa-battery-1"></i>
                    </div>
                    <div class="small-box-footer">@lang('messages.filter') <i class="fa fa-arrow-circle-right"></i></div>
                </div>
            </a>
        </div>
        <div class="col-lg-2">
            <a href="{{route('home', ['company_id' => $company_id, 'filter' => 'old'] ) }}">
                <div id="old" class="small-box bg-olive">
                    <div class="inner">
                        @if(Gate::allows('migra') && $company_id === Auth::user()->company_id)
                            <h3>{{$company->countAllOldContainers()}}</h3>
                        @else
                            <h3>{{$company->countOldContainers()}}</h3>
                        @endif
                        <p>@lang('messages.old')</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-hourglass-half"></i>
                    </div>
                    <div class="small-box-footer">@lang('messages.filter') <i class="fa fa-arrow-circle-right"></i></div>
                </div>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-5">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 id="title" class="box-title"></h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-condensed table-striped">
                        <tbody>
                            <tr>
                                @if(Gate::allows('migra'))
                                    <th>@lang('messages.serial')</td>
                                @else
                                    <th>@lang('messages.name')</td>
                                @endcan
                                <th>@sortablelink('device.volume', __('messages.ocupation'))</td>
                                <th>@sortablelink('device.bat', __('messages.battery'))</td>
                                <th>@sortablelink('activeServiceOrder.daysSinceCreated', __('messages.time'))</th>
                                @if(Gate::allows('operator'))
                                    <th>@lang('messages.service_order')</th>
                                @endif
                            </tr>
                            @foreach ($containers as $c)
                            <tr>
                                @if(Gate::allows('migra'))
                                    <td>{{$c->serial}}</td>
                                @else
                                    <td>{{$c->name}}</td>
                                @endcan
                                <!-- @todo: atualizar o volume igual ao bat, assim atualiza do mongo pro mysql -->
                                <td>{{$c->device->volume*100}}&#37;</td>
                                <td>{{$c->device->getBatteryPercentage()}}&#37;</td>
                                <td>{{$c->activeServiceOrder->daysSinceCreated()}}</td>
                                @if(Gate::allows('operator'))
                                    <td align="right">
                                        <a href={{route('service_orders.create',$c)}}>@lang('messages.open_service_order')</a>
                                    </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-sm-7">
            {!! $map['js'] !!}
            {!! $map['html'] !!}
        </div>
    </div>

@stop

@push('js')
<!-- JAVASCRIPT AQUI -->
<script>
$(document).ready(function(){

    $("#company_id").change(function(){
        $(this).closest('form').trigger('submit');
    });
    switch(new URLSearchParams(location.search).get('filter')) {
        case 'full':
        title.innerHTML = "@lang('messages.containers_full')";
        full.classList.add('bg-red-active');
        break;
        case 'halffull':
        title.innerHTML = "@lang('messages.containers_halffull')";
        halffull.classList.add('bg-orange-active');
        break;
        case 'empty':
        title.innerHTML = "@lang('messages.containers_empty')";
        empty.classList.add('bg-green-active');
        break;
        case 'lowbattery':
        title.innerHTML = "@lang('messages.low_battery')";
        lowbattery.classList.add('bg-blue-active');
        break;
        case 'old':
        title.innerHTML = "@lang('messages.old')";
        old.classList.add('bg-olive-active');
        break;
        default:
        title.innerHTML = "@lang('messages.containers')";
        all.classList.add('bg-aqua-active');
    }
});

</script>
@endpush
