<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Container;
use Carbon\Carbon;
class ReportController extends Controller
{
    
    public function create($id)
    {
        $container = Container::find($id);
        $from = ($container->created_at->toDateString());
        $to = date("Y-m-d");
        return view('reports.create', compact('container', 'from', 'to'));
    }
    
    
    public function show($id , Request $request)
    {
        $container = Container::find($id);
        $from = $request->start_date;
        $to = $request->end_date;
        $now = date("Y-m-d h:i:s");
        $service_orders = $container->serviceOrder->whereBetween('created_at', [$from . date("h:i:s"), $to . date("h:i:s")]);
        return view('reports.show', compact('container', 'from', 'to', 'now', 'service_orders'));
    }

    // public function companyCreate($id)
    // {
    //     $company = Company::find($id);
    //     $from = ($container->created_at->toDateString());
    //     $to = date("Y-m-d");
    //     return view('reports.create', compact('container', 'from', 'to'));
    // }
    
    
    // public function companyShow($id , Request $request)
    // {
    //     $ccompany = Company::find($id);
    //     $from = $request->start_date;
    //     $to = $request->end_date;
    //     $now = Carbon::now()->sub(3,'hours');
    //     $service_orders = $container->serviceOrder->whereBetween('created_at', $from, $to);
    //     return view('reports._company', compact('container', 'from', 'to', 'now', $service_orders));
    // }    
}
