<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::as('blog.')->prefix('blog')->group(function (): void {
    // Route blog à créer
});
