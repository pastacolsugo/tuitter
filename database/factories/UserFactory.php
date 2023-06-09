<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'username' => fake()->unique()->word(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'profile_pic_asset' => $this->profile_pictures_assets[array_rand($this->profile_pictures_assets, 1)],
            'bio' => fake()->sentence(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    private $profile_pictures_assets = array(
        'profile_pictures/cat_0.jpeg',
        'profile_pictures/cat_1.jpeg',
        'profile_pictures/cat_2.jpeg',
        'profile_pictures/cat_3.jpeg',
        'profile_pictures/cat_4.jpeg',
        'profile_pictures/cat_5.jpeg',
        'profile_pictures/cat_6.jpeg',
        'profile_pictures/cat_6.jpeg',
        'profile_pictures/cat_7.jpeg',
        'profile_pictures/pepe.jpeg',
        'profile_pictures/gumball.jpeg',
        'profile_pictures/harold.jpeg',
        'profile_pictures/hasbulla.jpeg',
        'profile_pictures/leo.jpeg',
        'profile_pictures/paperinoh.jpeg',
        'profile_pictures/pepe.jpeg',
        'profile_pictures/pickachu.jpeg',
        'profile_pictures/spongebob.jpeg',
        'profile_pictures/will_shrek.jpeg',
    );
}
