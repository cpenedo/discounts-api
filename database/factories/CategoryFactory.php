<?php

use Faker\Generator as Faker;

$factory->define(App\Category::class, function (Faker $faker) {
    return [
    	'id' => rand(1, 200),
        'name' => $faker->word,
    ];
});
