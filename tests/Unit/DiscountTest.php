<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use App\Discount;
use App\Category;
use App\Order;
use App\Customer;
use App\Product;

class DiscountTest extends TestCase
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

    /**
     * Call protected/private method of a class.
     *
     * @param object &$object    Instantiated object that we will run method on.
     * @param string $methodName Method name to call
     * @param array  $parameters Array of parameters to pass into method.
     *
     * @return mixed Method return.
     */
    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    /** @test */
    public function calculate_discount_value()
    {
        $value = 200;
        $percentage = 10;

        $this->assertEquals(
            Discount::calculateDiscount($value, $percentage),
            20
        );
    }

    /** @test */
    public function calculate_total_discount_value_from_first_discount_type()
    {
        $order = factory(Order::class)->create([
            'customer_id' => $this->customer->id,
            'total' => 200
        ]);

        $this->assertEquals(
            $this->invokeMethod($this->discount1, 'totalDiscount', [$order]),
            [
                'name' => $this->discount1->name,
                'discount-value' => 20,
            ]
        );
    }

    // /** @test */
    // public function calculate_cheapest_product_discount_value_from_third_discount_type()
    // {

    // }

    // /** @test */
    // public function calculate_total_free_products_from_secound_discount_type()
    // {
        
    // }

}
