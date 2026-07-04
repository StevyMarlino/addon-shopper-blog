<?php

declare(strict_types=1);

namespace Stevymarlino\AddonShopperBlog\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Stevymarlino\AddonShopperBlog\Enums\PostStatus;
use Stevymarlino\AddonShopperBlog\Models\Category;
use Stevymarlino\AddonShopperBlog\Models\Post;

/** @extends Factory<Post> */
final class PostFactory extends Factory
{
    protected $model = Post::class;

    /** @return array<string, mixed> */
    public function definition(): array
    {
        $title = fake()->unique()->sentence(4);

        return [
            'category_id' => Category::factory(),
            'title' => $title,
            'slug' => Str::slug($title),
            'excerpt' => fake()->optional()->sentence(),
            'body' => fake()->paragraphs(3, true),
            'status' => PostStatus::Draft,
            'published_at' => null,
        ];
    }

    public function published(): self
    {
        return $this->state(fn (): array => [
            'status' => PostStatus::Published,
            'published_at' => now()->subDay(),
        ]);
    }
}
