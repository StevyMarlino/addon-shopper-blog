<?php

declare(strict_types=1);

namespace Stevymarlino\AddonShopperBlog\Data;

use Illuminate\Support\Carbon;
use Stevymarlino\AddonShopperBlog\Data\Concerns\NormalizesInput;
use Stevymarlino\AddonShopperBlog\Enums\PostStatus;

final readonly class PostData
{
    use NormalizesInput;

    public function __construct(
        public string $title,
        public ?int $categoryId,
        public ?string $excerpt,
        public ?string $body,
        public PostStatus $status,
        public ?Carbon $publishedAt,
        public ?string $slug = null,
    ) {}

    /**
     * @param  array<string, mixed>  $state
     */
    public static function fromArray(array $state): self
    {
        $status = $state['status'] ?? PostStatus::Draft->value;
        $publishedAt = $state['published_at'] ?? null;

        return new self(
            title: self::toString($state['title'] ?? null),
            categoryId: self::toInt($state['category_id'] ?? null),
            excerpt: self::toString($state['excerpt'] ?? null),
            body: self::toString($state['body'] ?? null),
            status: $status instanceof PostStatus ? $status : PostStatus::from((string) $status),
            publishedAt: $publishedAt instanceof Carbon
                ? $publishedAt
                : (filled($publishedAt) ? Carbon::parse((string) $publishedAt) : null),
            slug: self::toString($state['slug'] ?? null),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'category_id' => $this->categoryId,
            'excerpt' => $this->excerpt,
            'body' => $this->body,
            'status' => $this->status,
            'published_at' => $this->publishedAt,
        ];
    }
}
