<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;

$faker->addProvider(new \FakerRestaurant\Provider\it_IT\Restaurant($faker));

//$faker = \Faker\Factory::create('it_IT');

$factory->define(Product::class, function () use($faker) {
    return [
        'name' => $faker->unique()->vegetableName,
        'code' => mt_rand(1, '123456789'),
        'photo' => 'image.jpg',
        'price' => ceil($faker->randomFloat(2, 7, 25))
    ];
});