<div class="row">
    <div class="col-md-3"><label>@lang('messages.serial'): </label> {{ $device->name }}</div>
    <div class="col-md-3"><label>@lang('messages.model'): </label> {{ $device->modelDevice->name }}</div>
    <div class="col-md-3"><label>@lang('messages.version'): </label> {{ $device->modelDevice->version }}</div>
</div>
<div class="row">
    <div class="col-md-3">
        <label>@lang('messages.container'): </label>
        @if($device->container_id)
        <a href='{{route('containers.show', $device->container_id)}}'>{{ $device->container->name }}</a>
        @endif
    </div>
    <div class="col-md-3"><label>@lang('messages.type'): </label> {{ $device->container->originalType->name }}</div>
    <div class="col-md-6">
        <label>@lang('messages.company'): </label>
        @if($device->container_id)
        <a href='{{route('companies.show', $device->container->company)}}'>{{ $device->container->company->name }}</a>
        @endif
    </div>
</div>
<hr>
<p class="box-title">@lang('messages.data_from_device')</p>
<div class="row">
    <div class='col-md-2'>
        <label>@lang('messages.mass') 1: </label>
        <div class='input-group-with-text'>
            <span class='input-group-text text-center'>{{$device->getData("Distancia1")}}</span>
        </div>
    </div>
    <div class='col-md-2'>
        <label>@lang('messages.mass') 2: </label>
        <div class='input-group-with-text'>
            <span class='input-group-text text-center'>{{$device->getData("Distancia2")}}</span>
        </div>
    </div>
    <div class='col-md-2'>
        <label>@lang('messages.mass') 3: </label>
        <div class='input-group-with-text'>
            <span class='input-group-text text-center'>{{$device->getData("Distancia3")}}</span>
        </div>
    </div>
    <div class='col-md-2'>
        <label>@lang('messages.mass') 4: </label>
        <div class='input-group-with-text'>
            <span class='input-group-text text-center'>{{$device->getData("Distancia4")}}</span>
        </div>
    </div>
    <div class='col-md-2'>
        <label>@lang('messages.volume'): </label>
        <div class='input-group-with-text'>
            <span class='input-group-text text-center'>{{number_format($device->getVolume(), 2)}}</span>
            <span class="input-group-addon">@lang('messages.cubic_meter')</span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-2 form-group">
        <label>@lang('messages.material')</label>
        <div class='input-group col-sm-12'>
            {!!Form::select('material_id',
            $materials,
            null,
            ['class' => 'form-control materials-density']
            )!!}
        </div>
    </div>
    @push('js')
    <script type="text/javascript">
        /////////////////////////////////////////////////////////////////////////
        console.log("LOG DE VALORES DOS SENSORES");
        console.log("Distancia 1: " + "{{$device->getData('Distancia1')}}");
        console.log("Distancia 2: " + "{{$device->getData('Distancia2')}}");
        console.log("Distancia 3: " + "{{$device->getData('Distancia3')}}");
        console.log("Distancia 4: " + "{{$device->getData('Distancia4')}}");
        console.log("NTC: " + "{{$device->getData('ntc')}}");
        console.log("BAT: " + "{{$device->getData('bat')}}");
        console.log("GPS: " + "{{$device->getData('gps')}}");

        console.log("-----------------------------------------------");
        console.log("Volume calculado: " + "{{$device->getVolume()}}");
        console.log("Massa calculada: " + "{{$device->getWeight()}}");
        console.log("Temperatura calculada: " + "{{$device->getTemperature()}}");
        /////////////////////////////////////////////////////////////////////////


        var volumeContainer = parseFloat("{{$device->getVolume()}}");

        function onMaterialChange() {
            var density = parseFloat($('.materials-density').find('option:selected').val());
            var newValue = volumeContainer * density;
            $('#container-weight').text(newValue.toFixed(2));
        }

        $(document).ready(function () {
            //inicializar select no certo
            var materialSelected = "{{$material_selected}}";
            if (materialSelected != "") {
                $('.materials-density').find('option').each(function () {
                    if ($(this).text() == materialSelected) {
                        $(this).attr('selected', 'selected');
                    }
                });
            }
            onMaterialChange();
        });

        $('.materials-density').on('change', onMaterialChange);

    </script>
    @endpush
    <div class='col-md-2'>
        <label>@lang('messages.actual_weight'): </label>
        <div class='input-group-with-text'>
            <span class='input-group-text text-center' id="container-weight">{{number_format($device->getWeight(), 2)}}
            </span>
            <span class="input-group-addon">ton</span>
        </div>
    </div>
</div>
<div class="row">
    <div class='col-md-2'>
        <label>@lang('messages.ntc'): </label>
        <div class='input-group-with-text'>
            <span class='input-group-text text-center'>{{number_format($device->getTemperature(), 2)}}</span>
            <span class='input-group-addon'>@lang('messages.degrees_celsius')</span>
        </div>
    </div>
    <div class='col-md-2'>
        <label>@lang('messages.battery'): </label>
        <div class='input-group-with-text'>
            <span class='input-group-text text-center'>{{number_format($device->getBatteryPercentage(), 2)}}</span>
            <span class='input-group-addon'>V</span>
        </div>
    </div>
</div>
<div class="row">
    <div class='col-md-4'>
        <label>@lang('messages.gps'): </label>
        <div class='input-group-with-text'>
            <span class='input-group-text text-center'>&nbsp;{{$device->getPositionAttribute()}}</span>
        </div>
    </div>
</div>
<div class="row">
    <div class='col-md-4'>
        <label>@lang('messages.mqtt_timestamp'): </label>
        <div class='input-group-with-text'>
            <span class='input-group-text text-center'>&nbsp;{{$device->getMqttTimestamp()}}</span>
        </div>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-3">
        <label>@lang('messages.is_defect'):</label>
        <p>
            @if($device->is_defect)
            <span class="label label-danger">@lang('messages.yes')</span>
            @else
            <span class="label label-success">@lang('messages.no')</span>
            @endif
        </p>
    </div>
    <div class="col-md-3">
        <label>@lang('messages.is_outofservice'):</label>
        <p>
            @if($device->is_outofservice)
            <span class="label label-danger">@lang('messages.yes')</span>
            @else
            <span class="label label-success">@lang('messages.no')</span>
            @endif
        </p>
    </div>
</div>
