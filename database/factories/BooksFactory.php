<?php

use App\User;
use function foo\func;
use Faker\Generator as Faker;

$factory->define(App\Books::class, function (Faker $faker) {
    return [
		  'title' => $faker->name,
		  'description' => $faker->paragraph,
		  'author_id' => function(){
			  return User::all()->random();
		  },


    ];
});
