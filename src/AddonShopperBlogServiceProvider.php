<?php

declare(strict_types=1);

namespace Stevymarlino\AddonShopperBlog;

use Shopper\ShopperPanel;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

final class AddonShopperBlogServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('addon-shopper-blog')
            ->hasConfigFile('blog');
        // ->hasMigrations([...])   on l'ajoutera quand les migrations existeront
    }

    public function packageRegistered(): void
    {
        $this->callAfterResolving('shopper', function (ShopperPanel $panel): void {
            $panel->addon(new BlogAddon());
        });
    }
}
