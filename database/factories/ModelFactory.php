<?php



// tinker >>> factory('App\User', 100)->create();
// tinker >>> factory('App\Menu', 10)->create();

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
/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});
$factory->define(App\Menu::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->word,
        'url' => $faker->url,
        'parent_id' => $faker->randomDigit,
        'order' => $faker->randomDigit,
    ];
});
$factory->define(App\Page::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->word,
        'content' => $faker->paragraph,
        'seo_title' => $faker->word,
        'seo_description' => $faker->sentence
    ];
});
