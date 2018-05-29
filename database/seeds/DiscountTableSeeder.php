<?php

use Illuminate\Database\Seeder;

class DiscountTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('discount')->insert([
        	[
	            'name' => '10% Total Discount',
	            'description' => 'A customer who has already bought for over € 1000, gets a discount of 10% on the whole order.',
	            'minimum_customer_revenue' => '1000',
	            'total_order_discount_percent' => '10',
	            'category_id' => null,
	            'multiple_products_same_category' => null,
	            'free_category_products' => null,
	            'minimum_quantity_same_category' => null,
	            'cheapest_product_discount_percent' => null
	        ],
	        [
	            'name' => 'Free Switches',
	            'description' => 'For every product of category "Switches" (id 2), when you buy five, you get a sixth for free.',
	            'minimum_customer_revenue' => null,
	            'total_order_discount_percent' => null,
	            'category_id' => 2,
	            'multiple_products_same_category' => 5,
	            'free_category_products' => 1,
	            'minimum_quantity_same_category' => null,
	            'cheapest_product_discount_percent' => null
	        ],
	        [
	        	'name' => 'Tools Discount',
	            'description' => 'If you buy two or more products of category "Tools" (id 1), you get a 20% discount on the cheapest product.',
	            'minimum_customer_revenue' => null,
	            'total_order_discount_percent' => null,
	            'category_id' => 1,
	            'multiple_products_same_category' => null,
	            'free_category_products' => null,
	            'minimum_quantity_same_category' => 2,
	            'cheapest_product_discount_percent' => '20'
	        ]
    	]);
    }
}
