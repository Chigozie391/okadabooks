<?php

namespace App\Http\Resources;

use App\Http\Resources\AuthorBookCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
			  'name' => $this->name,
				'email' => $this->email,
				'books' => AuthorBookCollection::collection($this->books)
				
		  ];
    }
}
