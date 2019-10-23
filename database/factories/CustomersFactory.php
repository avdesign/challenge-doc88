<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Customer;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$faker = \Faker\Factory::create('pt_BR');

$districts = [
    'Butantã',
    'Morumbi',
    'Raposo Tavares',
    'Rio Pequeno',
    'Vila Sônia',
    'Lapa',
    'Barra Funda',
    'Jaguara',
    'Jaguaré',
    'Perdizes',
    'Vila Leopoldina',
    'Pinheiros',
    'Alto de Pinheiros',
    'Itaim Bibi',
    'Jardim Paulista',
    'Pinheiros'
];

$factory->define(Customer::class, function () use($faker, $districts) {

    return [
        'code' => $faker->unique()->ean13,
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'phone' => cellNumbers('(11)'),
        'address' => "{$faker->streetName}, {$faker->buildingNumber}",
        'complement' => $faker->secondaryAddress,
        'district' => wordsShuffle($districts),
        'zipcode' => $faker->postcode,
        'birth_date' => $faker->dateTimeBetween('1990-01-01', '2012-12-31')->format('d/m/Y'),
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});
