<?php

namespace App\Http\Controllers;

use Gate;
use Jenssegers\Agent\Agent;
use FarhanWazir\GoogleMaps\GMaps;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Container;
use App\ServiceOrder;
use App\Company;
use App\Device;
use App\Tools\ContainerMap;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $agent = new Agent();
        $moving = new Collection();
        $container_full = new Collection();
        $container_filling = new Collection();
        $container_empty = new Collection();

        $gmap = new GMaps();
        $config['map_height'] = '500px';
        $config['center'] = '-29.775853, -53.024361';
        $config['zoom'] = 6;
        $gmap->initialize($config);
        $company_id = $request->company_id?:Auth::user()->company_id;
        $company = Company::find($company_id);
        $filter = $request->filter;
        if (Gate::allows('migra') && Auth::user()->company_id === $company_id) {
            $containers = method_exists(Container::class, 'scope'.$filter) ?
            Container::sortable()->$filter()->get() :
            Container::sortable('device.volume')->get();
        } else {
            $containers = method_exists(Container::class, 'scope'.$filter) ?
            Container::sortable()->onlyCompany($company_id)->$filter()->get() :
            Container::sortable('device.volume')->onlyCompany($company_id)->get();
        }

        $cm = new ContainerMap();
        $cm->initialize();


        foreach ($containers as $c) {

            // Atualiza os dados no mysql do mongo, isso é necessário nos blocos antes de listar os conteiners
            $c->device->updateBatteryPercentageFromMongo();
            $c->device->getPositionAttribute();

            // Google Maps
            $cm->addMarker($c);

//            if ($c->device->volume > 0.7) {
//                $container_full->push($c);
//                $marker['icon'] = 'http://maps.google.com/mapfiles/ms/icons/red-dot.png';
//            } elseif ($c->device->volume > 0.4) {
//                $container_filling->push($c);
//                $marker['icon'] = 'http://maps.google.com/mapfiles/ms/icons/orange-dot.png';
//            } else {
//                $container_empty->push($c);
//                $marker['icon'] = 'http://maps.google.com/mapfiles/ms/icons/green-dot.png';
//            }
//            $marker['position'] = ($c->device->latitude + mt_rand(-45, 45)/10000).",".($c->device->longitude + mt_rand(-45, 45)/10000) ;
//            $marker['position'] = $c->device->latitude. ",".$c->device->longitude;
//            if (Gate::allows('business')) {
//                $marker['infowindow_content'] = '<a href="'.route('containers.show', $c->id).'">Container '.$c->name.'</a>, Empresa '.$c->company->name;
//                $circle['center'] = $c->device->latitude.",".$c->device->longitude;
//                $circle['radius'] = '500';
//                $gmap->add_circle($circle);
//                if ($this->markerOutsideCircle($marker, $circle)) {
//                    $moving->push($c);
//                }
//            } else {
//                $marker['infowindow_content'] = '<a href="'.route('containers.show', $c->id).'">Container '.$c->name;
//            }
//            $gmap->add_marker($marker);
        }
        $map = $cm->createMap();

        return view('home', compact('company_id', 'company', 'moving', 'map', 'containers'));
    }


    // private function markerOutsideCircle($marker, $circle)
    // {
    //     $point = $this->pointStringToCoordinates($marker['position']);
    //     $center = $this->pointStringToCoordinates($circle['center']);
    //     $radius = $circle['radius'];
    //     return (sqrt(pow($point['x']-$center['x'], 2)+pow($point['y']-$center['y'], 2))*102470 > $radius );
    // }

    // private function pointStringToCoordinates($pointString)
    // {
    //     if (strpos($pointString, ", ") !== false) {
    //         $coordinates = explode(", ", $pointString);
    //     } elseif (strpos($pointString, ",") !== false) {
    //         $coordinates = explode(",", $pointString);
    //     } elseif (strpos($pointString, " ,") !== false) {
    //         $coordinates = explode(",", $pointString);
    //     } else {
    //         $coordinates = explode(" ", $pointString);
    //     }
    //     return array("x" => $coordinates[0], "y" => $coordinates[1]);
    // }
}
