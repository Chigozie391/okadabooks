<?php

namespace App\Http\Controllers;

use App\Book;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\BookRequest;
use App\Http\Resources\BookResource;
use App\Http\Resources\AuthorResource;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class BookController extends Controller
{
	private $_fileNameToStore = '';
	
	public function __construct()
	{
		$this->middleware('auth:api')->except('index', 'show');
	}
	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function index()
	{
		return BookResource::collection(Book::paginate(10));
		
	}
	
	
	/**
	* Store a newly created resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @return \Illuminate\Http\Response
	*/
	public function store(BookRequest $request)
	{
		
		if ($request->hasFile('book_cover')) {
			$file = $request->file('book_cover');
			$this->uploadBook($file);
			unset($request['book_cover']);
			
			$request['image'] = $this->_fileNameToStore;
		}
		
		
		$request['author_id'] = auth()->user()->id;
		
		$book = new Book($request->all());
		
		$book->save();
		
		return response([
			'data' => new BookResource($book)
		],Response::HTTP_CREATED);
		
	}
	
	
	public function uploadBook($file){
		
		$fileNameWithExt = $file->getClientOriginalName();
		$fileNameWithoutExt = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
		$extension = $file->extension();
		$this->_fileNameToStore = $fileNameWithoutExt.'_'.time().'.'.$extension;
		$path = $file->storeAs('public/book_covers',$this->_fileNameToStore);
		
	}
	
	public function showAuthorBooks($id){
		
		return $user = new AuthorResource(User::findOrFail($id));
		
	}
	
	/**
	* Display the specified resource.
	*
	* @param  \App\Book  $book
	* @return \Illuminate\Http\Response
	*/
	public function show($id)
	{
		return new BookResource(Book::findOrFail($id));
	}
	
	/**
	* Update the specified resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  \App\Book  $book
	* @return \Illuminate\Http\Response
	*/
	public function update(Request $request, $id)
	{
		
		$book = Book::findOrFail($id);
		
		if(auth()->user()->id != $book->author_id){
			return response([
				'errors' => 'You can`t update this book',
			],Response::HTTP_UNAUTHORIZED);
		}
		
		
		if ($request->hasFile('book_cover')) {
			$file = $request->file('book_cover');
			$this->uploadBook($file);
			Storage::delete('public/book_covers/'.$book->image);
			unset($request['book_cover']);
			$request['image'] = $this->_fileNameToStore;
		}
		
		
		$book->update($request->all());
		
		return response([
			'data' => new BookResource($book)
		],Response::HTTP_CREATED);
	}
	
	/**
	* Remove the specified resource from storage.
	*
	* @param  \App\Book  $book
	* @return \Illuminate\Http\Response
	*/
	public function destroy($id)
	{
		$book = Book::findOrFail($id);
		
		if(auth()->user()->id != $book->author_id){
			return response([
				'errors' => 'You can`t delete this book because it doesn`t belong to you',
			],Response::HTTP_UNAUTHORIZED);
		}
		
		$book->delete();
		
		return response(null,Response::HTTP_NO_CONTENT);
	}
}
