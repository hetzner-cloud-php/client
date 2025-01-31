<?php

declare(strict_types=1);

namespace HetznerCloud\Testing;

final class TestRequest
{
    /**
     * @param  list<mixed>  $args
     */
    public function __construct(
        protected string $resource,
        protected string $method,
        protected array $args)
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
