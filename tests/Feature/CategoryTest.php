<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Category;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_category_can_be_created()
    {
        $category = factory(Category::class)->make();

        $this->assertDatabaseMissing('category', ['name' => $category->name]);

        $this->post('/api/discount/category', $category->toArray())
            ->assertStatus(200)
            ->assertJsonFragment(
                [
                    'status' => 'success',
                    'message' => class_basename($category) . ' created.'
                ]);
        $this->assertDatabaseHas('category', ['name' => $category->name]);
    }
}
