<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;


use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'slug' => $this->faker->unique()->slug,
            'body' => $this->faker->paragraph,
            'created_at' => $this->faker->date,
        ];
    }
}
