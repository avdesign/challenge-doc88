<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;

/******************      PASTEIS VEGETARIANOS    *************************/

$faker->addProvider(new \FakerRestaurant\Provider\it_IT\Restaurant($faker));

$factory->define(Product::class, function () use($faker) {
    return [
        'name' => $faker->unique()->vegetableName,
        'code' => $faker->unique()->numberBetween(10,50),
        'photo' => 'image.jpg',
        'price' => ceil($faker->randomFloat(2, 7, 25))
    ];
});