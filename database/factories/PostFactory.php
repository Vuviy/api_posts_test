<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
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
            'title' => fake()->words(5, true),
            'text' => fake()->text(100),
            'publish_at' => random_int(0,1) ? now() : null,
            'user_id' => User::query()->inRandomOrder()->value('id'),
        ];
    }
}
