<?php
return [
    /* =====================================================================
    |                                                                       |
    |                  Global Settings For Google Map                       |
    |                                                                       |
    ===================================================================== */



    /* =====================================================================
    General
    ===================================================================== */
    //'key' => env('GOOGLE_MAPS_API_KEY', 'AIzaSyBnftflJlyL6cMzfnKJxWMyTGkyDzWERaE'), //Get API key: https://code.google.com/apis/console
    'key' => env('GOOGLE_MAPS_API_KEY', 'AIzaSyACG6gPtkfO0mA7Ycl8pFWAX6tmHi2E0Uo'), //Get API key: https://code.google.com/apis/console
  
    'adsense_publisher_id' => env('GOOGLE_ADSENSE_PUBLISHER_ID', ''), //Google AdSense publisher ID

    'geocode' => [
        'cache' => true, //Geocode caching into database
        'table_name' => 'gmaps_geocache', //Geocode caching database table name
    ],

    'css_class' => '', //Your custom css class

    'http_proxy' => env('HTTP_PROXY', null), // Proxy host and port
    
    'FULL' => 'http://maps.google.com/mapfiles/ms/icons/red-dot.png',
    'HALFFULL' => 'http://maps.google.com/mapfiles/ms/icons/orange-dot.png',
    'EMPTY' => 'http://maps.google.com/mapfiles/ms/icons/green-dot.png',
    
    'map_height' => '500px',
    'zoom' => 6,
    'center' => '-29.775853, -53.024361',
];
