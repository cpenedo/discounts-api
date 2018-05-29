<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Order;
use App\Discount;
use App\Category;
use App\Customer;
use App\Product;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    protected $customer;
    protected $category1;
    protected $category2;
    protected $product1;
    protected $product2;
    protected $discount1;
    protected $discount2;
    protected $discount3;

    public function setUp()
    {
        parent::setUp();

        $this->customer = factory(Customer::class)->create([
            'id' => '1',
            'name' => 'Joe',
            'since' => '2014-06-28',
            'revenue' => '1500',
        ]);

        $this->category1 = factory(Category::class)->create([
            'id' => 1,
            'name' => 'Tools'
        ]);
        $this->category2 = factory(Category::class)->create([
            'id' => 2,
            'name' => 'Switches'
        ]);

        $this->product1 = factory(Product::class)->create([
            'id' => 1,
            'description' => 'Screwdriver',
            'category_id' => $this->category1->id
        ]);
        $this->product2 = factory(Product::class)->create([
            'id' => 2,
            'description' => 'Electric screwdriver',
            'category_id' => $this->category1->id
        ]);
        $this->product3 = factory(Product::class)->create([
            'id' => 3,
            'description' => 'Basic on-off switch',
            'category_id' => $this->category2->id
        ]);

        $this->discount1 = factory(Discount::class)->create([
            'name' => '10% Total Discount',
            'description' => 'A customer who has already bought for over € 1000, gets a discount of 10% on the whole order.',
            'minimum_customer_revenue' => '1000',
            'total_order_discount_percent' => '10',
            'category_id' => null,
            'multiple_products_same_category' => null,
            'free_category_products' => null,
            'minimum_quantity_same_category' => null,
            'cheapest_product_discount_percent' => null
        ]);

        $this->discount2 = factory(Discount::class)->create([
            'name' => 'Free Switches',
            'description' => 'For every product of category "Switches" (id 2), when you buy five, you get a sixth for free.',
            'minimum_customer_revenue' => null,
            'total_order_discount_percent' => null,
            'category_id' => $this->category2->id,
            'multiple_products_same_category' => 5,
            'free_category_products' => 1,
            'minimum_quantity_same_category' => null,
            'cheapest_product_discount_percent' => null
        ]);

        $this->discount3 = factory(Discount::class)->create([
            'name' => 'Tools Discount',
            'description' => 'If you buy two or more products of category "Tools" (id 1), you get a 20% discount on the cheapest product.',
            'minimum_customer_revenue' => null,
            'total_order_discount_percent' => null,
            'category_id' => $this->category1->id,
            'multiple_products_same_category' => null,
            'free_category_products' => null,
            'minimum_quantity_same_category' => 2,
            'cheapest_product_discount_percent' => '20'
        ]);
    }

    /** @test */
    public function an_order_and_its_items_can_be_created()
    {
        $order = [
            'id' => 132,
            'customer-id' => $this->customer->id,
            'items' => [
                [
                    'product-id' => $this->product1->code,
                    'quantity' => "2",
                    'unit-price' => "9.75",
                    "total" => "19.50"
                ],
                [
                    'product-id' => $this->product2->code,
                    'quantity' => "5",
                    'unit-price' => "49.50",
                    "total" => "49.50"
                ]
            ],
            'total' => '69.00'
        ];

        $this->assertDatabaseMissing('order', ['id' => 132]);

        $this->post('/api/discount/order', $order)
            ->assertStatus(200)
            ->assertJsonFragment([
                'message' => 'Order processed successfully'
            ]);
        
        $this->assertDatabaseHas('order', ['id' => 132]);
        $this->assertDatabaseHas('order_item', ['unit_price' => '9.75']);
        $this->assertDatabaseHas('order_item', ['unit_price' => '49.50']);

    }
}
