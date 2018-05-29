<?php

use Faker\Generator as Faker;
use App\Order;
use App\Customer;

$factory->define(App\Order::class, function (Faker $faker) {
    return [
        'customer_id' => function() {
            return factory(Customer::class)->create()->id;
        },
        'total' => $faker->randomFloat(2, 0, 9999),
    ];
});
