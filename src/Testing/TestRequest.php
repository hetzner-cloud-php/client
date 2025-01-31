<?php

declare(strict_types=1);

namespace HetznerCloud\Testing;

final readonly class TestRequest
{
    /**
     * @param  list<mixed>  $args
     */
    public function __construct(
        private string $resource,
        private string $method,
        private array $args)
    {
        //
    }

    public function resource(): string
    {
        return $this->resource;
    }

    public function method(): string
    {
        return $this->method;
    }

    /**
     * @return list<mixed>
     */
    public function args(): array
    {
        return $this->args;
    }
}
