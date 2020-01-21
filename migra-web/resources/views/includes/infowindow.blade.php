<div id="iw-container">
    <div class='iw-title'>{{$container->company->name}}</div>
    <div class='iw-content'>
        <a href='{{route('containers.show', $container->id)}}'>Container {{$container->name}}</a><br>
        
        <div class='progress'>
            
            <div class="progress-bar progress-bar-{{$container->device->color}}" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: {{$container->device->volume * 100}}%">
                 <span class="progress-description">{{$container->device->volume * 100}}%</span>
            </div>
        </div>
        <div>
            <a href="{{route('service_orders.create', $container->id)}}" class="btn btn-primary">@lang('messages.open_service_order')</a>
        </div>
    </div>
</div>