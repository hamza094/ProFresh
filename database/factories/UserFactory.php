<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Project;
use App\ProjectScore;
use Faker\Generator as Faker;
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

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});

$factory->define(Project::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'mobile'=>6785434567,
        'stage'=>1,
        'user_id'=>function () {
            return factory('App\User')->create()->id;
        },
    ];
});


$factory->define(ProjectScore::class, function (Faker $faker) {
    return [
        'project_id' => function () {
            return factory('App\Project')->create()->id;
        },
        'message' => 'hy berry',
        'point'=>'Admin'
    ];
});

$factory->define(App\Task::class, function (Faker $faker) {
    return [
         'project_id'=>function () {
            return factory('App\Project')->create()->id;
        },
        'body' => $faker->sentence,
        'completed'=>false
    ];
});

$factory->define(App\Appointment::class, function (Faker $faker) {
    return [
         'project_id'=>function () {
            return factory('App\Project')->create()->id;
        },
        'title' => $faker->name,
        'location'=>'mine avnue',
        'outcome'=>'intrested',
        'strtdt'=>'2020-11-14',
        'strttm'=>'04:15',
        'zone'=>'Asia/Hong_Kong',
    ];
});

$factory->define(App\Group::class, function (Faker $faker) {
    return [
       'name'=> $faker->name,
        'project_id' => 1,
    ];
});
