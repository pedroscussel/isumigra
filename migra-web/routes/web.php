<?php


Route::get('/', function () {
    return Auth::user() ? redirect()->action('HomeController@index') : view('auth.login');
});

Route::get('/', 'HomeController@index')->name('home');
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/companies/{company}/remove', 'CompanyController@remove')->name('companies.remove');
Route::resource('/companies', 'CompanyController');

Route::get('/containers/{container}/download', 'ContainerController@download')->name('containers.download');
Route::get('/containers/{container}/remove', 'ContainerController@remove')->name('containers.remove');
Route::resource('/containers', 'ContainerController');

Route::get('/devices/{device}/remove', 'DeviceController@remove')->name('devices.remove');
Route::resource('/devices', 'DeviceController');

Route::get('/trucks/{truck}/remove', 'TruckController@remove')->name('trucks.remove');
Route::resource('/trucks', 'TruckController');

Route::resource('/service_orders', 'ServiceOrderController');

Route::get('/edit_password', 'UserController@editPassword')->name('users.edit_password');
Route::post('/updatePassword', 'UserController@updatePassword')->name('users.update_password');

Route::get('/users/{user}/remove', 'UserController@remove')->name('users.remove');
Route::resource('/users', 'UserController');

Route::get('/container_types/{container_type}/removeDocument', 'ContainerTypeController@removeDocument')->name('container_types.removeDocument');
Route::get('/container_types/{container_type}/download', 'ContainerTypeController@download')->name('container_types.download');
Route::get('/container_types/{container_type}/remove', 'ContainerTypeController@remove')->name('container_types.remove');
Route::resource('/container_types', 'ContainerTypeController');

Route::resource('/countries', 'CountryController');

Route::resource('/states', 'StateController');

Route::resource('/cities', 'CityController');

Route::resource('/maps', 'MapsController');
Route::resource('security', 'SecurityController');
Route::resource('documents', 'DocumentController');
Route::get('documents/download/{id}', 'DocumentController@download')->name('documents.download');
Route::resource('materials', 'MaterialController');

Route::get('reports/create/{container}', 'ReportController@create')->name('reports.create');
Route::post('reports/show/{container}', 'ReportController@show')->name('reports.show');

Route::get('country/{id}/states', function ($id) {
    return json_encode(App\State::where('country_id', $id)->pluck('name', 'id'));
})->name('states.get');

Route::get('state/{id}/cities', function ($id) {
    return json_encode(App\City::where('state_id', $id)->pluck('name', 'id'));
})->name('cities.get');

Route::get('company/{id}/containers', function ($id) {
    if(Gate::allows('migra')) {
        return json_encode(App\Container::whereNull('company_service_id')->whereNull('service_order_id')->where('company_id',$id)->orWhere('company_service_id', $id)->pluck('name', 'id'));
    } else {
        return json_encode(App\Container::onlyCompany(Auth::user()->company_id)->where('company_service_id', $id)->whereNull('service_order_id')->pluck('name', 'id'));
    }
});

Route::get('company/{id}/addresses', function ($id) {
    $company = App\Company::find($id);
    $address = $company->getFullAddressAttribute();
    $address_id = $company->address_id;
    return json_encode(array($address_id => $address));
});
