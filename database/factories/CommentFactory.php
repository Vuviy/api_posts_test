<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'text' => fake()->text(100),
            'user_id' => User::query()->inRandomOrder()->value('id'),
            'parent_id' => Comment::query()->inRandomOrder()->value('id') ? random_int(0,1) ? Comment::query()->inRandomOrder()->value('id') : null : null,
            'commentable_type' => 'App\Models\Post',
            'commentable_id' => Post::query()->inRandomOrder()->value('id'),
        ];
    }
}
