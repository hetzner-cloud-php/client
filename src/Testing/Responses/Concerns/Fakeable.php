<?php

declare(strict_types=1);

namespace HetznerCloud\Testing\Responses\Concerns;

use HetznerCloud\Testing\Fixtures\AbstractDataFixture;

/**
 * @template-covariant TData of array
 */
trait Fakeable
{
    /**
     * @param  array<string, mixed>  $override
     */
    public static function fake(array $override = []): static
    {
        /** @var class-string<AbstractDataFixture> $class */
        $class = str_replace('Responses\\Resources\\', 'Testing\\Fixtures\\', static::class).'Fixture';
        $class = str_replace('ResponseFixture', 'Fixture', $class);

        /** @var array<string, mixed> $currentAttributes */
        $currentAttributes = $class::data();

        /** @var TData */
        $attributes = self::buildAttributes($currentAttributes, $override);

        return static::from($attributes);
    }

    /**
     * @param  array<array-key, mixed>  $original
     * @param  array<array-key, mixed>  $override
     * @return array<array-key, mixed>
     */
    private static function buildAttributes(array $original, array $override): array
    {
        $new = [];

        foreach ($original as $key => $entry) {
            /** @var mixed $value */
            $value = $override[$key] ?? null;

            $new[$key] = is_array($entry) && is_array($value)
                ? self::buildAttributes($entry, $value)
                : ($value ?? $entry);

            unset($override[$key]);
        }

        // Append all remaining overrides
        foreach ($override as $key => $value) {
            $new[$key] = $value;
        }

        return $new;
    }
}
