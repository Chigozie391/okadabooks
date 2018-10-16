<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{

	protected $fillable = [
		'title', 'description', 'image', 'author_id'
	];

    public function author(){
		return $this->belongsTo(User::class);
	 }
}
