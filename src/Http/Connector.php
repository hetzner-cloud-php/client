<?php

declare(strict_types=1);

namespace HetznerCloud\Http;

use Closure;
use GuzzleHttp\Exception\ClientException;
use HetznerCloud\Contracts\ConnectorContract;
use HetznerCloud\Enums\MediaType;
use HetznerCloud\Exceptions\ConnectorException;
use HetznerCloud\Exceptions\UnserializableResponseException;
use HetznerCloud\ValueObjects\Connector\BaseUri;
use HetznerCloud\ValueObjects\Connector\Headers;
use HetznerCloud\ValueObjects\Connector\QueryParams;
use HetznerCloud\ValueObjects\Connector\Response;
use HetznerCloud\ValueObjects\Payload;
use JsonException;
use Override;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * An HTTP client connector orchestrating requests and responses to and from Bluesky.
 *
 * @internal
 */
final class Connector implements ConnectorContract
{
    /**
     * Creates a new Http connector instance.
     */
    public function __construct(
        private readonly ClientInterface $client,
        private readonly BaseUri $baseUri,
        private Headers $headers,
        private readonly QueryParams $queryParams,
    ) {
        //
    }

    /**
     * {@inheritDoc}
     */
    #[Override]
    public function makeRequest(Payload $payload, ?string $accessToken): ?Response
    {
        return $accessToken === null
            ? $this->requestData($payload)
            : $this->requestDataWithAccessToken($payload, $accessToken);
    }

    /**
     * {@inheritDoc}
     */
    #[Override]
    public function requestData(Payload $payload): ?Response
    {
        $request = $payload->toRequest($this->baseUri, $this->headers, $this->queryParams);
        $response = $this->sendRequest(fn (): ResponseInterface => $this->client->sendRequest($request));

        if ($payload->skipResponse) {
            return null;
        }

        $contents = $response->getBody()->getContents();
        $this->throwIfJsonError($response, $contents); // @pest-mutate-ignore

        try {
            $data = json_decode($contents, true, flags: JSON_THROW_ON_ERROR); // @pest-mutate-ignore
        } catch (JsonException $jsonException) {
            throw new UnserializableResponseException($jsonException);
        }

        // @phpstan-ignore-next-line: we'll assume the $data in the response model is a valid model
        return Response::from($data);
    }

    /**
     * {@inheritDoc}
     */
    #[Override]
    public function requestDataWithAccessToken(Payload $payload, string $accessToken): ?Response
    {
        $this->headers = $this->headers->withAccessToken($accessToken);

        return self::requestData($payload);
    }

    public function getQueryParams(): QueryParams
    {
        return $this->queryParams;
    }

    #[Override]
    public function getHeaders(): Headers
    {
        return $this->headers;
    }

    #[Override]
    public function getBaseUri(): BaseUri
    {
        return $this->baseUri;
    }

    /**
     * Sends the composed request to the server.
     *
     * @throws ConnectorException|UnserializableResponseException
     */
    private function sendRequest(Closure $callable): ResponseInterface
    {
        try {
            return $callable();
        } catch (ClientExceptionInterface $clientException) {
            if ($clientException instanceof ClientException) {
                $this->throwIfJsonError($clientException->getResponse(), $clientException->getResponse()->getBody()->getContents());
            }

            throw new ConnectorException($clientException);
        }
    }

    /**
     * Analyzes the current error response to determine if the server sent us something we cannot deserialize.
     *
     * @throws UnserializableResponseException
     */
    private function throwIfJsonError(ResponseInterface $response, string|ResponseInterface $contents): void
    {
        // If we received a successful status despite sending the request throwing an exception,
        // bypass the checking for unserializable responses and propagate an connector exception
        if ($response->getStatusCode() < 400) { // @pest-mutate-ignore
            return; // @pest-mutate-ignore
        }

        // In the case the content type returned from the service is not JSON, bypass checking
        if (! str_contains($response->getHeaderLine('Content-Type'), MediaType::JSON->value)) {
            return;
        }

        if ($contents instanceof ResponseInterface) { // @pest-mutate-ignore
            $contents = $contents->getBody()->getContents();
        }

        try {
            json_decode($contents, true, flags: JSON_THROW_ON_ERROR); // @pest-mutate-ignore
        } catch (JsonException $jsonException) {
            throw new UnserializableResponseException($jsonException);
        }
    }
}
