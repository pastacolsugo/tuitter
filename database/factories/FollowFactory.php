<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Follow>
 */
class FollowFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $follower_id = fake()->numberBetween(1, 20);
        $followee_id = fake()->numberBetween(1, 20);

        for ($i = 0; $i < 10; $i++) {
            if ($followee_id != $follower_id) {
                break;
            }
            $followee_id = fake()->numberBetween(1, 20);
        }

        return [
            'follower'=>$follower_id,
            'followee'=>$followee_id,
        ];
    }
}
