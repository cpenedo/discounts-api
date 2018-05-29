<?php

use Faker\Generator as Faker;
use App\Category;

$factory->define(App\Discount::class, function (Faker $faker) {
    return [
    	'name' => $faker->word,
    	'description' => $faker->word,
		'minimum_customer_revenue' => $faker->randomFloat(2, 0, 9999),
		'total_order_discount_percent' => $faker->randomFloat(2, 0, 100),
        'multiple_products_same_category' => rand(1, 20),
		'free_category_products' => rand(1, 5),
        'minimum_quantity_same_category' => rand(1, 10),
		'cheapest_product_discount_percent' => $faker->randomFloat(2, 0, 100),

        'category_id' => function() {
            return factory(Category::class)->create()->id;
        },
    ];
});
