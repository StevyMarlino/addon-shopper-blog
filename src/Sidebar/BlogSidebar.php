<?php

declare(strict_types=1);

namespace Stevymarlino\AddonShopperBlog\Sidebar;

use Shopper\Sidebar\AbstractAdminSidebar;
use Shopper\Sidebar\Contracts\Builder\Group;
use Shopper\Sidebar\Contracts\Builder\Item;
use Shopper\Sidebar\Contracts\Builder\Menu;

final class BlogSidebar extends AbstractAdminSidebar
{
    public function extendWith(Menu $menu): Menu
    {
        $menu->group(__('Content'), function (Group $group): void {
            $group->weight(5);
            $group->setAuthorized();
            $group->collapsible();

            $group->item(__('Blog Posts'), function (Item $item): void {
                $item->weight(1);
                $item->useSpa();
                $item->route('shopper.blog.posts.index');
                $item->setIcon('untitledui-file-02');
            });

            $group->item(__('Blog Categories'), function (Item $item): void {
                $item->weight(2);
                $item->useSpa();
                $item->route('shopper.blog.categories.index');
                $item->setIcon('untitledui-shopping-bag-02');
            });
        });

        return $menu;
    }
}
