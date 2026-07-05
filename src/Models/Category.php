<?php

declare(strict_types=1);

namespace Stevymarlino\AddonShopperBlog\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Shopper\Core\Models\Traits\HasSlug;
use Stevymarlino\AddonShopperBlog\Database\Factories\CategoryFactory;

/**
 * @property-read int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read Collection<int, Post> $posts
 */
class Category extends Model
{
    /** @use HasFactory<CategoryFactory> */
    use HasFactory;

    use HasSlug;

    protected $table = 'blog_categories';

    /** @var list<string> */
    protected $fillable = ['name', 'slug', 'description'];

    /** @return HasMany<Post, $this> */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    protected static function booted(): void
    {
        static::saving(function (Category $category): void {
            if (blank($category->slug) && filled($category->name)) {
                $category->slug = $category->name;
            }
        });
    }

    protected static function newFactory(): CategoryFactory
    {
        return CategoryFactory::new();
    }
}
