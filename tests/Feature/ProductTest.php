<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Product;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_product_can_be_created()
    {
        $productModel = factory(Product::class)->make();
        $this->assertDatabaseMissing('product', ['description' => $productModel->description]);

        $product = array_merge($productModel->toArray(), ['id' => $productModel->code, 'category' => $productModel->category_id]);

        $this->post('/api/discount/product', $product)
            ->assertStatus(200)
            ->assertJsonFragment(
                [
                    'status' => 'success',
                    'message' => class_basename($productModel) . ' created.'
                ]);
        $this->assertDatabaseHas('product', ['description' => $productModel->description]);
    }

    // /** @test */
    // public function many_products_can_be_created_at_the_same_time()
    // {
    //     // $productModels = factory(Product::class, 3)->make();

    //     $path = dirname(__DIR__).'../../resources/data/products.json';
    //     $products = json_decode(file_get_contents($path));

    //     // $this->assertDatabaseMissing('product', ['description' => $productModels[0]->description]);

    //     $this->post('/api/discount/products', $products)
    //         ->assertStatus(200)
    //         ->assertJsonFragment(
    //             [
    //                 'status' => 'success',
    //                 'message' => 'All Product created.'
    //             ]);
    //     //$this->assertDatabaseHas('product', ['description' => $productModels[0]->description]);
    // }
}
