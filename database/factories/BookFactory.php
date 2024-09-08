<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Author;
use App\Models\Book;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'         => $this->faker->words(3, true),
            'description'   => $this->faker->sentence(5),
            'publish_date'  => $this->faker->date,
            'author_id'     => function() {
                return Author::factory()->create()->id;
            }
        ];
    }
}
