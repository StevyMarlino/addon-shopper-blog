<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withPaths([
        __DIR__.'/config',
        __DIR__.'/src',
        __DIR__.'/routes',
        __DIR__.'/tests',
    ])
    ->withSets([

    ])
    ->withTypeCoverageLevel(8)
    ->withCodeQualityLevel(0)
    ->withPreparedSets(
        deadCode: true,
        earlyReturn: true,
    );
