<?php

declare(strict_types=1);

namespace Stevymarlino\AddonShopperBlog;

use Shopper\Addon\BaseAddon;
use Shopper\ShopperPanel;
use Stevymarlino\AddonShopperBlog\Sidebar\BlogSidebar;

final class BlogAddon extends BaseAddon
{
    public function getId(): string
    {
        return 'blog';
    }

    public function register(ShopperPanel $panel): void
    {
        /** @var array<string, class-string> $pages */
        $pages = config('blog.pages', []);

        /** @var array<string, class-string> $components */
        $components = config('blog.components', []);

        $panel
            ->addonRoutes(fn () => require __DIR__.'/../routes/shopper-blog.php')
            ->addonSidebar(BlogSidebar::class)
            ->addonViews('shopper-blog', __DIR__.'/../resources/views')
            ->addonLivewireComponents(array_merge($pages, $components))
            ->addonPermissions(['browse_blog', 'manage_blog']);
    }
}
