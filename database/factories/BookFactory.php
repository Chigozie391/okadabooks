<?php

use App\Book;
use App\User;
use Faker\Generator as Faker;

$factory->define(App\Book::class, function (Faker $faker) {
	return [
		'title' => $faker->word,
		'description' => $faker->paragraph,
		'author_id' => function(){
			return User::all()->random();
		},
	];
});
