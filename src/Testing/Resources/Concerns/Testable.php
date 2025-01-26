<?php

declare(strict_types=1);

namespace HetznerCloud\Testing\Resources\Concerns;

use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\Testing\ClientFake;
use HetznerCloud\Testing\TestRequest;

trait Testable
{
    public function __construct(protected ClientFake $fake) {}

    abstract protected function resource(): string;

    public function assertSent(callable|int|null $callback = null): void
    {
        $this->fake->assertSent($this->resource(), $callback);
    }

    public function assertNotSent(callable|int|null $callback = null): void
    {
        $this->fake->assertNotSent($this->resource(), $callback);
    }

    /**
     * @param  array<string, mixed>  $args
     */
    protected function record(string $method, array $args = []): ResponseContract
    {
        return $this->fake->record(new TestRequest($this->resource(), $method, $args));
    }
}
