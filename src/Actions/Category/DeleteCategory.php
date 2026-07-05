<?php

declare(strict_types=1);

namespace Stevymarlino\AddonShopperBlog\Actions\Category;

use Stevymarlino\AddonShopperBlog\Models\Category;

final class DeleteCategory
{
    public function handle(Category $category): void
    {
        $category->delete();
    }
}
