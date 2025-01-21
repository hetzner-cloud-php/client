<?php

declare(strict_types=1);

namespace HetznerCloud;

use HetznerCloud\Exceptions\ApiKeyMissingException;
use HetznerCloud\HttpClientUtilities\Contracts\ConnectorContract;
use HetznerCloud\HttpClientUtilities\Http\Connector;
use HetznerCloud\HttpClientUtilities\Http\Handlers\JsonResponseHandler;
use HetznerCloud\HttpClientUtilities\ValueObjects\BaseUri;
use HetznerCloud\HttpClientUtilities\ValueObjects\Headers;
use HetznerCloud\HttpClientUtilities\ValueObjects\QueryParams;
use HetznerCloud\Support\JsonResponseSerializer;
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
    public private(set) ?ClientInterface $httpClient = null;

    /**
     * The HTTP headers for the requests.
     *
     * @var array<string, string>
     */
    public private(set) array $headers = [];

    /**
     * The query parameters to be included on each outgoing request.
     *
     * @var array<string, string|int>
     */
    public private(set) array $queryParams = [];

    /**
     * API key associated to client authenticated requests.
     */
    public private(set) ?string $apiKey = null;

    /**
     * Client connector optionally configured with global defaults.
     */
    public private(set) ?ConnectorContract $connector = null;

    public function withHttpClient(ClientInterface $client): self
    {
        $clone = clone $this;
        $clone->httpClient = $client;

        return $clone;
    }

    public function withHeader(string $name, string $value): self
    {
        $clone = clone $this;
        $clone->headers[$name] = $value;

        return $clone;
    }

    public function withQueryParam(string $name, string $value): self
    {
        $clone = clone $this;
        $clone->queryParams[$name] = $value;

        return $clone;
    }

    public function withApiKey(string $apiKey): self
    {
        $clone = clone $this;
        $clone->apiKey = $apiKey;

        return $clone;
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

        // Add the API key as a default header to be included on every request
        $headers = $headers->withCustomHeader('Authorization', "Bearer $this->apiKey");
        $baseUri = BaseUri::from(Client::API_BASE_URL);
        $queryParams = QueryParams::create();

        // As with the headers, we'll also include any query params configured on each request
        foreach ($this->queryParams as $name => $value) {
            $queryParams = $queryParams->withParam($name, $value);
        }

        if (!$this->httpClient instanceof ClientInterface) {
            $this->httpClient = Psr18ClientDiscovery::find();
        }

        $client = $this->httpClient;
        $this->connector = new Connector($client, $baseUri, $headers, $queryParams, new JsonResponseHandler);
        $serializer = new JsonResponseSerializer();

        return new Client($this->connector, $serializer);
    }
}
