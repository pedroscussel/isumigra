<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\TestCase;
use App\User;
use App\Material;

abstract class TestFeature extends BaseTestCase
{
    use CreatesApplication;
    ////////////////////////////////////////////////////////////////////////////////////////////
    //
    // Método de teste sem usuário autenticado
    //
    /////////////////////////////////////////////////////////////////////////////////////////////
    protected function accessWithoutUser($item, $viewName, $permissions) {
        $itemData = $item->all()->first();

        $this->get('/'.$viewName)->assertStatus($permissions['index']);
        $this->get('/'.$viewName.'/create')->assertStatus($permissions['create']);
        $this->get('/'.$viewName.'/' . $itemData->id)->assertStatus($permissions['view']);
        $this->get('/'.$viewName.'/' . $itemData->id . '/edit')->assertStatus($permissions['edit']);
    }

    /////////////////////////////////////////////////////////////////////////////////////////////
    //
    // Método de teste com usuário autenticado
    //
    /////////////////////////////////////////////////////////////////////////////////////////////
    protected function accessWithUser($data, $viewName, $item, $type) {
        $user = User::where('email', $data[0])->first();
        $this->assertInstanceOf(User::class, $user);

        $permissions = $data[1];

        //Nivel de data pra testar com o usuário
        if ($type == "migra" || $type == "--")
            $itemData = $item->all()->first();
        else
            $itemData = $item->onlyCompany($user->company_id)->get()->first();

        //Os testes de CRUD
        if ($type == "migra" || $type == "--") {
            //index
            $this->actingAs($user)->get('/'.$viewName)->assertStatus($permissions['index']);
            //create
            $this->actingAs($user)->get('/'.$viewName.'/create')->assertStatus($permissions['create']);
        }
        //view
        $this->actingAs($user)->get('/'.$viewName.'/' . $itemData->id)->assertStatus($permissions['view']);
        //edit
        $this->actingAs($user)->get('/'.$viewName.'/' . $itemData->id . '/edit')->assertStatus($permissions['edit']);
    }
}
