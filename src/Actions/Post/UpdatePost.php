<?php

declare(strict_types=1);

namespace Stevymarlino\AddonShopperBlog\Actions\Post;

use Stevymarlino\AddonShopperBlog\Data\PostData;
use Stevymarlino\AddonShopperBlog\Models\Post;

final class UpdatePost
{
    public function handle(Post $post, PostData $data): Post
    {
        $post->update($data->toArray());

        return $post;
    }
}
