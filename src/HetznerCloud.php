<?php

declare(strict_types=1);

namespace HetznerCloud;

use HetznerCloud\Exceptions\ApiKeyMissingException;

final class HetznerCloud
{
    /**
     * Creates a new default client instance.
     *
     * @throws ApiKeyMissingException
     */
    public static function client(string $apiKey): Client
    {
        $version = Version::getVersion();

        return self::builder()
            ->withHeader('User-Agent', "hetzner-cloud-php-client/$version")
            ->withApiKey($apiKey)
            ->build();
    }

    /**
     * Creates a new client builder to configure with custom options.
     */
    public static function builder(): Builder
    {
        return new Builder;
    }
}
