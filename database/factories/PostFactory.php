<?php

namespace Database\Factories;

use App\Models\User;
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
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(rand(4, 8)),
            'content' => fake()->paragraphs(rand(3, 7), true),
            'user_id' => User::factory(),
            'created_at' => fake()->dateTimeBetween('-3 months', 'now'),
            'updated_at' => function (array $attributes) {
                // 30% chance the post was updated after creation
                return rand(1, 10) <= 3 
                    ? fake()->dateTimeBetween($attributes['created_at'], 'now')
                    : $attributes['created_at'];
            },
        ];
    }
}
