<?php

declare(strict_types=1);

namespace Stevymarlino\AddonShopperBlog\Actions\Post;

use Stevymarlino\AddonShopperBlog\Models\Post;

final class DeletePost
{
    public function handle(Post $post): void
    {
        $post->delete();
    }
}
