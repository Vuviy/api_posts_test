<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         \App\Models\User::factory()->create([
             'name' => 'admin',
             'email' => 'admin@admin.com',
             'email_verified_at' => now(),
             'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
             'remember_token' => Str::random(10),
             'image' => fake()->imageUrl(),
             'is_admin' => 1,
         ]);
         \App\Models\User::factory(10)->create();
         \App\Models\Post::factory(200)->create();
         \App\Models\Comment::factory(200)->create();

    }
}
