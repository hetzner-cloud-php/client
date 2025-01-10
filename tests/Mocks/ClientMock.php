<?php

declare(strict_types=1);

namespace Tests\Mocks;

use HetznerCloud\Client;
use HetznerCloud\HttpClientUtilities\Contracts\ConnectorContract;
use HetznerCloud\HttpClientUtilities\Enums\HttpMethod;
use HetznerCloud\HttpClientUtilities\ValueObjects\Connector\BaseUri;
use HetznerCloud\HttpClientUtilities\ValueObjects\Connector\Headers;
use HetznerCloud\HttpClientUtilities\ValueObjects\Connector\QueryParams;
use HetznerCloud\HttpClientUtilities\ValueObjects\Connector\Response;
use HetznerCloud\HttpClientUtilities\ValueObjects\Payload;
use Mockery;
use Psr\Http\Message\ResponseInterface;

final class ClientMock
{
    private const string BASE_URI = 'api.hetzner.cloud/v1';

    private const string DEFAULT_METHOD = 'makeRequest';

    private static ?Payload $lastPayload = null;

    public static function getLastPayload(): ?Payload
    {
        return self::$lastPayload;
    }

    public static function createForPost(
        string $resource,
        array $params,
        Response|ResponseInterface|string|null $response,
        string $methodName = self::DEFAULT_METHOD,
        bool $validateParams = true,
        array $additionalHeaders = []
    ): Client {
        return self::create(HttpMethod::POST, $resource, $params, $response, $methodName, $validateParams, $additionalHeaders);
    }

    public static function create(
        HttpMethod $method,
        string $resource,
        array $params,
        Response|ResponseInterface|string|null $response,
        string $methodName = self::DEFAULT_METHOD,
        bool $validateParams = true,
        array $additionalHeaders = [],
        bool $shouldCall = true
    ): Client {
        $connector = Mockery::mock(ConnectorContract::class);

        if ($shouldCall) {
            $connector
                ->shouldReceive($methodName)
                ->once()
                ->withArgs(function (Payload $payload) use ($method, $resource, $params, $validateParams, $additionalHeaders): bool {
                    self::setLastPayload($payload);

                    return self::validatePayload($payload, $method, $resource, $params, $validateParams, $additionalHeaders);
                })
                ->andReturn($response);
        }

        return new Client($connector, 'apiKey');
    }

    public static function createForGet(
        string $resource,
        Response|ResponseInterface|string $response,
        array $params = [],
        string $methodName = self::DEFAULT_METHOD,
        bool $validateParams = true,
        array $additionalHeaders = []
    ): Client {
        return self::create(HttpMethod::GET, $resource, $params, $response, $methodName, $validateParams, $additionalHeaders);
    }

    public static function mockClientGet(
        string $resource,
        array $params,
        Response|ResponseInterface|string $response,
        string $methodName = self::DEFAULT_METHOD,
        bool $validateParams = true,
        array $additionalHeaders = []
    ): Client {
        return self::create(HttpMethod::GET, $resource, $params, $response, $methodName, $validateParams, $additionalHeaders);
    }

    public static function reset(): void
    {
        self::$lastPayload = null;
    }

    private static function setLastPayload(Payload $payload): void
    {
        self::$lastPayload = $payload;
    }

    private static function validatePayload(
        Payload $payload,
        HttpMethod $method,
        string $resource,
        array $params,
        bool $validateParams,
        array $additionalHeaders
    ): bool {
        $headers = self::buildHeaders($additionalHeaders);
        $request = $payload->toRequest(
            BaseUri::from(self::BASE_URI),
            $headers,
            QueryParams::create()
        );

        if (! self::validateRequestBasics($request, $method, $resource)) {
            return false;
        }

        if (! $validateParams) {
            return true;
        }

        return match ($method) {
            HttpMethod::GET => self::validateGetParams($request, $params),
            HttpMethod::POST => self::validatePostBody($request, $payload, $params),
        };
    }

    private static function buildHeaders(array $additionalHeaders): Headers
    {
        $headers = Headers::create()->withAccessToken('token');

        foreach ($additionalHeaders as $name => $value) {
            $headers = $headers->withCustomHeader($name, $value);
        }

        return $headers;
    }

    private static function validateRequestBasics(mixed $request, HttpMethod $method, string $resource): bool
    {
        $path = $request->getUri()->getPath();

        return $request->getMethod() === $method->value && $path === "/v1/$resource";
    }

    private static function validateGetParams(mixed $request, array $params): bool
    {
        $query = $request->getUri()->getQuery();
        $expectedQuery = http_build_query($params);

        return $query === $expectedQuery;
    }

    private static function validatePostBody(mixed $request, Payload $payload, array $params): bool
    {
        if ($payload->includeBody) {
            $requestContents = $request->getBody()->getContents();
            $encodedParams = json_encode($params);

            return $requestContents === $encodedParams;
        }

        $size = $request->getBody()->getSize();

        return $size === null || $size === 0;
    }
}
