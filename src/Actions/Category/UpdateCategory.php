<?php

declare(strict_types=1);

namespace Stevymarlino\AddonShopperBlog\Actions\Category;

use Stevymarlino\AddonShopperBlog\Data\CategoryData;
use Stevymarlino\AddonShopperBlog\Models\Category;

final class UpdateCategory
{
    public function handle(Category $category, CategoryData $data): Category
    {
        $category->update($data->toArray());

        return $category;
    }
}
