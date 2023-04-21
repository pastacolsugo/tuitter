<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
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
        $reply_to_post_id = fake()->optional($weight = 0.2, $default = null)->numberBetween(1, 20);

        if ($reply_to_post_id) {
            if (Post::where('id', $reply_to_post_id)->count() == 0) {
                $reply_to_post_id = null;
            }
        }

        return [
            'author_id' => fake()->numberBetween(1, 20),
            'content' => fake()->sentence(),
            'reply_to_post_id' => $reply_to_post_id,
        ];
    }
}
