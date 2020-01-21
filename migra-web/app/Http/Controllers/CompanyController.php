<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

use Gate;
use App\Company;
use App\CompanyType;
use App\Country;
use App\State;
use App\City;
use App\Address;
use App\Container;
use App\ServiceOrder;
use App\Device;

class CompanyController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware(['auth', 'can:users']);
    }

    public function index()
    {
        if (Gate::allows('migra')) {
            $companies = Company::search()->sortable('name', 'owner_id')->paginate(config('config.paginate'));
        } else {
            $companies = Company::search()->sortable('name', 'owner_id')->onlyCompany(Auth::user()->company_id)->paginate(config('config.paginate'));
        }
        return  view('companies.index', compact('companies'));
    }

    public function create()
    {
        $this->authorize('create', new Company());
        $country = Country::all();
        $state = State::all();
        $city = City::all();
        $company_type = CompanyType::all()->where('name', '<>', 'Migra');
        return view('companies.create', compact('country', 'state', 'city', 'company_type'));
    }

    public function store(Request $request)
    {
        $company = new Company;
        $this->authorize('create', $company);
        $request->validate([
            'cnpj' => function ($attribute, $value, $fail) {
                foreach (Company::onlyCompany(Auth::user()->company_id)->get() as $c) {
                    if ($value === $c->cnpj) {
                        $fail('CNPJ já existente.');
                    }
                }
            },
        ]);

        $address = new Address;
        $address->street = $request->street;
        $address->number = $request->number;
        $address->complement = $request->complement;
        $address->city_id = $request->city;
        $address->save();
        $company->name = $request->name;
        $company->trading_name = $request->trading_name ?:  $request->name;
        $company->cnpj = $request->cnpj;
        $company->address_id = $address->id;
        $company->company_type_id = $request->company_type;
        $company->owner_id = Auth::user()->company_id;
        $company->created_at = now();
        $company->save();

        return redirect($request->route);
    }

    public function show($id)
    {
        $company = Company::find($id);
        $this->authorize('view', $company);

        //return view('companies.show', compact('company', 'containers', 'containers_full', 'containers_filling', 'containers_empty'));
        return view('companies.show', compact('company'));
    }

    public function edit($id)
    {
        $company = Company::find($id);
        $this->authorize('update', $company);
        $country = Country::all();
        $state = State::all();
        $city = City::all();
        $company_type = CompanyType::all()->where('name', '<>', 'Migra');
        return view('companies.edit', compact('company', 'country', 'state', 'city', 'company_type'));
    }

    public function update(Request $request, $id)
    {
        $company = Company::find($id);
        $this->authorize('update', $company);
        $request->validate([
            'cnpj' => function ($attribute, $value, $fail) use ($id) {
                $companies = Company::onlyCompany(Auth::user()->company_id)->get()->reject(function ($value, $key) use ($id) {
                    return $value == Company::find($id);
                });
                foreach ($companies as $c) {
                    if ($value === $c->cnpj) {
                        $fail('CNPJ já existente.');
                    }
                }
            },
        ]);

        $company->name = $request->name;
        $company->trading_name = $request->trading_name;
        $company->cnpj = $request->cnpj;
        $company->address->street = $request->street;
        $company->address->number = $request->number;
        $company->address->complement = $request->complement;
        $company->company_type_id = $request->company_type;
        $company->address->city_id = $request->city;
        $company->address->save();
        $company->save();
        return redirect()->action('CompanyController@show', $id);
    }

    public function remove($id)
    {
        try {
            $company = Company::findOrFail($id);
            $this->authorize('delete', $company);
        } catch (QueryException  $e) {
            return redirect('users')->with("error", trans('message.no_records_found'));
        } catch (ModelNotFoundException $e) {
            return redirect('users')->with("error", trans('message.no_record_found'));
        }
        return view('companies.remove', compact('company'));
    }

    public function destroy(Request $request, $id)
    {
        try {
            $company = Company::findOrFail($id);
            $this->authorize('delete', $company);
            $company->delete();
        } catch (QueryException  $e) {
            return redirect('users')->with("error", trans('message.no_records_found'));
        } catch (ModelNotFoundException $e) {
            return redirect('users')->with("error", trans('message.no_record_found'));
        }
        return redirect()->action('CompanyController@index');
    }
}
