<?php

declare(strict_types=1);

use Stevymarlino\AddonShopperBlog\Livewire\Category\CategoryForm;
use Stevymarlino\AddonShopperBlog\Livewire\Category\CategoryIndex;
use Stevymarlino\AddonShopperBlog\Livewire\Post\PostForm;
use Stevymarlino\AddonShopperBlog\Livewire\Post\PostIndex;

return [

    /*
    |--------------------------------------------------------------------------
    | Composants surchargeables
    |--------------------------------------------------------------------------
    |
    | Le développeur final peut pointer ces clés vers ses propres classes
    | Livewire pour remplacer les composants par défaut de l'add-on.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Composants Pages
    |--------------------------------------------------------------------------
    */
    'pages' => [
        'blog.post-index' => PostIndex::class,
        'blog.category-index' => CategoryIndex::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Composants slide-overs
    |--------------------------------------------------------------------------
    */

    'components' => [
        'slide-overs.post-form' => PostForm::class,
        'slide-overs.category-form' => CategoryForm::class,
    ],

];
