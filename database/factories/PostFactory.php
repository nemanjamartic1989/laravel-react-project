<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'     => User::factory(),
            'title'       => $this->faker->sentence(6),
            'description' => $this->faker->paragraph(3),
            'image' => function () {
                $source = public_path('images/default-photo.jpg');
                $targetDir = storage_path('app/public/images');

                if (!file_exists($targetDir)) {
                    mkdir($targetDir, 0775, true);
                }

                $newFile = $targetDir.'/'.uniqid().'_default.jpg';

                copy($source, $newFile);

                return 'images/' . basename($newFile);
            },
            'created_at'  => now(),
            'updated_at'  => now(),
        ];
    }
}
