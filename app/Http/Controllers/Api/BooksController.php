<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Book;

class BooksController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $books = Book::latest()->paginate(5);

        return new PostResource(true, 'Get List Books Data Succesfully', $books);
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'         => 'required',
            'description'   => 'required',
            'publish_date'  => 'required',
            'author_id'     => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $book = Book::create([
            'title'         => $request->title,
            'description'   => $request->description,
            'publish_date'  => $request->publish_date,
            'author_id'     => $request->author_id,
        ]);

        return new PostResource(true, 'New Book Data Created Succesfully', $book);
    }

    /**
     * show
     *
     * @param  mixed $post
     * @return void
     */
    public function show($id)
    {
        $book = Book::find($id);

        return new PostResource(true, 'Get Detail Book Data Successfully', $book);
    }

    /**
     * update
     *
     * @param  mixed $request
     * @return void
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title'         => 'required',
            'description'   => 'required',
            'publish_date'  => 'required',
            'author_id'     => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $book = Book::find($id);

        $book->update([
            'title'         => $request->title,
            'description'   => $request->description,
            'publish_date'  => $request->publish_date,
            'author_id'     => $request->author_id,
        ]);

        return new PostResource(true, 'Book Data Updated Succesfully', $book);
    }

    /**
     * destroy
     *
     * @param  mixed $post
     * @return void
     */
    public function destroy($id)
    {
        $book = Book::find($id);

        $book->delete();

        return new PostResource(true, 'Book Data Deleted Succesfully', null);
    }
}
