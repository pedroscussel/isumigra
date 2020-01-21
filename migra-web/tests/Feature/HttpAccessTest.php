<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class HttpAccessTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testHttpAccess()
    {
        $this->get('/')->assertStatus(302);
        $this->get('countries/')->assertStatus(302);
        $this->get('states/')->assertStatus(302);
        $this->get('cities/')->assertStatus(302);

	    $user = User::where('email', 'admin@migra.ind.br')->first();

        $this->actingAs($user);
	    $this->assertAuthenticatedAs($user);

	    $this->actingAs($user)->get('countries/')->assertStatus(200);
        $this->actingAs($user)->get('states/')->assertStatus(200);
        $this->actingAs($user)->get('cities/')->assertStatus(200);
        $this->actingAs($user)->get('container_types/')->assertStatus(200);
        $this->actingAs($user)->get('users/')->assertStatus(200);
        $this->actingAs($user)->get('companies/')->assertStatus(200);
        $this->actingAs($user)->get('trucks/')->assertStatus(200);
        $this->actingAs($user)->get('devices/')->assertStatus(200);
        $this->actingAs($user)->get('containers/')->assertStatus(200);
        $this->actingAs($user)->get('service_orders/')->assertStatus(200);

    }
}
