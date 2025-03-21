<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'content' => fake()->paragraph(),
            'user_id' => User::factory(),
            'post_id' => Post::factory(),
            'parent_id' => null,
            'created_at' => fake()->dateTimeBetween('-2 months', 'now'),
            'updated_at' => function (array $attributes) {
                // 10% chance the comment was updated after creation
                return rand(1, 10) == 1 
                    ? fake()->dateTimeBetween($attributes['created_at'], 'now')
                    : $attributes['created_at'];
            },
        ];
    }
}
