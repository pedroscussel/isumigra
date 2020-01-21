<?php

namespace Tests\Feature;

use Tests\TestFeature;
use App\User;
use App\Device;

class DeviceAccessTest extends TestFeature
{
    public function testDeviceAccess()
    {
        //Variáveis desse teste
        $viewName = 'devices';
        $item = new Device();

        //Faz um teste de acesso ao CRUD sem user logado (deve ser redirecionado pra home)
        $permissions = ['index'=> 302, 'create' => 302, 'view' => 302, 'edit' => 302];
        $this->accessWithoutUser($item, $viewName, $permissions);

        $this->withoutMiddleware();
        //Faz um teste de acesso ao CRUD, usando User específico e testando com as permissões que deveria ter
        //200: ok
        //403: negado
        //302: redirecionado (middleware ou não logado)
        //500: erro interno - teste impreciso
        //Usando loop é impreciso o lugar (user) que gerou aquilo (sem linha)
        $data = ['admin@migra.ind.br',     ['index'=> 200, 'create' => 200, 'view' => 200, 'edit' => 200]]; //migra
        $this->accessWithUser($data, $viewName, $item, "--");
        $data = ['admin@migra.ind.br',     ['index'=> 200, 'create' => 200, 'view' => 200, 'edit' => 200]]; //cliente
        $this->accessWithUser($data, $viewName, $item, "--");

        $data = ['ope@migra.ind.br',       ['index'=> 200, 'create' => 200, 'view' => 200, 'edit' => 200]]; //migra
        $this->accessWithUser($data, $viewName, $item, "--");
        $data = ['ope@migra.ind.br',       ['index'=> 200, 'create' => 200, 'view' => 200, 'edit' => 200]]; //cliente
        $this->accessWithUser($data, $viewName, $item, "--");

        $data = ['manager@migra.ind.br',   ['index'=> 200, 'create' => 403, 'view' => 200, 'edit' => 403]]; //migra
        $this->accessWithUser($data, $viewName, $item, "--");
        $data = ['manager@migra.ind.br',   ['index'=> 200, 'create' => 403, 'view' => 200, 'edit' => 403]]; //cliente
        $this->accessWithUser($data, $viewName, $item, "--");

        $data = ['comercial@migra.ind.br', ['index'=> 200, 'create' => 403, 'view' => 200, 'edit' => 403]]; //migra
        $this->accessWithUser($data, $viewName, $item, "--");
        $data = ['comercial@migra.ind.br', ['index'=> 200, 'create' => 403, 'view' => 200, 'edit' => 403]]; //cliente
        $this->accessWithUser($data, $viewName, $item, "--");

        $data = ['admin@tecnova.ind.br',   ['index'=> 403, 'create' => 403, 'view' => 403, 'edit' => 403]]; //migra
        $this->accessWithUser($data, $viewName, $item, "--");
        $data = ['admin@tecnova.ind.br',   ['index'=> 403, 'create' => 403, 'view' => 403, 'edit' => 403]]; //cliente
        $this->accessWithUser($data, $viewName, $item, "--");

        $data = ['ope@tecnova.ind.br',     ['index'=> 403, 'create' => 403, 'view' => 403, 'edit' => 403]]; //migra
        $this->accessWithUser($data, $viewName, $item, "--");
        $data = ['ope@tecnova.ind.br',     ['index'=> 403, 'create' => 403, 'view' => 403, 'edit' => 403]]; //cliente
        $this->accessWithUser($data, $viewName, $item, "--");

        $data = ['dir@tecnova.ind.br',     ['index'=> 403, 'create' => 403, 'view' => 403, 'edit' => 403]]; //migra
        $this->accessWithUser($data, $viewName, $item, "--");
        $data = ['dir@tecnova.ind.br',     ['index'=> 403, 'create' => 403, 'view' => 403, 'edit' => 403]]; //cliente
        $this->accessWithUser($data, $viewName, $item, "--");

        $data = ['com@tecnova.ind.br',     ['index'=> 403, 'create' => 403, 'view' => 403, 'edit' => 403]]; //migra
        $this->accessWithUser($data, $viewName, $item, "--");
        $data = ['com@tecnova.ind.br',     ['index'=> 403, 'create' => 403, 'view' => 403, 'edit' => 403]]; //cliente
        $this->accessWithUser($data, $viewName, $item, "--");
    }
}
