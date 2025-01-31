<?php

declare(strict_types=1);

namespace HetznerCloud\Testing\Resources\Concerns;

use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\Testing\ClientFake;
use HetznerCloud\Testing\TestRequest;
use RuntimeException;

/**
 * @template TArray of array
 */
trait Testable
{
    public function __construct(protected ClientFake $fake) {}

    abstract protected function resource(): string;

    public function assertSent(?callable $callback = null): void
    {
        $this->fake->assertSent($this->resource(), $callback);
    }

    public function assertNotSent(?callable $callback = null): void
    {
        $this->fake->assertNotSent($this->resource(), $callback);
    }

    /**
     * @template TResponse of ResponseContract
     *
     * @param  list<mixed>  $args
     * @param  class-string<TResponse>  $expectedType
     * @return TResponse
     */
    protected function record(string $method, array $args = [], string $expectedType = ResponseContract::class): ResponseContract
    {
        $response = $this->fake->record(new TestRequest($this->resource(), $method, $args));

        if (! $response instanceof $expectedType) {
            throw new RuntimeException(sprintf(
                'Expected response of type %s, got %s',
                $expectedType,
                get_class($response)
            ));
        }

        return $response;
    }
}
