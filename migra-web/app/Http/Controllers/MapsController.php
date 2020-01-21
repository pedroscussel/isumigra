<?php

namespace App\Http\Controllers;

use Gate;
use Illuminate\Http\Request;
use FarhanWazir\GoogleMaps\GMaps;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Container;
use App\Company;

class MapsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $container_full = new Collection();
        $container_filling = new Collection();
        $container_empty = new Collection();

        $config['center'] = '-29.728888, -53.317669';
        $config['zoom'] = '6';
        $config['map_height'] = '500px';
        $config['geocodeCaching'] = true;
        $gmap = new GMaps();
        $gmap->initialize($config);
        
        if (Auth::user()->hasAccess(['admin_migra','migra'])) {
            $containers = Container::join('devices', 'devices.container_id', 'containers.id')->
            orderByDesc('devices.volume')->select('containers.*')->get();
        } else {
            $containers = Container::where('company_id', Auth::user()->company_id)->
            join('devices', 'devices.container_id', 'containers.id')->orderByDesc('devices.volume')->select('containers.*')->get();
        }
        
        foreach ($containers as $c) {
            if ($c->device->volume > 0.7) {
                $container_full->push($c);
                $marker['icon'] = 'http://maps.google.com/mapfiles/ms/icons/red-dot.png';
            } elseif ($c->device->volume > 0.4) {
                $container_filling->push($c);
                $marker['icon'] = 'http://maps.google.com/mapfiles/ms/icons/orange-dot.png';
            } else {
                $container_empty->push($c);
                $marker['icon'] = 'http://maps.google.com/mapfiles/ms/icons/green-dot.png';
            }
            if (Auth::user()->hasAccess(['admin_migra','migra'])) {
                $marker['infowindow_content'] = '<a href="' . route('containers.show', $c->id) . '">' . 'Container ' . $c->name . '</a>, Empresa ' . $c->company->name;
            } else {
                $marker['infowindow_content'] = '<a href="' . route('containers.show', $c->id) . '">' . 'Container ' . $c->name;
            }
            $marker['position'] = $c->device->latitude . "," . $c->device->longitude;
            $gmap->add_marker($marker);
        }
        $map = $gmap->create_map();

        return view('maps.index', compact('map', 'container_full', 'container_filling', 'container_empty'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
