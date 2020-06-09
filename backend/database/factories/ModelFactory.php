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

$factory->define(Client::class, function (Faker $faker) {
    return [
        'user_id' => null,
        'name' => $faker->company,
        'secret' => Str::random(40),
        'redirect' => $faker->url,
        'personal_access_client' => 0,
        'password_client' => 0,
        'revoked' => 0,
    ];
});

$factory->define(App\Company::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'description'=> $faker->text,
    ];
});

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => app('hash')->make(Str::random(10))
    ];
});

$factory->define(App\Product::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'description'=> $faker->text,
        'company_id' => $faker->randomElement(Company::pluck('id')->toArray()),
    ];
});
