<?php

declare(strict_types=1);

namespace HetznerCloud\ValueObjects\Connector;

use HetznerCloud\Contracts\Concerns\Arrayable;
use HetznerCloud\Enums\MediaType;
use Override;

/**
 * A value object for encapsulating headers to be used on requests.
 *
 * @implements Arrayable<array<string, string>>
 */
final readonly class Headers implements Arrayable
{
    /**
     * Creates a new Headers value object.
     *
     * @param  array<string, string>  $headers
     */
    private function __construct(private array $headers)
    {
        //
    }

    /**
     * Creates a new Headers value object.
     */
    public static function create(): self
    {
        return new self([]);
    }

    /**
     * Creates a new Headers value object, with the given content type, and the existing headers.
     */
    public function withAccept(MediaType $mediaType, string $suffix = ''): self
    {
        return new self([
            ...$this->headers,
            'Accept' => $mediaType->value.$suffix,
        ]);
    }

    public function withContentType(MediaType $mediaType, string $suffix = ''): self
    {
        return new self([
            ...$this->headers,
            'Content-Type' => $mediaType->value.$suffix,
        ]);
    }

    public function withAccessToken(string $accessToken): self
    {
        return new self([
            ...$this->headers,
            'Authorization' => 'Bearer '.$accessToken,
        ]);
    }

    /**
     * Creates a new Headers value object, with the newly added header, and the existing headers.
     */
    public function withCustomHeader(string $name, string $value): self
    {
        return new self([
            ...$this->headers,
            $name => $value,
        ]);
    }

    #[Override]
    public function toArray(): array
    {
        return $this->headers;
    }
}
