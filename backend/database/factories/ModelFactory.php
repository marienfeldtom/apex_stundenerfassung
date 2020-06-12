<?php
use App\Company as Company;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Company::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'description'=> $faker->text,
    ];
});

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'id' => '1',
        'name' => "John Doe",
        'email' => "test@test.de",
        'password' => app('hash')->make("test")
    ];
});

$factory->define(App\Product::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'description'=> $faker->text,
        'company_id' => $faker->randomElement(Company::pluck('id')->toArray()),
    ];
});
