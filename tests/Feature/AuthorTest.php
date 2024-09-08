<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Author;

class AuthorTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function list_authors()
    {
        $author     = Author::factory()->create();
        $response   = $this->get('/api/authors');
        $response->assertStatus(200);
    }

    /** @test */
    public function show_author()
    {
        $author     = Author::factory()->create();
        $response   = $this->get('/api/authors/'. $author->id);

        $response->assertStatus(200);
    }

    /** @test */
    public function create_author()
    {
        $author     = Author::factory()->make();
        $response   = $this->post('/api/authors', $author->toArray());

        $response->assertStatus(201);
    }

    /** @test */
    public function update_author()
    {
        $author = Author::factory()->create();

        $data   = [
            'name'          => 'Author Update',
            'bio'           => 'author-update',
            'birth_date'    => '2000-10-002'
        ];
        
        $response = $this->put('/api/authors/'. $author->id, $data);

        $response->assertStatus(200);
    }

    /** @test */
    public function delete_author()
    {
        $author     = Author::factory()->create();
        $response   = $this->delete('api/authors/'. $author->id);
        $response->assertStatus(200);
    }
}
