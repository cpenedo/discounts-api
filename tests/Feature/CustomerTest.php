<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Customer;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_customer_can_be_created()
    {
        $customer = factory(Customer::class)->make();
        $this->assertDatabaseMissing('customer', ['name' => $customer->name]);

        $this->post('/api/discount/customer', $customer->toArray())
            ->assertStatus(200)
            ->assertJsonFragment(
                [
                    'status' => 'success',
                    'message' => class_basename($customer) . ' created.'
                ]);
        $this->assertDatabaseHas('customer', ['name' => $customer->name]);
    }
}
