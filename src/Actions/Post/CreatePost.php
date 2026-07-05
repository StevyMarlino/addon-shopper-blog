<?php

declare(strict_types=1);

namespace Stevymarlino\AddonShopperBlog\Actions\Post;

use Stevymarlino\AddonShopperBlog\Data\PostData;
use Stevymarlino\AddonShopperBlog\Models\Post;

final class CreatePost
{
    public function handle(PostData $data): Post
    {
        return Post::query()->create($data->toArray());
    }
}
