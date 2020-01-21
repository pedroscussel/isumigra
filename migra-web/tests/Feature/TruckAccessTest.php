<?php

namespace Tests\Feature;

use Tests\TestFeature;
use App\User;
use App\Truck;
use Illuminate\Support\Facades\Auth;

class TruckAccessTest extends TestFeature
{
    public function testTruckAccess()
    {
        //Variáveis desse teste
        $viewName = 'trucks';
        $item = new Truck();

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
        $this->accessWithUser($data, $viewName, $item, "migra");
        $data = ['admin@migra.ind.br',     ['index'=> 200, 'create' => 200, 'view' => 200, 'edit' => 200]]; //cliente
        $this->accessWithUser($data, $viewName, $item, "cliente");

        $data = ['ope@migra.ind.br',       ['index'=> 200, 'create' => 200, 'view' => 200, 'edit' => 200]]; //migra
        $this->accessWithUser($data, $viewName, $item, "migra");
        $data = ['ope@migra.ind.br',       ['index'=> 200, 'create' => 200, 'view' => 200, 'edit' => 200]]; //cliente
        $this->accessWithUser($data, $viewName, $item, "cliente");

        $data = ['manager@migra.ind.br',   ['index'=> 200, 'create' => 403, 'view' => 200, 'edit' => 403]]; //migra
        $this->accessWithUser($data, $viewName, $item, "migra");
        $data = ['manager@migra.ind.br',   ['index'=> 200, 'create' => 403, 'view' => 200, 'edit' => 403]]; //cliente
        $this->accessWithUser($data, $viewName, $item, "cliente");

        $data = ['comercial@migra.ind.br', ['index'=> 200, 'create' => 403, 'view' => 200, 'edit' => 403]]; //migra
        $this->accessWithUser($data, $viewName, $item, "migra");
        $data = ['comercial@migra.ind.br', ['index'=> 200, 'create' => 403, 'view' => 200, 'edit' => 403]]; //cliente
        $this->accessWithUser($data, $viewName, $item, "cliente");

        $data = ['admin@tecnova.ind.br',   ['index'=> 200, 'create' => 200, 'view' => 403, 'edit' => 403]]; //migra
        $this->accessWithUser($data, $viewName, $item, "migra");
        $data = ['admin@tecnova.ind.br',   ['index'=> 200, 'create' => 200, 'view' => 200, 'edit' => 200]]; //cliente
        $this->accessWithUser($data, $viewName, $item, "cliente");

        $data = ['ope@tecnova.ind.br',     ['index'=> 200, 'create' => 200, 'view' => 403, 'edit' => 403]]; //migra
        $this->accessWithUser($data, $viewName, $item, "migra");
        $data = ['ope@tecnova.ind.br',     ['index'=> 200, 'create' => 200, 'view' => 200, 'edit' => 200]]; //cliente
        $this->accessWithUser($data, $viewName, $item, "cliente");

        $data = ['dir@tecnova.ind.br',     ['index'=> 200, 'create' => 403, 'view' => 403, 'edit' => 403]]; //migra
        $this->accessWithUser($data, $viewName, $item, "migra");
        $data = ['dir@tecnova.ind.br',     ['index'=> 200, 'create' => 403, 'view' => 200, 'edit' => 403]]; //cliente
        $this->accessWithUser($data, $viewName, $item, "cliente");

        $data = ['com@tecnova.ind.br',     ['index'=> 200, 'create' => 403, 'view' => 403, 'edit' => 403]]; //migra
        $this->accessWithUser($data, $viewName, $item, "migra");
        $data = ['com@tecnova.ind.br',     ['index'=> 200, 'create' => 403, 'view' => 200, 'edit' => 403]]; //cliente
        $this->accessWithUser($data, $viewName, $item, "cliente");
    }
}
