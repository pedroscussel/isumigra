{{-- @extends('adminlte::page')

@section('title')
    @lang('messages.map')
@stop

@section('navbar')
   @lang('messages.map')
@stop --}}

{{-- @section('content') --}}
    {{-- <style>
      #map {
        height: 500px; 
        width: 100%; 
       }
    </style>
    <div id="map"></div>
<script>
    function initMap() {
        var cheio = {lat: -30.013867, lng: -50.155423};
        var ok = {lat: -29.280831, lng: -51.334500};
        var enchendo = {lat: -29.697573, lng: -51.132805};
        var map = new google.maps.Map(document.getElementById('map'), {zoom: 8, center:enchendo});
        var marker = new google.maps.Marker({position: ok,  map: map}).setIcon('http://maps.google.com/mapfiles/ms/icons/green-dot.png');
        var marker = new google.maps.Marker({position: cheio,  map: map}).setIcon('http://maps.google.com/mapfiles/ms/icons/red-dot.png');
        var marker = new google.maps.Marker({position: enchendo,  map: map}).setIcon('http://maps.google.com/mapfiles/ms/icons/orange-dot.png');
    }
</script>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBnftflJlyL6cMzfnKJxWMyTGkyDzWERaE&callback=initMap">
</script> --}}
{{-- @stop --}}

{!! $map['js']!!}
{!! $map['html']!!}



