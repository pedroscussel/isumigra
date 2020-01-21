<?php

namespace App\Tools;

use FarhanWazir\GoogleMaps\GMaps;
use App\Container;

class ContainerMap
{
    
    private $gmap;
    private $config = [];
    
    public function __construct()
    {
        $this->gmap = new GMaps();
        $this->set('map_height', config('googlemaps.map_height'));
        $this->set('zoom', config('googlemaps.zoom'));
        $this->set('center', config('googlemaps.center'));
    }
    
    public function set($param, $value)
    {
        $this->config[$param] = $value;
    }
    
    public function initialize()
    {
        $this->gmap->initialize($this->config);
    }
    
    public function addMarker(Container $container)
    {
        $view = view('includes.infowindow', compact('container'));
        
        $marker['icon'] = config("googlemaps.$container->status");
        $marker['infowindow_content'] = trim(preg_replace('~[\r\n]+~', '', $view->render()));
        $marker['position'] = $container->device->position;
        //$marker['position'] = $container->device->gps;
        $this->gmap->add_marker($marker);
    }
    
    public function createMap()
    {
        return $this->gmap->create_map();
    }
}
