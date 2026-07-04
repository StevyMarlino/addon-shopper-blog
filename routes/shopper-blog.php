<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::as('blog.')->prefix('blog')->group(function (): void {
    Route::get('posts', config('blog.components.post-index'))->name('posts.index');
});
