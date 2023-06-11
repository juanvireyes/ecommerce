<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrdersAdminTest extends TestCase
{
    use RefreshDatabase;

    protected Role $superadminRole;
    protected User $user;
    protected User $client;
    protected Role $clientRole;


    public function setUp(): void
    {
        parent::setUp();
        $this->superadminRole = Role::create(['name' => 'superadmin']);
        $this->clientRole = Role::create(['name' => 'client']);

        $this->client = User::factory()->create();
        $this->user = User::factory()->create();
    }

    /**
     * @test
     */
    public function superadmin_can_see_orders_page(): void
    {
        $this->user->assignRole($this->superadminRole);
        $this->client->assignRole($this->clientRole);
        $this->actingAs($this->user);

        $response = $this->get(route('user.orders', $this->client));

        Log::info('Esta es la respuesta del test: ' . $response->content());

        $response->assertStatus(200);
        $response->assertViewIs('superadmin.orders.index');
    }

    /** @test */
    public function client_cannot_see_orders_page(): void
    {
        $this->user->assignRole($this->clientRole);
        $this->client->assignRole($this->clientRole);

        $this->assertTrue($this->user->hasRole('client'));

        $this->actingAs($this->user);

        $response = $this->get(route('user.orders', $this->client));

        Log::info('Esta es la respuesta del test: ' . $response->content());

        $response->assertStatus(403);
    }
}
