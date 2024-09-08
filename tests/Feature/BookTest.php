<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Author;
use App\Models\Book;

class BookTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function list_books()
    {
        $book       = Book::factory()->create();
        $response   = $this->get('/api/books');
        $response->assertStatus(200);
    }

    /** @test */
    public function show_book()
    {
        $book       = Book::factory()->create();
        $response   = $this->get('/api/books/'. $book->id);

        $response->assertStatus(200);
    }

    /** @test */
    public function create_book()
    {
        $book       = Book::factory()->make();
        $response   = $this->post('/api/books', $book->toArray());

        $response->assertStatus(201);
    }

    public function update_book()
    {
        $author = Author::factory()->create();
        $book   = Book::factory()->create();

        $data   = [
            'title'         => 'book Update',
            'description'   => 'book-update',
            'publish_date'  => '2000-10-002',
            'author_id'     => $author->id
        ];
        
        $response = $this->put('/api/books/'. $book->id, $data);

        $response->assertStatus(200);
    }

    /** @test */
    public function delete_book()
    {
        $book       = Book::factory()->create();
        $response   = $this->delete('api/books/'. $book->id);
        $response->assertStatus(200);
    }
}
