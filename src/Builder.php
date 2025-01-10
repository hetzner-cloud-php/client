<?php

declare(strict_types=1);

namespace HetznerCloud;

use HetznerCloud\Exceptions\ApiKeyMissingException;
use HetznerCloud\HttpClientUtilities\Contracts\ConnectorContract;
use HetznerCloud\HttpClientUtilities\Http\Connector;
use HetznerCloud\HttpClientUtilities\Http\Handlers\JsonResponseHandler;
use HetznerCloud\HttpClientUtilities\ValueObjects\Connector\BaseUri;
use HetznerCloud\HttpClientUtilities\ValueObjects\Connector\Headers;
use HetznerCloud\HttpClientUtilities\ValueObjects\Connector\QueryParams;
use Http\Discovery\Psr18ClientDiscovery;
use Psr\Http\Client\ClientInterface;

/**
 * Client builder/factory for configuring the API connector to the Hetzner Cloud API.
 */
final class Builder
{
    /**
     * The HTTP client for the requests.
     */
    private ?ClientInterface $httpClient = null;

    /**
     * The HTTP headers for the requests.
     *
     * @var array<string, string>
     */
    private array $headers = [];

    /**
     * The query parameters to be included on each outgoing request.
     *
     * @var array<string, string|int>
     */
    private array $queryParams = [];

    /**
     * The endpoint to send calls to. Bluesky offers a public API as well, but we default to the authenticated API.
     */
    private string $baseUri = Client::API_BASE_URL;

    /**
     * API key associated to client authenticated requests.
     */
    private ?string $apiKey = null;

    private ?ConnectorContract $connector = null;

    /**
     * Sets the HTTP client for the requests. If no client is provided the
     * factory will try to find one using PSR-18 HTTP Client Discovery.
     */
    public function withHttpClient(ClientInterface $client): self
    {
        $this->httpClient = $client;

        return $this;
    }

    /**
     * Adds a custom header to each outgoing request.
     */
    public function withHeader(string $name, string $value): self
    {
        $this->headers[$name] = $value;

        return $this;
    }

    /**
     * Adds a custom query parameter to the request url for each outgoing request.
     */
    public function withQueryParam(string $name, string $value): self
    {
        $this->queryParams[$name] = $value;

        return $this;
    }

    /**
     * The username associated to the client instance.
     */
    public function withApiKey(string $apiKey): self
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * Creates a new Hetzner Cloud client based on the provided builder options.
     */
    public function build(): Client
    {
        if ($this->apiKey === null) {
            throw new ApiKeyMissingException;
        }

        $headers = Headers::create();

        // For any default headers configured for the client, we'll add those to each outbound request
        foreach ($this->headers as $name => $value) {
            $headers = $headers->withCustomHeader($name, $value);
        }

        $baseUri = BaseUri::from($this->baseUri);
        $queryParams = QueryParams::create();

        // As with the headers, we'll also include any query params configured on each request
        foreach ($this->queryParams as $name => $value) {
            $queryParams = $queryParams->withParam($name, $value);
        }

        $client = $this->httpClient ??= Psr18ClientDiscovery::find();
        $this->connector = new Connector($client, $baseUri, $headers, $queryParams, new JsonResponseHandler);

        return new Client($this->connector, $this->apiKey);
    }

    public function getHttpClient(): ?ClientInterface
    {
        return $this->httpClient;
    }

    public function getConnector(): ?ConnectorContract
    {
        return $this->connector;
    }

    /**
     * @return array<string, string>
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @return array<string, string|int>
     */
    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    public function getApiKey(): ?string
    {
        return $this->apiKey;
    }

    public function getBaseUri(): string
    {
        return $this->baseUri;
    }
}
