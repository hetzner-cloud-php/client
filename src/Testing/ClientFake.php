<?php

declare(strict_types=1);

namespace HetznerCloud\Testing;

use Exception;
use HetznerCloud\Contracts\ClientContract;
use HetznerCloud\Contracts\Resources\ActionsResourceContract;
use HetznerCloud\Contracts\Resources\CertificatesResourceContract;
use HetznerCloud\Contracts\Resources\DatacentersResourceContract;
use HetznerCloud\Contracts\Resources\FirewallsResourceContract;
use HetznerCloud\Contracts\Resources\ServersResourceContract;
use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\Testing\Resources\ActionsTestResource;
use HetznerCloud\Testing\Resources\ServersTestResource;
use PHPUnit\Framework\Assert as PHPUnit;
use RuntimeException;
use Throwable;

final class ClientFake implements ClientContract
{
    /**
     * @var TestRequest[]
     */
    private array $requests = [];

    /**
     * @var array<int, ResponseContract<array<array-key, mixed>>|Throwable>
     */
    private array $responses;

    /**
     * @template TResponse of ResponseContract<array<array-key, mixed>>
     *
     * @param  array<int, TResponse|Throwable>  $responses
     */
    public function __construct(array $responses = [])
    {
        $this->responses = $responses;
    }

    /**
     * @template TResponse of ResponseContract
     *
     * @param  array<array-key, TResponse>  $responses
     */
    public function addResponses(array $responses): void
    {
        /** @var array<int, ResponseContract<array<array-key, mixed>>|Throwable> $merged */
        $merged = array_merge($this->responses, $responses);
        $this->responses = $merged;
    }

    public function assertSent(string $resource, callable|int|null $callback = null): void
    {
        if (is_int($callback)) {
            $this->assertSentTimes($resource, $callback);

            return;
        }

        PHPUnit::assertTrue(
            $this->sent($resource, $callback) !== [],
            "The expected resource [$resource] request was not sent."
        );
    }

    public function assertNotSent(string $resource, ?callable $callback = null): void
    {
        PHPUnit::assertCount(
            0,
            $this->sent($resource, $callback),
            "The unexpected [$resource] request was sent."
        );
    }

    public function assertNothingSent(): void
    {
        $resourceNames = implode(
            separator: ', ',
            array: array_map(fn (TestRequest $request): string => $request->resource(), $this->requests)
        );

        PHPUnit::assertEmpty($this->requests, 'The following requests were sent unexpectedly: '.$resourceNames);
    }

    /**
     * @return ResponseContract<array<array-key, mixed>>
     */
    public function record(TestRequest $request): ResponseContract
    {
        $this->requests[] = $request;
        $response = array_shift($this->responses);

        if ($response === null) {
            throw new Exception('No fake responses left.');
        }

        if ($response instanceof Throwable) {
            throw $response;
        }

        return $response;
    }

    public function servers(): ServersResourceContract
    {
        return new ServersTestResource($this);
    }

    public function actions(): ActionsResourceContract
    {
        return new ActionsTestResource($this);
    }

    public function certificates(): CertificatesResourceContract
    {
        throw new RuntimeException('Method certificates() not implemented.');
    }

    public function datacenters(): DatacentersResourceContract
    {
        throw new RuntimeException('Method datacenters() not implemented.');
    }

    public function firewalls(): FirewallsResourceContract
    {
        throw new RuntimeException('Method firewalls() not implemented.');
    }

    private function assertSentTimes(string $resource, int $times = 1): void
    {
        $count = count($this->sent($resource));

        PHPUnit::assertSame(
            $times,
            $count,
            "The expected [$resource] resource was sent $count times instead of $times times."
        );
    }

    /**
     * @param  null|callable(string, mixed...): bool  $callback
     * @return array<array-key, TestRequest>
     */
    private function sent(string $resource, ?callable $callback = null): array
    {
        if (! $this->hasSent($resource)) {
            return [];
        }

        $callback ??= fn (): bool => true;

        return array_filter(
            $this->resourcesOf($resource),
            fn (TestRequest $resource): bool => $callback($resource->method(), ...$resource->args())
        );
    }

    private function hasSent(string $resource): bool
    {
        return $this->resourcesOf($resource) !== [];
    }

    /**
     * @return array<array-key, TestRequest>
     */
    private function resourcesOf(string $type): array
    {
        return array_filter($this->requests, fn (TestRequest $request): bool => $request->resource() === $type);
    }
}
