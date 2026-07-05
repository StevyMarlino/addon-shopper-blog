<?php

declare(strict_types=1);

namespace Stevymarlino\AddonShopperBlog\Actions\Category;

use Stevymarlino\AddonShopperBlog\Data\CategoryData;
use Stevymarlino\AddonShopperBlog\Models\Category;

final class CreateCategory
{
    public function handle(CategoryData $data): Category
    {
        return Category::query()->create($data->toArray());
    }
}
