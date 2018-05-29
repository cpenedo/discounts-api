<?php

use Faker\Generator as Faker;
use App\Product;
use App\Category;

$factory->define(Product::class, function (Faker $faker) {
    return [
    	'code' => $faker->word,
        'description' => $faker->word,
		'price' => $faker->randomFloat(2, 0, 100),
        'category_id' => function() {
            return factory(Category::class)->create()->id;
        },
    ];
});
