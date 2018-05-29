<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\DiscountServiceApi;

class DiscountServiceApiTest extends TestCase
{
    use RefreshDatabase;

    protected $discountService;

    public function setUp()
    {
        parent::setUp();
        $this->discountService = new DiscountServiceApi;
    }

    /** @test */
    public function a_model_is_created()
    {
        $category = new Category();

        $model = factory(Category::class)->make();
        $this->assertDatabaseMissing('category', ['name' => $model->name]);

        $this->assertEquals(
            $this->discountService->create($category, $model->toArray()),
            response()->json([
                'status' => 'success',
                'message' => class_basename($model) . ' created.'
            ])
        );

        $this->assertDatabaseHas('category', ['name' => $model->name]);
    }
}
