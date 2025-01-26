<?php

declare(strict_types=1);

namespace HetznerCloud\Testing\Responses\Concerns;

trait Fakeable
{
    /**
     * @param  array<string, mixed>  $override
     */
    public static function fake(array $override = []): static
    {
        $class = str_replace('Responses\\', 'Testing\\Responses\\Fixtures\\', static::class).'Fixture';

        return static::from(
            self::buildAttributes($class::ATTRIBUTES, $override)
        );
    }

    private static function buildAttributes(array $original, array $override): array
    {
        $new = [];

        foreach ($original as $key => $entry) {
            $new[$key] = is_array($entry) ?
                self::buildAttributes($entry, $override[$key] ?? []) :
                $override[$key] ?? $entry;
            unset($override[$key]);
        }

        // we are going to append all remaining overrides
        foreach ($override as $key => $value) {
            $new[$key] = $value;
        }

        return $new;
    }
}
