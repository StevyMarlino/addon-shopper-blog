<?php

declare(strict_types=1);

use Stevymarlino\AddonShopperBlog\Livewire\PostIndex;

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

    'components' => [
        'post-form' => PostForm::class,
        'post-index' => PostIndex::class,
        'category-index' => CategoryIndex::class,
    ],

];
