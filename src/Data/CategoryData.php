<?php

declare(strict_types=1);

namespace Stevymarlino\AddonShopperBlog\Data;

use Stevymarlino\AddonShopperBlog\Data\Concerns\NormalizesInput;

final readonly class CategoryData
{
    use NormalizesInput;

    public function __construct(
        public string $name,
        public ?string $description,
        public ?string $slug = null,
    ) {}

    /**
     * @param  array<string, mixed>  $state
     */
    public static function fromArray(array $state): self
    {
        return new self(
            name: self::toString($state['name']),
            description: self::toString($state['description'] ?? null),
            slug: self::toString($state['slug'] ?? null),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug ?? null,
            'description' => $this->description,
        ];
    }
}
