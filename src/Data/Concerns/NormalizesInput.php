<?php

declare(strict_types=1);

namespace Stevymarlino\AddonShopperBlog\Data\Concerns;

trait NormalizesInput
{
    private static function toString(mixed $value): ?string
    {
        return filled($value) ? (string) $value : null;
    }

    private static function toInt(mixed $value): ?int
    {
        return filled($value) ? (int) $value : null;
    }
}
