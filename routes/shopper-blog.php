<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/** @var array<string, class-string> $pages */
$pages = config('blog.pages');

Route::as('blog.')->prefix('blog')->group(function () use ($pages): void {
    Route::get('posts', $pages['blog.post-index'])->name('posts.index');
    Route::get('categories', $pages['blog.category-index'])->name('categories.index');
});
