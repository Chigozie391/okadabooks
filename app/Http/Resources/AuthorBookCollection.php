<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AuthorBookCollection extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
			  'title' => $this->title,
			  'description' => $this->description,
			  'book_cover' => $this->image,
			  'published_date' => $this->created_at
		  ];
    }
}
