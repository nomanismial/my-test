<?php

namespace Database\Factories;

use App\Models\Blog;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Blog::class;
    public function definition()
    {
        return [
            'title' => $this->faker->text(100),
            'slug' => $this->faker->slug(10),
            'status' => $this->faker->randomElement(['publish', 'draft']),
            'author_id' => Author::all()->random()->id,
            'category_id' => Category::all()->random()->id,
            'created_at' => $this->faker->dateTime()->format('d-m-Y H:i:s'),
            'content' => $this->faker->text(1000),
        ];
    }
}
