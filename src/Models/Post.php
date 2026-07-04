<?php

declare(strict_types=1);

namespace Stevymarlino\AddonShopperBlog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Stevymarlino\AddonShopperBlog\Database\Factories\PostFactory;
use Stevymarlino\AddonShopperBlog\Enums\PostStatus;

/**
 * @property-read int $id
 * @property int|null $category_id
 * @property string $title
 * @property string $slug
 * @property string|null $excerpt
 * @property string|null $body
 * @property PostStatus $status
 * @property Carbon|null $published_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon|null $deleted_at
 */
class Post extends Model implements HasMedia
{
    /** @use HasFactory<PostFactory> */
    use HasFactory;

    use InteractsWithMedia;
    use SoftDeletes;

    protected $table = 'blog_posts';

    /** @var list<string> */
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'excerpt',
        'body',
        'status',
        'published_at',
    ];

    public function registerMediaCollections(): void
    {
        /** @var string $disk */
        $disk = config('shopper.media.storage.disk_name', 'public');

        /** @var array<string> $mimeTypes */
        $mimeTypes = config('shopper.media.accepts_mime_types', ['image/jpeg', 'image/png', 'image/webp', 'image/avif']);

        $this->addMediaCollection('cover')
            ->singleFile()
            ->useDisk($disk)
            ->acceptsMimeTypes($mimeTypes);
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $conversion = $this->addMediaConversion('thumb');
        $conversion->width(400)->height(300);
    }

    /** @return BelongsTo<Category, $this> */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function isPublished(): bool
    {
        return $this->status === PostStatus::Published
            && $this->published_at !== null
            && $this->published_at->isPast();
    }

    protected static function newFactory(): PostFactory
    {
        return PostFactory::new();
    }

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'status' => PostStatus::class,
            'published_at' => 'datetime',
        ];
    }
}
