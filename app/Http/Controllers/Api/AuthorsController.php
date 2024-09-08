<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Author;
use App\Models\Book;

class AuthorsController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $authors = Author::latest()->paginate(5);

        return new PostResource(true, 'Get List Authors Data Succesfully', $authors);
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
            'name'          => 'required',
            'bio'           => 'required',
            'birth_date'    => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $author = Author::create([
            'name'          => $request->name,
            'bio'           => $request->bio,
            'birth_date'    => $request->birth_date,
        ]);

        return new PostResource(true, 'New Author Data Created Succesfully', $author);
    }

    /**
     * show
     *
     * @param  mixed $post
     * @return void
     */
    public function show($id)
    {
        $author = Author::find($id);

        return new PostResource(true, 'Get Detail Author Data Successfully', $author);
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $post
     * @return void
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'bio'           => 'required',
            'birth_date'    => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $author = Author::find($id);

        $author->update([
            'name'          => $request->name,
            'bio'           => $request->bio,
            'birth_date'    => $request->birth_date,
        ]);

        return new PostResource(true, 'Author Data Updated Succesfully', $author);
    }

    /**
     * destroy
     *
     * @param  mixed $post
     * @return void
     */
    public function destroy($id)
    {
        $author = Author::find($id);
        $books  = Book::where('author_id', $author->id)->get();

        foreach ($books as $book) {
            $book = Book::find($book->id)->delete();
        }

        $author->delete();

        return new PostResource(true, 'Author Data Deleted Succesfully', null);
    }

    /**
     * authorBooks
     *
     * @param  mixed $post
     * @return void
     */
    public function authorBooks($id)
    {
        $author = Author::find($id);
        $books  = Book::where('author_id', $author->id)->latest()->paginate(3);
        $data   = [$author, $books];

        return new PostResource(true, 'Get Author Books Data Successfully', $data);
    }
}
