<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Discount;
use App\Category;

class DiscountTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_discount_can_be_created()
    {
        $discount = factory(Discount::class)->make();
        $this->assertDatabaseMissing('discount', ['name' => $discount->name]);

        $this->post('/api/discount/discount', $discount->toArray())
            ->assertStatus(200)
            ->assertJsonFragment(
                [
                    'status' => 'success',
                    'message' => class_basename($discount) . ' created.'
                ]);
        $this->assertDatabaseHas('discount', ['name' => $discount->name]);
    }
}